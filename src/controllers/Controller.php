<?php

namespace Etmp\Controllers;

use Etmp\View;

interface Controller {
    public function dispatch(): View;
}