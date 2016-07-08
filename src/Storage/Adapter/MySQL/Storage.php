<?php

namespace Etmp\Storage\Adapter\MySQL;

use Etmp\Foundation\Config;
use Etmp\Storage\Adapter;
use Exception;
use DateTime;
use DateInterval;

class Storage implements Adapter {
    private $dir;

    public function __construct(Config $config)
    {
        if (!isset($config['storageHost'])) {
            throw new Exception('Storage host not set');
        } else if (!isset($config['storageDatabase'])) {
            throw new Exception('Storage database not set');
        } else if (!isset($config['storageUsername'])) {
            throw new Exception('Storage username not set');
        } else if (!isset($config['storagePassword'])) {
            throw new Exception('Storage password not set');
        }

        $this->db = new PDO(
            'mysql:dbname=' . $config['storageDatabase'] . ';host=' . $config['storageHost'],
            $config['storageUsername'],
            $config['storagePassword']
        );
    }

    public function setup()
    {
        $this->db->exec('
            CREATE TABLE IF NOT EXISTS `logs` (
                value TEXT NOT NULL,
                date TIMESTAMP NOT NULL,
                level VARCHAR 50 NOT NULL
            );
        ');

        $this->db->exec('
            CREATE TABLE IF NOT EXISTS `adress` (
                value TEXT NOT NULL,
                date TIMESTAMP NOT NULL
            );
        ');
    }

    public function read(string $table): string
    {
        return '';
    }

    public function append(string $table, $date, $value, array $metadata = array())
    {

    }

    public function insert(string $table, $date, $value)
    {

    }
    
    public function clean(string $table, int $days = 7)
    {

    }
}