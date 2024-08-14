<?php

namespace Lang\Equation\Exception;

use Exception;

class UnexpectedExpression extends Exception
{
    public function __construct(string $expr)
    {
        parent::__construct("Unexpected expression '$expr'");
    }
}
