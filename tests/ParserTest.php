<?php
  
namespace Tests;

use Lang\Equation\Exception\InvalidValue;
use Lang\Equation\Exception\NoValueIsProvided;
use Lang\Equation\Exception\ParseExprFailed;
use Lang\Equation\Exception\UnexpectedExpression;
use Lang\Equation\Exception\UnexpectedToken;
use Lang\Equation\Lexer;
use Lang\Equation\Parser;
use Lang\Equation\Expr\Binary;
use Lang\Equation\Expr\Bracket;
use Lang\Equation\Expr\Number;
use Lang\Equation\Expr\Param;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    /**
     * @throws UnexpectedToken
     * @throws InvalidValue
     * @throws UnexpectedExpression
     * @throws ParseExprFailed
     */
    public function testParseNum(): void
     {
         $tokens = Lexer::tokenize(" 1.23");
         $parser = new Parser();
         $expr = $parser->parse($tokens);
         $this->assertInstanceOf(Number::class, $expr);
         $this->assertEquals(1.23, $expr->getValue());
     }

    /**
     * @throws UnexpectedToken
     * @throws InvalidValue
     * @throws UnexpectedExpression
     * @throws ParseExprFailed
     * @throws NoValueIsProvided
     */
    public function testParseParam(): void
     {
         $tokens = Lexer::tokenize(" :var:");
         $parser = new Parser();
         $expr = $parser->parse($tokens);
         $this->assertInstanceOf(Param::class, $expr);
         $this->assertEquals(1.23, $expr->getValue(['var' => 1.23]));
     }

    /**
     * @throws UnexpectedToken
     * @throws InvalidValue
     * @throws UnexpectedExpression
     * @throws ParseExprFailed
     */
    public function testParseBracket(): void
     {
         $tokens = Lexer::tokenize("(1)");
         $parser = new Parser();
         $expr = $parser->parse($tokens);
         $this->assertInstanceOf(Bracket::class, $expr);
         $this->assertEquals(1, $expr->getValue());
     }

    /**
     * @throws UnexpectedToken
     * @throws InvalidValue
     * @throws UnexpectedExpression
     * @throws ParseExprFailed
     */
    public function testParseBinary(): void
     {
         $tokens = Lexer::tokenize("1 + 1");
         $parser = new Parser();
         $expr = $parser->parse($tokens);
         $this->assertInstanceOf(Binary::class, $expr);
         $this->assertEquals(2, $expr->getValue());
         $this->assertEquals('1+1', $expr->raw());
     }

    /**
     * @throws UnexpectedToken
     * @throws InvalidValue
     * @throws UnexpectedExpression
     * @throws ParseExprFailed
     */
    public function testParseBinary2(): void
     {
         $tokens = Lexer::tokenize("1 + :var:");
         $parser = new Parser();
         $expr = $parser->parse($tokens);
         $this->assertInstanceOf(Binary::class, $expr);
         $this->assertEquals(3, $expr->getValue(['var' => 2]));
         $this->assertEquals(2.1, $expr->getValue(['var' => 1.1]));
         $this->assertEquals('1+:var:', $expr->raw());
     }

    /**
     * @throws UnexpectedToken
     * @throws InvalidValue
     * @throws UnexpectedExpression
     * @throws ParseExprFailed
     */
    public function testParseComplex(): void
    {
        $tokens = Lexer::tokenize("3.14+2*4*(1+1.1)+:var:+:test:");
        $parser = new Parser();
        $expr = $parser->parse($tokens);
        $this->assertInstanceOf(Binary::class, $expr);
        $this->assertEquals(23.94, $expr->getValue(['var' => 2, 'test'=> 2]), $expr->raw());
        $this->assertEquals(25.04, $expr->getValue(['var' => 1.1, 'test'=> 4]));
        $this->assertEquals('3.14+2*4*(1+1.1)+:var:+:test:', $expr->raw());
    }
}
