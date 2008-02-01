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
     * Test string list
     *
     */
    #[@test]
    public function stringList() {
      $this->assertEquals(
        array('From', 'To'), 
        $this->parseRuleSetFrom('if address :DOMAIN :is ["From", "To"] "example.com" { reject; }')
          ->ruleAt(0)
          ->condition
          ->tags['is']
      );
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
     * Test uncodition rule
     *
     */
    #[@test]
    public function uncoditionalRule() {
      $this->assertNull($this->parseRuleSetFrom('redirect "tom@example.com";')->ruleAt(0)->condition);
    }
  }
?>
