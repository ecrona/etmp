<?php

namespace Etmp\NotFound;

use Etmp\Foundation\Controller;
use Etmp\Render\Message;
use Etmp\Render\Color;

class NotFoundController implements Controller {
    public function dispatch(): Message
    {
        $message = new Message();
        $message->section('Action not found, type help to get information about what actions exist', Color::Red);
        
        return $message;
    }
}