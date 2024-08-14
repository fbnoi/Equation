<?php

namespace Lang\Equation\Expr;

use Lang\Equation\Exception\InvalidValue;
use Lang\Equation\Token;

class Number implements Expr
{
    private float $value;

    /**
     * @throws InvalidValue
     */
    private function __construct(string $num)
    {
        if (!is_numeric($num)) {
            throw new InvalidValue($num);
        }
        $this->value = (float)$num;
    }

    /**
     * @throws InvalidValue
     */
    public static function instance(Token $num): static
    {
        return new static($num->getValue());
    }

    /**
     * @param array<string, int|float>|null $params
     */
    public function getValue(array $params = null): float
    {
        return $this->value;
    }

    public function raw(): string
    {
        return (string)$this->value;
    }
}
