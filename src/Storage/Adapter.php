<?php

namespace Etmp\Storage;

use Etmp\Foundation\Config;

interface Adapter {
    public function __construct(Config $config);
    public function setup();
    public function append(string $table, $date, $value);
    public function insert(string $table, $date, $value);
}