<?php

namespace Etmp\Foundation;

use Etmp\Render\View;

interface Controller {
    public function dispatch(): View;
}