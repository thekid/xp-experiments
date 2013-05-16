<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class BaseTest extends SieveParserTestCase {

    /**
     * Test
     *
     */
    #[@test]
    public function emptyScript() {
      $this->assertTrue($this->parseCommandSetFrom('')->isEmpty());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function oneLineComment() {
      $this->assertEquals(1, $this->parseCommandSetFrom('
        if size :over 100k { # this is a comment
          discard;
        }
      ')->size());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function multilineComments() {
      $this->assertEquals(1, $this->parseCommandSetFrom('
        if size :over 100K { /* this is a comment
           this is still a comment */ discard /* this is a comment
           */ ;
        }
      ')->size());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function unclosedMultilineComment() {
      try {
        $this->parse('/* this is an unclosed comment');
        $this->fail('No exception thrown', NULL, 'text.parser.generic.ParseException');
      } catch (ParseException $expected) {
        $this->assertClass($expected->getCause(), 'lang.IllegalStateException');
      }
    }

    /**
     * Test
     *
     */
    #[@test]
    public function scriptWithOnlyComments() {
      $this->assertTrue($this->parseCommandSetFrom('
        # Nothing to be seen here
        ## Comments
        ### Over ####
        #### Comments
      ')->isEmpty());
    }

    /**
     * Test requires
     *
     */
    #[@test]
    public function requires() {
      $this->assertEquals(
        array('fileinto', 'reject', 'vacation', 'imapflags', 'notify'),
        $this->parse('require ["fileinto","reject","vacation","imapflags", "notify"];')->required
      );
    }

    /**
     * Test top-level action
     *
     */
    #[@test]
    public function uncoditionalRule() {
      $this->assertClass(
        $this->parseCommandSetFrom('redirect "tom@example.com";')->commandAt(0),
        'peer.sieve.action.RedirectAction'
      );
    }

    /**
     * Test top-level action
     *
     */
    #[@test]
    public function nestedRules() {
      $rule= $this->parseCommandSetFrom('if true { if false { }}')->commandAt(0);
      $this->assertClass($rule, 'peer.sieve.Rule');
      $this->assertClass($rule->commands[0], 'peer.sieve.Rule');
      $this->assertEquals(NULL, $rule->commands[0]->commands);
    }
  }
?>
