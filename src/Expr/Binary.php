<?php

namespace Lang\Equation\Expr;

class Binary implements Expr
{
    private Expr $x;
    private Expr $y;
    private string $op;

    public function __construct(Expr $x, Expr $y, string $op)
    {
        $this->x = $x;
        $this->y = $y;
        $this->op = $op;
    }

    public function raw(): string
    {
        return $this->x->raw() .
            $this->op .
            $this->y->raw();
    }

    /**
     * @param array<string, int|float>|null $params
     */
    public function getValue(array $params = null, int $scale = Expr::DEFAULT_MAX_SCALE): float
    {
        $x = $this->x->getValue($params);
        $y = $this->y->getValue($params);

        $ret = (float) match ($this->op) {
            '+' => bcadd($x, $y, Expr::DEFAULT_MAX_SCALE),
            '-' => bcsub($x, $y, Expr::DEFAULT_MAX_SCALE),
            '*' => bcmul($x, $y, Expr::DEFAULT_MAX_SCALE),
            '/' => bcdiv($x, $y, Expr::DEFAULT_MAX_SCALE),
            '^' => bcpow($x, $y, Expr::DEFAULT_MAX_SCALE),
        };

        return round($ret, $scale);
    }
}
