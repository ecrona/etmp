<?php

namespace Etmp\Storage;

use Etmp\Foundation\Config;
use Exception;

abstract class Locator {
    public static function getStorage(Config $config): Adapter
    {
        $className = 'Etmp\\Storage\\Adapter\\' . $config['storageAdapter'] . '\Storage';
        if (!isset($config['storageAdapter'])) {
            throw new Exception('Storage adapter not selected');
        } else if (!class_exists($className)) {
            throw new Exception('Could not find selected storage adapter');
        }

        return new $className($config);
    }
}