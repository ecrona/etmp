<?php

namespace Etmp\Controller;

use Etmp\View;

interface ControllerInterface {
    public function run(): View;
}