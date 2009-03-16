<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.Lexer'
  );

  /**
   * TestCase
   *
   * @see      xp://xp.compiler.Lexer
   */
  abstract class LexerTest extends TestCase {

    /**
     * Creates a lexer instance
     *
     * @param   string in
     * @return  xp.compiler.Lexer
     */
    protected abstract function newLexer($in);
  
    /**
     * Returns an array of tokens for a given input string
     *
     * @param   string in
     * @return  array<int, string>[] tokens
     */
    protected function tokensOf($in) {
      for ($l= $this->newLexer($in), $tokens= array(); $l->advance(); ) {
        $tokens[]= array($l->token, $l->value);
      }
      return $tokens;
    }
  
    /**
     * Test parsing a class declaration
     *
     */
    #[@test]
    public function classDeclaration() {
      $t= $this->tokensOf('public class Point { }');
      $this->assertEquals(array(Parser::T_PUBLIC, 'public'), $t[0]);
      $this->assertEquals(array(Parser::T_CLASS, 'class'), $t[1]);
      $this->assertEquals(array(Parser::T_WORD, 'Point'), $t[2]);
      $this->assertEquals(array(123, '{'), $t[3]);
      $this->assertEquals(array(125, '}'), $t[4]);
    }

    /**
     * Test parsing a one-line comment at the end of a line
     *
     */
    #[@test]
    public function commentAtEnd() {
      $t= $this->tokensOf('$a++; // HACK');
      $this->assertEquals(array(Parser::T_VARIABLE, '$a'), $t[0]);
      $this->assertEquals(array(Parser::T_INC, '++'), $t[1]);
      $this->assertEquals(array(59, ';'), $t[2]);
    }

    /**
     * Test parsing a double-quoted string
     *
     */
    #[@test]
    public function dqString() {
      $t= $this->tokensOf('$s= "Hello World";');
      $this->assertEquals(array(Parser::T_VARIABLE, '$s'), $t[0]);
      $this->assertEquals(array(61, '='), $t[1]);
      $this->assertEquals(array(Parser::T_STRING, 'Hello World'), $t[2]);
    }

    /**
     * Test parsing an empty double-quoted string
     *
     */
    #[@test]
    public function emptyDqString() {
      $t= $this->tokensOf('$s= "";');
      $this->assertEquals(array(Parser::T_VARIABLE, '$s'), $t[0]);
      $this->assertEquals(array(61, '='), $t[1]);
      $this->assertEquals(array(Parser::T_STRING, ''), $t[2]);
    }

    /**
     * Test parsing a double-quoted string with escapes
     *
     */
    #[@test]
    public function dqStringWithEscapes() {
      $t= $this->tokensOf('$s= "\"Hello\", he said";');
      $this->assertEquals(array(Parser::T_VARIABLE, '$s'), $t[0]);
      $this->assertEquals(array(61, '='), $t[1]);
      $this->assertEquals(array(Parser::T_STRING, '"Hello", he said'), $t[2]);
    }

    /**
     * Test parsing a single-quoted string
     *
     */
    #[@test]
    public function sqString() {
      $t= $this->tokensOf('$s= \'Hello World\';');
      $this->assertEquals(array(Parser::T_VARIABLE, '$s'), $t[0]);
      $this->assertEquals(array(61, '='), $t[1]);
      $this->assertEquals(array(Parser::T_STRING, 'Hello World'), $t[2]);
    }

    /**
     * Test parsing an empty single-quoted string
     *
     */
    #[@test]
    public function emptySqString() {
      $t= $this->tokensOf('$s= \'\';');
      $this->assertEquals(array(Parser::T_VARIABLE, '$s'), $t[0]);
      $this->assertEquals(array(61, '='), $t[1]);
      $this->assertEquals(array(Parser::T_STRING, ''), $t[2]);
    }

    /**
     * Test parsing a single-quoted string with escapes
     *
     */
    #[@test]
    public function sqStringWithEscapes() {
      $t= $this->tokensOf('$s= \'\\\'Hello\\\', he said\';');
      $this->assertEquals(array(Parser::T_VARIABLE, '$s'), $t[0]);
      $this->assertEquals(array(61, '='), $t[1]);
      $this->assertEquals(array(Parser::T_STRING, '\'Hello\', he said'), $t[2]);
    }
  }
?>
