<?php

namespace Etmp;

use Etmp\Foundation\Router;
use Etmp\Render\Renderer;

abstract class Bootstrap {
    public static function start()
    {
        global $argv;
        $router = new Router($argv);

        $controller = $router->getController();
        $view       = $controller->dispatch();
        
        Renderer::render($view);
    }
}