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
    private $config;
    private $storage;
    private $logger;
    private $jobService;
    
    public function __construct(
        Config $config,
        Storage\Adapter $storage,
        Logger $logger,
        JobService $jobService
    ) {
        $this->config     = $config;
        $this->storage    = $storage;
        $this->logger     = $logger;
        $this->jobService = $jobService;
    }

    private function setAdress($adress): string
    {
        return $this->jobService->setAdress(
            $adress,
            $this->config['noIpHostname'],
            $this->config['noIpUsername'],
            $this->config['noIpPassword']
        );
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
            $this->storage->clean('logs', $this->config['logPreserveDuration']);
            $adress = $this->jobService->fetchAdress($this->config['fetchAdressUrl']);

            if ($adress !== $this->storage->read('adress')) {
                $response = $this->setAdress($adress);
                $this->storeAdress($adress);
                $this->logger->info($response);
            } else {
                $this->logger->info('No adress change');
            }
        } catch(Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }

        return $message;
    }
}