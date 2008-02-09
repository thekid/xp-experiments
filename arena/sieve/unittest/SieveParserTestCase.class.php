<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'text.StringTokenizer',
    'peer.sieve.SieveParser',
    'peer.sieve.Lexer'
  );

  /**
   * TestCase
   *
   * @see      xp://peer.sieve.SieveParser
   * @see      xp://peer.sieve.Lexer
   * @purpose  Base class
   */
  abstract class SieveParserTestCase extends TestCase {
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->parser= new SieveParser();
    }

    /**
     * Parse sourcecode and return syntax tree
     *
     * @param   string src
     * @return  peer.sieve.SyntaxTree
     */
    protected function parse($src) {
      return $this->parser->parse(new peer·sieve·Lexer(new StringTokenizer($src), $this->name));
    }
    
    /**
     * Parse sourcecode and return command set
     *
     * @param   string src
     * @return  peer.sieve.CommandSet
     */
    protected function parseCommandSetFrom($src) {
      return $this->parser->parse(new peer·sieve·Lexer(new StringTokenizer($src), $this->name))->commandset;
    }
  }
?>
