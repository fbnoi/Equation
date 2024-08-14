<?php

namespace Lang\Equation\Exception;

use Exception;

class NoValueIsProvided extends Exception
{
    public function __construct(string $name)
    {
        parent::__construct("No value is provided for param '$name'");
    }
}
