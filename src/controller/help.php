<?php

namespace Etmp\Controller;

use Etmp\Controller\ControllerInterface;
use Etmp\View;

class Help implements ControllerInterface {
    public function run(): View
    {
        $view = new View();
        $view->setMessage('hej');
        
        return $view;
    }
}