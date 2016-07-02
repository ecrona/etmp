<?php

namespace Etmp\Foundation;

use Etmp\Foundation\Controller;
use Etmp\Help\HelpController;
use Etmp\NotFound\NotFoundController;
use Etmp\Job\JobController;
use Etmp\Job\JobFactory;

class Router {
    private $routes = [
        'help' => HelpController::class,
        'job'  => JobController::class,
    ];

    private $factories = [
        'job' => JobFactory::class,
    ];

    private $notFoundController = NotFoundController::class;
    
    private $route;
    private $arguments;
    private $controller;
    private $factory;
    
    public function __construct(Array $arguments)
    {
        $this->route = sizeof($arguments) > 1 ? strtolower($arguments[1]) : '';
        $this->arguments = array_slice($arguments, 2);

        $this->resolveRoute();
    }

    private function resolveRoute()
    {
        if (isset($this->routes[$this->route])) {
            if (isset($this->factories[$this->route])) {
                $this->factory = $this->factories[$this->route];
            } else {
                $this->controller = $this->routes[$this->route];
            }
        } else {
            $this->controller = $this->notFoundController;
        }
    }
    
    public function getController(): Controller
    {
        if (isset($this->factory)) {
            $controller = $this->factory::build();
        } else {
            $controller = new $this->controller;
        }

        return $controller;
    }
}