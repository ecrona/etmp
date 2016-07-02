<?php

namespace Etmp\Render;

abstract class Renderer {
    public static function render(View $view)
    {
        echo $view;
    }
}