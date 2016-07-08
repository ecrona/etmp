<?php

namespace Etmp\Verify;

use Etmp\Foundation\Config;
use Etmp\Storage;
use Etmp\Job;

abstract class VerifyFactory {
    public static function build()
    {
        $config     = new Config('config');
        $storage    = Storage\Locator::getStorage($config);
        $jobService = new Job\JobService;

        $controller = new VerifyController($config, $storage, $jobService);

        return $controller;
    }
}