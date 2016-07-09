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

    /**
     * Sets the required dependencies.
     *
     * @param Etmp\Foundation\Config $config
     * @param Etmp\Storage\Adapter   $storage
     * @param Etmp\Log\Logger        $logger
     * @param Etmp\Job\JobService    $jobService
     */
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

    /**
     * Sets the adress of a specified domain
     * using the job service.
     *
     * @param  string $adress
     * @param  string $domain
     * @return string
     */
    private function setAdress(string $adress, string $domain): string
    {
        return $this->jobService->setAdress(
            $adress,
            $domain,
            $this->config['noIpUsername'],
            $this->config['noIpPassword']
        );
    }

    /**
     * Stores the adress through the storage.
     *
     * @param  string $adress
     * @return void
     */
    private function storeAdress(string $adress)
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
                foreach ($this->config['noIpDomains'] as $domain) {
                    $response = $this->setAdress($adress, $domain);
                    $this->logger->info("{domain}\t" . $response, ['domain' => $domain]);
                }

                $this->storeAdress($adress);
            } else {
                $this->logger->info('No adress change');
            }
        } catch(Exception $exception) {
            $this->logger->critical($exception->getMessage());
        }

        return $message;
    }
}