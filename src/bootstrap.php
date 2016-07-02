<?php

namespace Etmp;

abstract class Bootstrap {
    public static function start()
    {
        global $argv;
        $router = new Router($argv);
        
        if ($router->find()) {
            $controller = $router->getController();
            
            echo $controller->dispatch();
        }
    }
}