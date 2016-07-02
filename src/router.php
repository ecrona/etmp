<?php

namespace Etmp;

use Etmp\Controllers\Controller;
use Etmp\Controllers\Help;

class Router {
    private $routes = [
        'help' => Help::class,
        'job'  => Job::class,
    ];
    
    private $route;
    private $arguments;
    
    public function __construct(Array $arguments)
    {
        $this->route = strtolower($arguments[0]);
        $this->arguments = array_slice($arguments, 1);
    }

    public function find(): bool
    {
        if (!isset($this->routes[$this->route])) {
            return false;
        }
        
        return true;
    }
    
    public function getController(): Controller
    {
        return new $this->routes[$this->route];
    }
}