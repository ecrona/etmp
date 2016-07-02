<?php

namespace Etmp\Foundation;

interface Factory {
    public static function build(): Controller;
}