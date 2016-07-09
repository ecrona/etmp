<?php

namespace Etmp\Foundation;

use ArrayAccess;

class Config implements ArrayAccess {
    private $container;

    /**
     * Retrieve the configuration file.
     * 
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->container = require(getcwd() . '/conf/' . $file . '.php');
    }

    /**
     * Set a configuration setting.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Determine if the given configuration setting exists.
     *
     * @param  string $key
     * @return bool
     */
    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }

    /**
     * Unset a configuration setting.
     *
     * @param  string $key
     * @return void
     */
    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }

    /**
     * Get a configuration setting.
     *
     * @param  string $key
     * @return mixed
     */
    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
}