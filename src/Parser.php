<?php

namespace Lang\Equation;

use Lang\Equation\Exception\ParseExprFailed;
use Lang\Equation\Exception\UnexpectedToken;
use Lang\Equation\Expr\Binary;
use Lang\Equation\Expr\Bracket;
use Lang\Equation\Expr\Expr;
use Lang\Equation\Expr\Number;
use Lang\Equation\Expr\Param;

class Parser {

    private const PROV = [
        '(' => -1,
        '+' => 0,
        '-' => 0,
        '*' => 2,
        '/' => 2,
        '^' => 4,
        ')' => 512,
    ];

    /**
     * @var array<Token>
     */
    private array $opStack = [];

    /**
     * @var array<Expr>
     */
    private array $exprStack = [];

    /**
     * @param array<Token> $tokens
     * @throws UnexpectedToken
     * @throws ParseExprFailed|Exception\InvalidValue
     */
    public function parse(array $tokens): Expr
    {
        foreach ($tokens as $token) {
            switch ($token->getType()) {
                case Token::NUMBER:
                    $this->exprStack[] = Number::instance($token);
                    break;
                case Token::PARAM:
                    $this->exprStack[] = Param::instance($token);
                    break;
                case Token::OP:
                    while ($this->needMerge($token) && $op = array_pop($this->opStack)) {
                        $this->merge($op);
                    }
                    $this->opStack[] = $token;
                    break;
                case Token::BRACKET:
                    if ($token->getValue() === '(') {
                        $this->opStack[] = $token;
                    } else {
                        while ($this->needMerge($token) && $op = array_pop($this->opStack)) {
                            $this->merge($op);
                        }
                        $op = array_pop($this->opStack);
                        if (!$op || $op->getValue() !== '(') {
                            throw new UnexpectedToken($token->getValue());
                        }
                        $this->merge($op);
                    }
                    break;
                default:
                    break;
            }
        }
        while ($op = array_pop($this->opStack)) {
            $this->merge($op);
        }

        if (count($this->exprStack) !== 1) {
            throw new ParseExprFailed($tokens);
        }

        return array_pop($this->exprStack);
    }

    private function needMerge(Token $token): bool
    {
        if (!$len = count($this->opStack)) {
            return false;
        }
        $op = $this->opStack[$len -1];

        if ($op->getValue() === '(') {
            return false;
        }

        if ($token->getValue() === ')') {
            return true;
        }

        return static::PROV[$op->getValue()] > static::PROV[$token->getValue()];
    }

    /**
     * @throws UnexpectedToken
     */
    private function merge(Token $token): void
    {
        if ($token->getType() === Token::OP && ($y = array_pop($this->exprStack)) && $x = array_pop($this->exprStack)) {
            $expr = new Binary($x, $y, $token->getValue());
            $this->exprStack[] = $expr;

            return;
        } elseif ($token->getValue() === '(' && $x = array_pop($this->exprStack)) {
            $expr = new Bracket($x);
            $this->exprStack[] = $expr;

            return;
        }

        throw new UnexpectedToken($token->getValue());
    }
}
