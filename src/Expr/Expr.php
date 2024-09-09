<?php

namespace Lang\Equation\Expr;

interface Expr {
    public const DEFAULT_MAX_SCALE = 10;

    public const OP_ADD = '+';
    public const OP_SUB = '-';
    public const OP_MUL = '*';
    public const OP_DIV = '/';
    public const OP_POW = '^';

    /**
     * @param array<string, int|float>|null $params
     */
    function getValue(array $params = null): float;

    function raw(): string;

    function add(Expr $expr): Expr;
    function sub(Expr $expr): Expr;
    function mul(Expr $expr): Expr;
    function div(Expr $expr): Expr;
    function pow(Expr $expr): Expr;
}