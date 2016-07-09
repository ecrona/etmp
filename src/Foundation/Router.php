<?php

namespace Etmp\Foundation;

use Etmp\Foundation\Controller;
use Etmp\Help\HelpController;
use Etmp\NotFound\NotFoundController;
use Etmp\Job\JobController;
use Etmp\Job\JobFactory;
use Etmp\Verify\VerifyFactory;

class Router {
    private $routes = [
        'help' => HelpController::class,
    ];

    private $factories = [
        'job'    => JobFactory::class,
        'verify' => VerifyFactory::class,
    ];

    private $notFoundController = NotFoundController::class;
    
    private $route;
    private $arguments;
    private $controller;
    private $factory;
    
    /**
     * Constructs the router and resolves the route.
     *
     * @param  array $arguments
     */
    public function __construct(Array $arguments)
    {
        $this->route = sizeof($arguments) > 1 ? strtolower($arguments[1]) : '';
        $this->arguments = array_slice($arguments, 2);

        $this->resolveRoute();
    }

    /**
     * Determines if the assigned route exists as a controller
     * or a factory in our intial route configuration, setting
     * the controller or factory as a property.
     *
     * @return void
     */
    private function resolveRoute()
    {
        if (isset($this->routes[$this->route]) || isset($this->factories[$this->route])) {
            if (isset($this->factories[$this->route])) {
                $this->factory = $this->factories[$this->route];
            } else {
                $this->controller = $this->routes[$this->route];
            }
        } else {
            $this->controller = $this->notFoundController;
        }
    }
    
    /**
     * Fetches the controller previously set depending on assigned
     * route. Builds a factory if set, or simply returns a controller.
     *
     * @return Etmp\Foundation\Controller
     */
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