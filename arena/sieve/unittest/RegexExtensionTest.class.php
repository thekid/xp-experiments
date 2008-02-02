<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase for vacation extension
   *
   * @see      http://ietfreport.isoc.org/idref/draft-ietf-sieve-regex
   * @purpose  Unittest
   */
  class RegexExtensionTest extends SieveParserTestCase {
 
    /**
     * Test regex
     *
     */
    #[@test]
    public function regex() {
      $condition= $this->parseRuleSetFrom('
        # if the subject is all uppercase (no lowercase)
        if header :regex "subject" "^[^[:lower:]]+$" {
           discard;      # junk it
        }
      ')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.HeaderCondition');
      $this->assertEquals('regex', $condition->matchtype);   // Should be RegexMatchtype...
      $this->assertEquals(array('^[^[:lower:]]+$'), $condition->keys);
    }
  }
?>
