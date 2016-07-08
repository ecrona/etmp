<?php

namespace Etmp\Storage\Adapter\MySQL;

use Etmp\Foundation\Config;
use Etmp\Storage\Adapter;
use Exception;
use DateTime;
use DateInterval;
use PDO;

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
                date DATETIME NOT NULL,
                level VARCHAR(50) NOT NULL
            );
        ');

        $this->db->exec('
            CREATE TABLE IF NOT EXISTS `adress` (
                value TEXT NOT NULL,
                date DATETIME NOT NULL,
                identifier TINYINT(1) NOT NULL,
                PRIMARY KEY (identifier)
            );

            INSERT IGNORE INTO `adress` (`value`, `identifier`)
            VALUES ("", 1)
        ');
    }

    public function read(string $table): string
    {
        $sth = $this->db->prepare('
            SELECT `value` FROM `' . $table . '`
            LIMIT 1
        ');

        $sth->execute();

        return $sth->fetchColumn();
    }

    public function append(string $table, $date, $value, array $metadata = array())
    {
        $columns = array_merge(['value'], array_keys($metadata));

        $sth = $this->db->prepare('
            INSERT INTO `' . $table . '` (' . implode(', ', $columns) . ')
            VALUES (:' . implode(', :', $columns) . ')
        ');

        $sth->execute(array_merge([
            'value' => $value
        ], $metadata));
    }

    public function insert(string $table, $date, $value)
    {
        $sth = $this->db->prepare('
            UPDATE `' . $table . '`
            SET `value` = :value, `date`  = :date
        ');

        $sth->execute([
            'value' => $value,
            'date' => $date->format('Y-m-d H:i:s'),
        ]);
    }
    
    public function clean(string $table, int $days = 7)
    {
        $sth = $this->db->prepare('
            DELETE FROM `' . $table . '`
            WHERE DATEDIFF(NOW(), date) > :days
        ');

        $sth->execute([
            'days' => $days
        ]);
    }
}