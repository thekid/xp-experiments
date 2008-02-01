<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase
   *
   * @see      xp://peer.sieve.AllOfCondition
   * @purpose  Unittest
   */
  class AllOfTest extends SieveParserTestCase {

    /**
     * Test allof with one condition
     *
     */
    #[@test]
    public function oneCondition() {
      $condition= $this->parseRuleSetFrom('if allof (false) { discard; }')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.AllOfCondition');
      $this->assertEquals(1, $condition->numConditions());
      $this->assertClass($condition->conditionAt(0), 'peer.sieve.BooleanCondition');
    }

    /**
     * Test allof with two conditions
     *
     */
    #[@test]
    public function twoConditions() {
      $condition= $this->parseRuleSetFrom('if allof (size :over 1000, false) { discard; }')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.AllOfCondition');
      $this->assertEquals(2, $condition->numConditions());
      $this->assertClass($condition->conditionAt(0), 'peer.sieve.LargerThanCondition');
      $this->assertClass($condition->conditionAt(1), 'peer.sieve.BooleanCondition');
    }

    /**
     * Test allof with two conditions
     *
     */
    #[@test]
    public function threeConditions() {
      $condition= $this->parseRuleSetFrom('if allof (
        header :contains ["to", "cc"] "admin",
        header :contains "From" "admin.example.com",
        header :is "X-Admin" "yes"
      ) { 
        fileinto "admin"; stop; 
      }')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.AllOfCondition');
      $this->assertEquals(3, $condition->numConditions());
      $this->assertClass($condition->conditionAt(0), 'peer.sieve.HeaderCondition');
      $this->assertClass($condition->conditionAt(1), 'peer.sieve.HeaderCondition');
      $this->assertClass($condition->conditionAt(2), 'peer.sieve.HeaderCondition');
    }
  }
?>
