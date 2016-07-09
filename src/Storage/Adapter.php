<?php

namespace Etmp\Storage;

use Etmp\Foundation\Config;

interface Adapter {
    /**
     * Stores the supplied configuration dependency in the storage instance.
     *
     * @param Etmp\Foundation\Config $config
     */
    public function __construct(Config $config);

    /**
     * Preliminary configuration with files / tables setup,
     * creating foundational setup to execute functionality.
     *
     * @return void
     */
    public function setup();
    
    /**
     * Reads a table and returns a single value.
     *
     * @param  string $table;
     * @return string;
     */
    public function read(string $table): string;
    
    /**
     * Appends a row to a table with value and optional metadata.
     *
     * @param  string   $table
     * @param  DateTime $date
     * @param  mixed    $value
     * @param  array    $metadata (optional)
     * @return void
     */
    public function append(string $table, $date, $value, array $metadata = array());
    
    /**
     * Inserts into a table, replacing all current data with a
     * new, single row of data.
     *
     * @param  string   $table
     * @param  DateTime $date
     * @param  mixed    $value
     * @return void
     */
    public function insert(string $table, $date, $value);
    
    /**
     * Cleans a table's entities.
     *
     * @param  string   $table
     * @return void
     */
    public function clean(string $table);
}