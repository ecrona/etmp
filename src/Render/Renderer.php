<?php

namespace Etmp\Render;

abstract class Renderer {
    public static function render(Message $message)
    {
        echo $message;
    }
}