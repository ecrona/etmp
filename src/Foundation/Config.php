<?php

namespace Etmp\Foundation;

use ArrayAccess;

class Config implements ArrayAccess {
    private $container;

    public function __construct($file)
    {
        $this->container = require(getcwd() . '/conf/' . $file . '.php');
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset) {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }
}