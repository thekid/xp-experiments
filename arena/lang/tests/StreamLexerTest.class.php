<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('tests.LexerTest', 'io.streams.MemoryInputStream');

  /**
   * Tests the lexer tokenizing a stream
   *
   */
  class StreamLexerTest extends LexerTest {

    /**
     * Creates a lexer instance
     *
     * @param   string in
     * @return  xp.compiler.Lexer
     */
    protected function newLexer($in) {
      return new xp·compiler·Lexer(new MemoryInputStream($in), $this->name);
    }
  }
?>
