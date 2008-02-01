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
      $this->assertTrue($this->parseRuleSetFrom('')->isEmpty());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function oneLineComment() {
      $this->assertEquals(1, $this->parseRuleSetFrom('
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
      $this->assertEquals(1, $this->parseRuleSetFrom('
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
    public function scriptWithOnlyComments() {
      $this->assertTrue($this->parseRuleSetFrom('
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
     * Test uncoditional rule
     *
     */
    #[@test]
    public function uncoditionalRule() {
      $this->assertNull($this->parseRuleSetFrom('redirect "tom@example.com";')->ruleAt(0)->condition);
    }
  }
?>
