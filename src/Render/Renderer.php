<?php

namespace Etmp\Render;

abstract class Renderer {
    /**
     * Renders a message by echoing it out.
     *
     * @return string
     */
    public static function render(Message $message)
    {
        echo $message;
    }
}