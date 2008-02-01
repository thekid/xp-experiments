<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'peer.sieve.SieveParser',
    'peer.sieve.Lexer'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
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
     * Parse sourcecode and return ruleset
     *
     * @param   string src
     * @return  peer.sieve.SyntaxTree
     */
    protected function parse($src) {
      return $this->parser->parse(new peer�sieve�Lexer($src, $this->name));
    }
    
    /**
     * Parse sourcecode and return ruleset
     *
     * @param   string src
     * @return  peer.sieve.RuleSet
     */
    protected function parseRuleSetFrom($src) {
      return $this->parser->parse(new peer�sieve�Lexer($src, $this->name))->ruleset;
    }
  }
?>