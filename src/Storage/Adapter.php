<?php

namespace Etmp\Storage;

use Etmp\Foundation\Config;

interface Adapter {
    public function __construct(Config $config);
    public function setup();
    public function read(string $table): string;
    public function append(string $table, $date, $value, array $metadata = array());
    public function insert(string $table, $date, $value);
    public function clean(string $table);
}