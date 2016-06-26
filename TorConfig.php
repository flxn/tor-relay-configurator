<?php
class TorConfig
{
    private $config = array();

    function __construct($variables)
    {
        if ($variables['node-type'] != 'bridge' && (!$variables['orport'] || !$variables['relayname'] || !$variables['contactinfo'])) {
            $missing = array();
            if(!$variables['orport']) $missing[] = 'ORPort';
            if(!$variables['relayname']) $missing[] = 'Relay Name';
            if(!$variables['contactinfo']) $missing[] = 'Contact Info';

            throw new Exception('Required fields missing (' . implode(', ', $missing) . ')');
        }

        if ($variables['orport'] != "auto" && !is_numeric($variables['orport'])) {
            throw new Exception('ORPort must be numeric.');
        }

        if ($variables['dirport'] && !is_numeric($variables['dirport'])) {
            throw new Exception('DirPort must be numeric.');
        }

        $re = '/^[a-zA-Z0-9]{1,19}$/';
        if ($variables['node-type'] != 'bridge' && preg_match($re, $variables['relayname']) !== 1) {
            throw new Exception('Relay names must be 1-19 characters long and may only contain numbers and letters.');
        }

        // Escape variables
        foreach ($variables as $var) {
            $var = escapeshellarg($var);
        }

        // Apply slight e-mail obfuscation
        $variables['contactinfo'] = str_replace('@', '(at)', $variables['contactinfo']);
        $variables['contactinfo'] = str_replace('.', '(dot)', $variables['contactinfo']);

        if(isset($variables['trc-track'])) {
          $variables['contactinfo'] .= ' [tor-relay.co]';
        }

        // Minimum default config for non-bridge nodes
        $baseConfig = array(
          "SocksPort" => 0,
          "RunAsDaemon" => 1,
          "ORPort" => $variables['orport'],
          "Nickname" => $variables['relayname'],
          "ContactInfo" => $variables['contactinfo']
        );

        if ($variables['node-type'] == 'bridge') {
          // Special config for bridge nodes
          $baseConfig = array(
            "ORPort" => $variables['orport'],
            "SocksPort" => 0,
            "BridgeRelay" => 1
          );
        }

        if ($variables['dirport']) {
            $baseConfig["DirPort"] = $variables['dirport'];
        }

        if ($variables['node-type'] == 'exit') {
            $baseConfig["DirFrontPage"] = "/etc/tor/tor-exit-notice.html";
            $baseConfig["ExitPolicy"] = explode("\n", file_get_contents('misc/exitpolicy.txt'));
        } else {
            $baseConfig["ExitPolicy"] = "reject *:*";
        }

        if ($variables['bandwidth-rate']) {
            $baseConfig["RelayBandwidthRate"] = $variables['bandwidth-rate'].' MBits';
            $baseConfig["RelayBandwidthBurst"] = ($variables['bandwidth-burst'] ? $variables['bandwidth-burst'] : $variables['bandwidth-rate']).' MBits';
        }

        if ($variables['traffic-limit']) {
            $limit = $variables['traffic-limit'];
            if ($variables['traffic-unit'] == 'TB') {
                $limit *= 1000;
            }

            $baseConfig["AccountingStart"] = "month 1 00:00";
            $baseConfig["AccountingMax"] = floor($limit / 2).' GB';
        }

        if (isset($variables['enable-arm'])) {
            $baseConfig["DisableDebuggerAttachment"] = 0;
            $baseConfig["ControlPort"] = 9051;
            $baseConfig["CookieAuthentication"] = 1;
        }

        $this -> config = $baseConfig;
    }

    public function getTorrc()
    {
      $torrcString = '';

      foreach ($this -> config as $key => $value) {
        if(!is_array($value) && trim($value) == "") {
          continue;
        }

        if(is_array($value)) {
            foreach ($value as $val) {
              if(trim($val) == "") {
                continue;
              }

              $torrcString .= $key . ' ' . $val . "\n";
            }
        } else {
          $torrcString .= $key . ' ' . $value . "\n";
        }
      }

      return $torrcString;
    }
}
