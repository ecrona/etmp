<?php

namespace Etmp\Controllers;

use Etmp\Controller;
use Etmp\View;

class Help implements Controller {
    private $config, $storage;
    
    public function __construct(Array $config, Storage $storage)
    {
        $this->config  = $config;
        $this->storage = $storage;
    }
    
    public function run(): View
    {
        $view = new View();
        $view->setMessage('hej');
        
        return $view;
    }
}