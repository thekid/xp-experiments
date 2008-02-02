<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase for vacation extension
   *
   * @see      rfc://5231
   * @purpose  Unittest
   */
  class RelationalExtensionTest extends SieveParserTestCase {
 
    /**
     * Test value
     *
     */
    #[@test]
    public function value() {
      $condition= $this->parseRuleSetFrom('
        if header :value "eq" "From" "idiot@example.com" {
          discard;
        }
      ')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.HeaderCondition');
      $this->assertEquals(array('value', 'eq'), $condition->matchtype);   // Should be ValueMatchType...
    }

    /**
     * Test count
     *
     */
    #[@test]
    public function count() {
      $condition= $this->parseRuleSetFrom('
        if address :count "gt" ["To"] ["5"] {   # 
           # everything with more than 5 recipients in the "to" field
           # is considered SPAM
           fileinto "SPAM";
        }
      ')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.AddressCondition');
      $this->assertEquals(array('count', 'gt'), $condition->matchtype);   // Should be ValueMatchType...
    }
  }
?>
