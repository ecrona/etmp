<?php

namespace Etmp;

use Etmp\Controller\ControllerInterface;
use Etmp\Controller\Help;

class Router {
    private $routes = [
        'help' => Help::class,
        'job'  => JobController::class
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
    
    public function getController(): ControllerInterface
    {
        return new $this->routes[$this->route];
    }
}