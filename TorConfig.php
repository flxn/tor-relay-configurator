<?php

class TorConfig
{
    private $config = '';

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
        $variables['contactinfo'] = str_replace('@', ' [at] ', $variables['contactinfo']);
        $variables['contactinfo'] = str_replace('.', ' [dot] ', $variables['contactinfo']);

        if(isset($variables['trc-track'])) {
          $variables['contactinfo'] .= ' [tor-relay.co]';
        }

        // Minimum default config for non-bridge nodes
        $this->config = 'SocksPort 0'.
                     "\nRunAsDaemon 0".
                     "\nORPort ".$variables['orport'].
                     "\nNickname ".$variables['relayname'].
                     "\nContactInfo ".$variables['contactinfo'];

         // Special config for bridge nodes
         if ($variables['node-type'] == 'bridge') {
             $this->config =
             'ORPort '.$variables['orport'].
             "\nSocksPort 0".
             "\nBridgeRelay 1";
         }

        if ($variables['dirport']) {
            $this->config .= "\nDirPort ".$variables['dirport'];
        }

        if ($variables['node-type'] == 'exit') {
            $this->config .= "\nDirFrontPage /etc/tor/tor-exit-notice.html";
            $this->config .= file_get_contents('misc/exitpolicy.txt');
        } else {
            $this->config .=
                           "\nExitPolicy reject *:*\n";
        }

        if ($variables['bandwidth-rate']) {
            $this->config .=
                           "\nRelayBandwidthRate ".$variables['bandwidth-rate'].' MBits'.
                           "\nRelayBandwidthBurst ".($variables['bandwidth-burst'] ? $variables['bandwidth-burst'] : $variables['bandwidth-rate']).' MBits';
        }

        if ($variables['traffic-limit']) {
            $limit = $variables['traffic-limit'];
            if ($variables['traffic-unit'] == 'TB') {
                $limit *= 1000;
            }

            $this->config .=
                           "\nAccountingStart month 1 00:00".
                           "\nAccountingMax ".floor($limit / 2).' GB';
        }

        if (isset($variables['enable-arm'])) {
            $this->config .=
                             "\nDisableDebuggerAttachment 0".
                             "\nControlPort 9051".
                             "\nCookieAuthentication 1";
        }
    }

    public function getTorrc()
    {
      return $this->config;
    }
}
