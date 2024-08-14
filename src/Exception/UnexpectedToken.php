<?php

namespace Lang\Equation\Exception;

use Exception;

class UnexpectedToken extends Exception
{
    public function __construct(string $token)
    {
        parent::__construct("Unexpected token '$token'");
    }
}
