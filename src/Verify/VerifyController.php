<?php

namespace Etmp\Verify;

use Etmp\Foundation\Controller;
use Etmp\Foundation\Config;
use Etmp\Storage;
use Etmp\Render\Message;
use Etmp\Render\Color;
use Etmp\Job;
use Exception;
use DateTime;

class VerifyController implements Controller {
    private $config;
    private $storage;
    private $jobService;

    public function __construct(
        Config $config,
        Storage\Adapter $storage,
        Job\JobService $jobService
    ) {
        $this->config     = $config;
        $this->storage    = $storage;
        $this->jobService = $jobService;
    }

    public function dispatch(): Message
    {
        $message = new Message();
        try {
            $message->section('Attempting to setup the storage ...');
            $this->storage->setup();

            $message->section('Attempting create a storage entry ...');
            $this->storage->insert('test', new DateTime(), 'test');

            $message->section('Attempting to read from the storage ...');
            $this->storage->read('test');

            $message->section('Attempting to remove a storage entry ...');
            $this->storage->truncate('test');

            $message->section('Attempting to fetch external adress ...');
            $adress = $this->jobService->fetchAdress($this->config['fetchAdressUrl']);
            
            $message->section('Attempting to set the external adress ...');
            $this->jobService->setAdress(
                $adress,
                $this->config['noIpHostname'],
                $this->config['noIpUsername'],
                $this->config['noIpPassword']
            );
            
            $message->section('All steps were successful', Color::Green);
        } catch (Exception $exception) {
            $message->section('Failed: ' . $exception->getMessage(), Color::Red);
        }
        
        return $message;
    }
}