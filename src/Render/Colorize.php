<?php

namespace Etmp\Render;

abstract class Colorize {
    private static $colorCodes = [
        Color::Green => 32,
        Color::Red   => 31,
    ];

    /**
     * Formats a string of text into a colored one, it will
     * return the same string, should it use the default color
     *
     * @param  string $text
     * @param  int    $color
     * @return string
     */
    public static function format(string $text, int $color): string
    {
        if (isset(self::$colorCodes[$color])) {
            return "\033[" . self::$colorCodes[$color] . "m" . $text . "\033[0m";
        } else {
            return $text;
        }
    }
}