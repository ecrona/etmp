<?php

namespace Etmp\Foundation;

use Etmp\Render\Message;

interface Controller {
    /**
     * Dispatches the controller and provides a message.
     *
     * @return Etmp\Render\Message
     */
    public function dispatch(): Message;
}