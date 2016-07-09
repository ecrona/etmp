<?php

namespace Etmp\Foundation;

interface Factory {
    /**
     * Creates a controller instance and supplies
     * it with the required dependencies.
     *
     * @return Etmp\Foundation\Controller;
     */
    public static function build(): Controller;
}