<?php

namespace Lang\Equation\Expr;

interface Expr {
    public const DEFAULT_MAX_SCALE = 10;

    /**
     * @param array<string, int|float>|null $params
     */
    function getValue(array $params = null): float;

    function raw(): string;
}