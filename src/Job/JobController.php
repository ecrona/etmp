<?php

namespace Etmp\Job;

use Etmp\Foundation\Controller;
use Etmp\Foundation\Config;
use Etmp\Render\Message;
use Etmp\Storage;
use Etmp\Log\Logger;
use Exception;
use DateTime;

class JobController implements Controller {
    private $curlUrl = 'https://dynupdate.no-ip.com/nic/update?hostname=%s&myip=%s';
    private $config;
    private $storage;
    private $logger;
    
    public function __construct(
        Config $config,
        Storage\Adapter $storage,
        Logger $logger
    ) {
        $this->config  = $config;
        $this->storage = $storage;
        $this->logger  = $logger;
    }

    private function fetchAdress()
    {
        $adress = @file_get_contents($this->config['fetchAdressUrl']);

        if ($adress === false) {
            throw new Exception('Could not fetch adress');
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

    private function storeAdress($adress)
    {
        $this->storage->insert('adress', new DateTime(), $adress);
    }
    
    public function dispatch(): Message
    {
        $message = new Message();

        try {
            $this->storage->setup();

            $adress   = $this->fetchAdress();
            $response = $this->setAdress($adress);

            $this->storeAdress($adress);
            $this->logger->info($response);
        } catch(Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }

        return $message;
    }
}