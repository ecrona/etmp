<?php

namespace Etmp\Job;

use Etmp\Foundation\Config;
use Etmp\Storage;

abstract class JobFactory {
    public static function build()
    {
        $config  = new Config('config');
        $storage = Storage\Locator::getStorage($config);

        $controller = new JobController($config, $storage);

        return $controller;
    }
}