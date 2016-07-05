<?php

namespace Etmp\Job;

use Etmp\Foundation\Config;
use Etmp\Storage;
use Etmp\Log\Logger;

abstract class JobFactory {
    public static function build()
    {
        $config  = new Config('config');
        $storage = Storage\Locator::getStorage($config);
        $logger  = new Logger($storage);

        $controller = new JobController($config, $storage, $logger);

        return $controller;
    }
}