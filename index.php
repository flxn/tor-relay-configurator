<?php

require 'vendor/autoload.php';
require 'utils.php';
require 'TorConfig.php';
require 'TRCStats.php';

date_default_timezone_set('UTC');

Flight::set('serverCount', '-');
Flight::set('combinedUptime', '-');
Flight::set('combinedBandwidth', '-');

if(file_exists('misc/stats.txt')) {
  $fh = fopen('misc/stats.txt', 'r');
  $stats = new TRCStats();
  Flight::set('serverCount', intval(fgets($fh, 4096)));
  Flight::set('combinedUptime', round(intval(fgets($fh, 4069))/60/60) . 'h');
  Flight::set('combinedBandwidth', round(intval(fgets($fh, 4069))*8/1000/1000) . 'Mb/s');
  Flight::set('currentCommit', trim(exec('git log --pretty="%h" -n1 HEAD')));
  Flight::set('bandwidthChartJson', json_encode($stats->getBandwidthOverTime(60)));
  Flight::set('nodesChartJson', json_encode($stats->getNodesOverTime(60)));
  fclose($fh);
}

Flight::set('nodeslist', array());
if(file_exists('misc/nodes.txt')) {
    $nodes = explode("\n", file_get_contents('misc/nodes.txt'));
    $nodeslist = array();
    foreach ($nodes as $node) {
        if(trim($node) == "") continue;
        list($name, $bandwidth) = explode(';', $node);
        $bandwidth = round($bandwidth * 8 / 1000 / 1000, 2);
        $nodeslist[] = array('name' => $name, 'bandwidth' => $bandwidth);
    }
    Flight::set('nodeslist', $nodeslist);
}

Flight::route('GET /', function () {
    Flight::render('main', array('errors' => ''), 'main_content');
    Flight::render('layout', array(
      'title' => 'Tor Relay Configurator',
      'serverCount' => Flight::get('serverCount'),
      'combinedUptime' => Flight::get('combinedUptime'),
      'combinedBandwidth' => Flight::get('combinedBandwidth'),
      'currentCommit' => Flight::get('currentCommit'),
      'nodes' => Flight::get('nodeslist'),
      'bandwidthChartData' => Flight::get('bandwidthChartJson'),
      'nodesChartData' => Flight::get('nodesChartJson')
    ));
});

Flight::route('POST /', function () {
  $req = Flight::request();
  try {
      $torConfig = new TorConfig($req->data);

      $torrc = $torConfig->getTorrc();

      $generatedScriptHash = md5(implode(',', $req->data->getData()));
      $scriptFile = $generatedScriptHash.'.sh';

      // Load script template and replace template variables
      $template = file_get_contents('misc/install.template');
      $template = str_replace('%RELEASE%', escapeshellcmd($req->data['os']), $template);
      $template = str_replace('%TORRC%', $torrc, $template);
      $template = str_replace('%ARM%', isset($req->data['enable-arm']) ? 'true' : 'false', $template);
      $template = str_replace('%EXIT%', ($req->data['node-type'] == 'exit') ? 'true' : 'false', $template);
      $template = str_replace('%CHECKIPV6%', isset($req->data['ipv6']) ? 'true' : 'false', $template);
      $template = str_replace('%ENABLE_AUTO_UPDATE%', isset($req->data['unattended-upgrades']) ? 'true' : 'false', $template);

      // Write script to file
      if (!file_exists('userconfigs/')) {
          mkdir('userconfigs/', 0777, true);
      }

      file_put_contents('userconfigs/'.$scriptFile, $template);

      Flight::render('installation', array(
        'torrc' => $torrc,
        'configFile' => $scriptFile,
        'arm' => isset($req->data['enable-arm']),
      ), 'main_content');
  } catch (Exception $e) {
      Flight::render('main', array('errors' => $e->getMessage()), 'main_content');
  }

  Flight::render('layout', array(
    'title' => 'Tor Relay Configurator | Installation',
    'serverCount' => Flight::get('serverCount'),
    'combinedUptime' => Flight::get('combinedUptime'),
    'combinedBandwidth' => Flight::get('combinedBandwidth'),
    'currentCommit' => Flight::get('currentCommit'),
    'nodes' => Flight::get('nodeslist'),
    'bandwidthChartData' => Flight::get('bandwidthChartJson'),
    'nodesChartData' => Flight::get('nodesChartJson')
  ));
});

Flight::route('GET /nf/@hash.sh', function ($hash) {
  // Filter out any non-alphanumeric characters
  $hash = preg_replace('/[^a-zA-Z0-9]/', '', $hash);
  header('Content-Type: application/x-sh');
  try {
    echo file_get_contents("userconfigs/$hash.sh");
  } catch (Exception $e) {
    echo 'echo "There was an error fetching your generated script! Please return to tor-relay.co and try again."';
  }
});

Flight::route('GET /install-sudo-on-debian', function () {
  Flight::render('install-sudo', array(), 'main_content');
  Flight::render('layout', array(
    'title' => 'Tor Relay Configurator',
    'serverCount' => Flight::get('serverCount'),
    'combinedUptime' => Flight::get('combinedUptime'),
    'combinedBandwidth' => Flight::get('combinedBandwidth'),
    'currentCommit' => Flight::get('currentCommit'),
    'nodes' => Flight::get('nodeslist'),
    'bandwidthChartData' => Flight::get('bandwidthChartJson'),
    'nodesChartData' => Flight::get('nodesChartJson')
  ));
});

Flight::start();
