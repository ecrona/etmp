<?php

namespace Etmp\Storage\Adapter\FileSystem;

use Etmp\Foundation\Config;
use Etmp\Storage\Adapter;
use Exception;
use DateTime;
use DateInterval;

class Storage implements Adapter {
    private $dir;

    public function __construct(Config $config)
    {
        if (!isset($config['storageDirectory'])) {
            throw new Exception('Storage directory not set');
        }

        $this->dir = $config['storageDirectory'];
    }

    private function write(string $file, $value, string $mode)
    {
        if (is_array($value)) {
            $value = implode("\t", $value);
        }

        $handle = fopen($file, $mode);
        fwrite($handle, trim($value) . "\n");
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

    public function read(string $table): string
    {
        $file = $this->dir . '/' . $table . '/' . $table;

        if (file_exists($file)) {
            $handle  = fopen($file, 'r');
            $content = fread($handle, filesize($file));
            fclose($handle);

            return trim($content);
        } else {
            return '';
        }
    }

    public function append(string $table, $date, $value, array $metadata = array())
    {
        $file = $this->dir . '/' . $table . '/' . $date->format('Ymd');

        if (!empty($metadata)) {
            $value = array_merge($metadata, array($value));
        }

        $this->write($file, $value, 'a');
    }

    public function insert(string $table, $date, $value)
    {
        $dir = $this->dir . '/' . $table;

        $this->write($dir . '/' . $table, $value, 'w+');
        $this->write($dir . '/date', $date->format('Y-m-d H:i:s'), 'w+');
    }
    
    public function clean(string $table, int $days = 7)
    {
        $dir = $this->dir . '/' . $table;

        foreach (scandir($dir) as $file) {
            if (date_parse($file)['day'] !== false) {
                $diff = (new DateTime($file))->diff(new DateTime);
                
                if ($diff->d >= 7) {
                    unlink($dir . '/' . $file);
                }
            }
        }
    }
}