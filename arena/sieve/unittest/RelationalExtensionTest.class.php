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
      $condition= $this->parseCommandSetFrom('
        if header :value "eq" "From" "idiot@example.com" {
          discard;
        }
      ')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.HeaderCondition');
      $this->assertEquals(new ValueMatch('eq'), $condition->matchtype);
    }

    /**
     * Test count
     *
     */
    #[@test]
    public function count() {
      $condition= $this->parseCommandSetFrom('
        if address :count "gt" ["To"] ["5"] {   # 
           # everything with more than 5 recipients in the "to" field
           # is considered SPAM
           fileinto "SPAM";
        }
      ')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.AddressCondition');
      $this->assertEquals(new CountMatch('gt'), $condition->matchtype);   // Should be ValueMatchType...
    }
  }
?>
