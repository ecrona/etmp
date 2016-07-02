<?php

namespace Etmp\Foundation;

use Etmp\Render\Message;

interface Controller {
    public function dispatch(): Message;
}