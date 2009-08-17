<?php
/* This class is part of the XP framework
 *
 * $Id: ParserClassTest.class.php 11328 2009-08-14 15:25:54Z ruben $ 
 */

  $package= 'xp.ide.unittest';

  uses(
    'unittest.TestCase',
    'xp.ide.source.parser.Php52Lexer',
    'xp.ide.source.parser.NativeLexer'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  abstract class xp·ide·unittest·TestCase extends TestCase {

    /**
     * lexer to do tests with
     *
     * @param string exp
     * @return text.parser.generic.AbstractLexer
     */
    public function getLexer($exp) {
      return new xp·ide·source·parser·NativeLexer($exp);
    }

  }
?>
