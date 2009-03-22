<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('tests.LexerTest');

  /**
   * Tests the lexer tokenizing string input
   *
   */
  class StringLexerTest extends LexerTest {

    /**
     * Creates a lexer instance
     *
     * @param   string in
     * @return  xp.compiler.Lexer
     */
    protected function newLexer($in) {
      return new xp·compiler·syntax·xp·Lexer($in, $this->name);
    }
  }
?>
