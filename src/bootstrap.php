<?php

namespace Etmp;

abstract class Bootstrap {
    public static function start()
    {
        global $argv;
        $router = new Router($argv);
        
        var_dump($router->find());
        
        if ($router->find()) {
            $controller = $router->getController();
            
            echo $controller->run();
        }
    }
}