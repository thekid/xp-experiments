<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'io.streams.MemoryInputStream',
    'ExampleLexer'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class ExampleLexerTest extends TestCase {
  
    /**
     * Test
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function testLexerIllegalArgument() {
      new ExampleLexer();
    }

    /**
     * Test
     *
     */
    #[@test]
    public function testLexer() {
      $this->assertSubClass(
        new ExampleLexer(new MemoryInputStream("4322566434  t4674.")),
        'text.parser.generic.AbstractLexer'
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function testLexerToken() {
      $lexer= new ExampleLexer(new MemoryInputStream("4"));
      $lexer->advance();
      $this->assertEquals("4", $lexer->value);
    }

    /**
     * Test
     *
     */
    #[@test]
    public function testLexerTokens() {
      $lexer= new ExampleLexer(new MemoryInputStream("4 + 5"));
      $v= array();
      $lexer->advance();
      $v[]= $lexer->value;
      $lexer->advance();
      $v[]= $lexer->value;
      $lexer->advance();
      $v[]= $lexer->value;
      $this->assertEquals(array("4", "+", "5"), $v);
    }

    /**
     * Test
     *
     */
    #[@test]
    public function testLexerEnd() {
      $lexer= new ExampleLexer(new MemoryInputStream(""));
      $lexer->advance();
      $this->assertFalse($lexer->value);
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.XPException')]
    public function testLexerError() {
      create(new ExampleLexer(new MemoryInputStream("_")))->advance();
    }
  }
?>
