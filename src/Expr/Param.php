<?php

namespace Lang\Equation\Expr;

use Lang\Equation\Exception\InvalidValue;
use Lang\Equation\Exception\NoValueIsProvided;
use Lang\Equation\Token;

class Param implements Expr
{
    private ?string $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function instance(Token $param): static
    {
        return new static(trim($param->getValue(), ':'));
    }

    /**
     * @param array<string, int|float>|null $params
     * @throws NoValueIsProvided
     * @throws InvalidValue
     */
    public function getValue(array $params = null): float
    {
        if ($num = $params[$this->name] ?? false) {
            if (is_numeric($num)) {
                return $params[$this->name];
            }

            throw new InvalidValue($num);
        }

        throw new NoValueIsProvided($this->name);
    }

    public function raw(): string
    {
        return ":$this->name:";
    }
}
