<?php
  
namespace Tests;

use Lang\Equation\Exception\UnexpectedExpression;
use Lang\Equation\Lexer;
use Lang\Equation\Token;
use PHPUnit\Framework\TestCase;
use Throwable;

class LexerTest extends TestCase
{
    /**
     * @throws UnexpectedExpression
     */
    public function testParseInt(): void
    {
        $tokens = Lexer::tokenize(" 1.23");
        $this->assertCount(1, $tokens, 'count');
        $this->assertEquals("1.23", $tokens[0]->getValue(), 'value: ' . $tokens[0]->getValue());
        $this->assertEquals(Token::NUMBER, $tokens[0]->getType(), 'type');
    }

    /**
     * @throws UnexpectedExpression
     */
    public function testParseName(): void
    {
        $tokens = Lexer::tokenize(" :var: ");
        $this->assertCount(1, $tokens);
        $this->assertEquals(":var:", $tokens[0]->getValue());
        $this->assertEquals(Token::PARAM, $tokens[0]->getType());
    }

    /**
     * @throws UnexpectedExpression
     */
    public function testParseOP(): void
    {
        $tokens = Lexer::tokenize("+ -* /^");
        $this->assertCount(5, $tokens);
        foreach (str_split("+-*/^") as $k => $v) {
            $this->assertEquals($v, $tokens[$k]->getValue());
            $this->assertEquals(Token::OP, $tokens[0]->getType());
        }
    }

    public function testParseUnExpectedToken(): void
    {
        try {
            Lexer::tokenize("unexpected");
        } catch (Throwable $th) {
            $this->assertTrue($th instanceof UnexpectedExpression, "class is ". get_class($th) ."");
        }
    }
}
