<?php

namespace Lang\Equation;

use Lang\Equation\Exception\UnexpectedExpression;

class Lexer {

    public const NUMBER = '/^\d+(\.\d+)?+/';
    public const BRACKET = '/^[()]/';
    public const OP = '/^[+\-*\/^]/';
    public const PARAM = '/^:[a-zA-Z]+:/';

    /**
     * @return array<Token>
     * @throws UnexpectedExpression
     */
    public static function tokenize(string $expression): array
    {
        $tokens = [];
        while (true) {
            $expression = trim($expression);
            if (preg_match(self::NUMBER, $expression, $matches)) {
                $tokens[] = Token::number($matches[0]);
            } elseif (preg_match(self::BRACKET, $expression, $matches)) {
                $tokens[] = Token::bracket($matches[0]);
            } elseif (preg_match(self::OP, $expression, $matches)) {
                $tokens[] = Token::operator($matches[0]);
            } elseif (preg_match(self::PARAM, $expression, $matches)) {
                $tokens[] = Token::param($matches[0]);
            } else {
                throw new UnexpectedExpression($expression);
            }
            if ($matches) {
                $expression = substr($expression, strlen($matches[0]));
            }
            if (!$expression) {
                break;
            }
        }

        return $tokens;
    }
}
