<?php

namespace Lang\Equation\Exception;

use Exception;

class InvalidValue extends Exception
{
    public function __construct(string|float|int $num)
    {
        parent::__construct("Expected numeric value, got '$num'");
    }
}
