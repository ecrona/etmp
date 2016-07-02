<?php

namespace Etmp\Job;

use Etmp\Foundation\Controller;
use Etmp\Foundation\Config;
use Etmp\Render\Message;
use Exception;

class JobController implements Controller {
    private $curlUrl = 'https://dynupdate.no-ip.com/nic/update?hostname=%s&myip=%s';
    private $config, $storage;
    
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    private function fetchAdress()
    {
        $adress = @file_get_contents($this->config['fetchAdressUrl']);

        if ($adress === false) {
            throw new Exception('Could not fetch adress.');
        }

        return $adress;
    }

    private function setAdress($adress)
    {
        $curl = new Curl(sprintf(
            $this->curlUrl,
            $this->config['noIpHostname'],
            $adress
        ));
        
        $curl->setAuthentication(
            $this->config['noIpUsername'],
            $this->config['noIpPassword']
        );

        if (!$curl->execute()) {
            throw new Exception($curl);
        }

        return (string) $curl;
    }

    private function log(Exception $exception)
    {
        echo $exception;
    }
    
    public function dispatch(): Message
    {
        $message = new Message();

        try {
            $adress   = $this->fetchAdress();
            $response = $this->setAdress($adress);
            $message->section('IP Adress is: ' . $adress . ' - ' . $response);
        } catch(Exception $exception) {
           	$this->log($exception);
        }
        
        return $message;
    }
}