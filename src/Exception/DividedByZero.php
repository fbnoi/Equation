<?php

namespace Lang\Equation\Exception;

use Exception;

class DividedByZero extends Exception
{
    public function __construct(string $str)
    {
        parent::__construct("Divided by zero: $str");
    }
}
