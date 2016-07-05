<?php

namespace Etmp\Storage\Adapter\FileSystem;

use Etmp\Foundation\Config;
use Etmp\Storage\Adapter;
use Exception;

class Storage implements Adapter {
    private $dir;

    public function __construct(Config $config)
    {
        if (!isset($config['storageDirectory'])) {
            throw new Exception('Storage directory not set');
        }

        $this->dir = $config['storageDirectory'];
    }

    private function formatFileName(string $table, $date): string
    {
        return $this->dir . '/' . $table . '/' . $date->format('Ymd');
    }

    private function write(string $file, $value, string $mode)
    {
        if (is_array($value)) {
            $value = explode("\t", $value);
        }

        $handle = fopen($file, $mode);
        fwrite($handle, $value);
        fclose($handle);
    }

    public function setup()
    {
        if (!file_exists($this->dir)) {
            mkdir($this->dir);
        }

        if (!file_exists($this->dir . '/logs')) {
            mkdir($this->dir . '/logs');
        }

        if (!file_exists($this->dir . '/adress')) {
            mkdir($this->dir . '/adress');
        }
    }

    public function append(string $table, $date, $value)
    {
        $file = $this->formatFileName($table, $date);

        $this->write($file, $value, 'a');
    }

    public function insert(string $table, $date, $value)
    {
        $dir = $this->dir . '/' . $table;

        $this->write($dir . '/' . $table, $value, 'w+');
        $this->write($dir . '/date', $date->format('Y-m-d H:i:s'), 'w+');
    }
}