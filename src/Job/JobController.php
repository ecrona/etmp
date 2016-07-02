<?php

namespace Etmp\Job;

use Etmp\Foundation\Controller;
use Etmp\Foundation\Config;
use Etmp\Render\Message;
use Exception;

class JobController implements Controller {
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

    private function log(Exception $exception)
    {
        echo $exception;
    }
    
    public function dispatch(): Message
    {
        $message = new Message();

        try {
            $adress = $this->fetchAdress();
            $message->section('IP Adress is: ' . $adress);
        } catch(Exception $exception) {
           	$this->log($exception);
        }
        
        return $message;
    }
}