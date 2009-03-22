<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.syntax.xp.Lexer'
  );

  /**
   * TestCase
   *
   * @see      xp://xp.compiler.syntax.xp.Lexer
   */
  abstract class LexerTest extends TestCase {

    /**
     * Creates a lexer instance
     *
     * @param   string in
     * @return  xp.compiler.syntax.xp.Lexer
     */
    protected abstract function newLexer($in);
  
    /**
     * Returns an array of tokens for a given input string
     *
     * @param   string in
     * @return  array<int, string>[] tokens
     */
    protected function tokensOf($in) {
      $l= $this->newLexer($in);
      $tokens= array();
      do {
        try {
          if ($r= $l->advance()) {
            $tokens[]= array($l->token, $l->value);
          }
        } catch (Throwable $e) {
          $tokens[]= array($e->getClassName(), $e->getMessage());
          $r= FALSE;
        }
      } while ($r);
      return $tokens;
    }
  
    /**
     * Test parsing a class declaration
     *
     */
    #[@test]
    public function classDeclaration() {
      $t= $this->tokensOf('public class Point { }');
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_PUBLIC, 'public'), $t[0]);
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_CLASS, 'class'), $t[1]);
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_WORD, 'Point'), $t[2]);
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
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_VARIABLE, '$a'), $t[0]);
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_INC, '++'), $t[1]);
      $this->assertEquals(array(59, ';'), $t[2]);
    }

    /**
     * Test parsing a doc-comment
     *
     */
    #[@test]
    public function docComment() {
      $t= $this->tokensOf('
        /**
         * Doc-Comment
         *
         * @see http://example.com
         */  
        public void init() { }
      ');
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_PUBLIC, 'public'), $t[0]);
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_WORD, 'void'), $t[1]);
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_WORD, 'init'), $t[2]);
      $this->assertEquals(array(40, '('), $t[3]);
      $this->assertEquals(array(41, ')'), $t[4]);
      $this->assertEquals(array(123, '{'), $t[5]);
      $this->assertEquals(array(125, '}'), $t[6]);
    }

    /**
     * Test parsing a double-quoted string
     *
     */
    #[@test]
    public function dqString() {
      $t= $this->tokensOf('$s= "Hello World";');
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_VARIABLE, '$s'), $t[0]);
      $this->assertEquals(array(61, '='), $t[1]);
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_STRING, 'Hello World'), $t[2]);
    }

    /**
     * Test parsing an empty double-quoted string
     *
     */
    #[@test]
    public function emptyDqString() {
      $t= $this->tokensOf('$s= "";');
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_VARIABLE, '$s'), $t[0]);
      $this->assertEquals(array(61, '='), $t[1]);
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_STRING, ''), $t[2]);
    }

    /**
     * Test parsing a double-quoted string with escapes
     *
     */
    #[@test]
    public function dqStringWithEscapes() {
      $t= $this->tokensOf('$s= "\"Hello\", he said";');
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_VARIABLE, '$s'), $t[0]);
      $this->assertEquals(array(61, '='), $t[1]);
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_STRING, '"Hello", he said'), $t[2]);
    }

    /**
     * Test parsing a single-quoted string
     *
     */
    #[@test]
    public function sqString() {
      $t= $this->tokensOf('$s= \'Hello World\';');
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_VARIABLE, '$s'), $t[0]);
      $this->assertEquals(array(61, '='), $t[1]);
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_STRING, 'Hello World'), $t[2]);
    }

    /**
     * Test parsing an empty single-quoted string
     *
     */
    #[@test]
    public function emptySqString() {
      $t= $this->tokensOf('$s= \'\';');
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_VARIABLE, '$s'), $t[0]);
      $this->assertEquals(array(61, '='), $t[1]);
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_STRING, ''), $t[2]);
    }

    /**
     * Test parsing a single-quoted string with escapes
     *
     */
    #[@test]
    public function sqStringWithEscapes() {
      $t= $this->tokensOf('$s= \'\\\'Hello\\\', he said\';');
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_VARIABLE, '$s'), $t[0]);
      $this->assertEquals(array(61, '='), $t[1]);
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_STRING, '\'Hello\', he said'), $t[2]);
    }

    /**
     * Test string at end
     *
     */
    #[@test]
    public function stringAsLastToken() {
      $t= $this->tokensOf('"Hello World"');
      $this->assertEquals(1, sizeof($t));
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_STRING, 'Hello World'), $t[0]);
    }

    /**
     * Test parsing an unterminated string
     *
     */
    #[@test]
    public function unterminatedString() {
      $t= $this->tokensOf('$s= "The end');
      $this->assertEquals(array(xp搾ompiler新yntax暖p感arser::T_VARIABLE, '$s'), $t[0]);
      $this->assertEquals(array(61, '='), $t[1]);
      $this->assertEquals(array('lang.IllegalStateException', 'Unterminated string literal'), $t[2]);
    }
  }
?>
