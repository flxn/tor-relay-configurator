<?php

require 'vendor/autoload.php';
require 'utils.php';
require 'TorConfig.php';

Flight::route('GET /', function () {
    Flight::render('main', array('errors' => ''), 'main_content');
    Flight::render('layout', array('title' => 'Tor Relay Configurator'));
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
      $template = str_replace('%RELEASE%', $req->data['os'], $template);
      $template = str_replace('%TORRC%', $torrc, $template);
      $template = str_replace('%ARM%', isset($req->data['enable-arm']) ? 'true' : 'false', $template);
      $template = str_replace('%EXIT%', ($req->data['node-type'] == 'exit') ? 'true' : 'false', $template);

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

  Flight::render('layout', array('title' => 'Tor Relay Configurator | Installation'));
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

Flight::start();
