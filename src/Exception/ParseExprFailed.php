<?php

namespace Lang\Equation\Exception;

use Exception;
use Lang\Equation\Token;

class ParseExprFailed extends Exception
{
    public function __construct(array $tokens)
    {
        $message = join(" ", array_map(fn (Token $token) => $token->getValue(), $tokens));
        parent::__construct($message);
    }
}
