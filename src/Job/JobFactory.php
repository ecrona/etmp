<?php

namespace Etmp\Job;

use Etmp\Foundation\Config;

abstract class JobFactory {
    public static function build()
    {
        $config = new Config('config');
        
        $controller = new JobController($config);

        return $controller;
    }
}