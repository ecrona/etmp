<?php

namespace Etmp\Render;

abstract class Colorize {
    private static $colorCodes = [
        Color::Green => 32,
        Color::Red   => 31,
    ];

    public static function format(string $text, int $color): string
    {
        if (isset(self::$colorCodes[$color])) {
            return "\033[" . self::$colorCodes[$color] . "m" . $text . "\033[0m";
        } else {
            return $text;
        }
    }
}