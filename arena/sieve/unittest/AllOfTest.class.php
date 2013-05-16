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
      $condition= $this->parseCommandSetFrom('if allof (false) { discard; }')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.AllOfCondition');
      $this->assertEquals(1, $condition->numConditions());
      $this->assertClass($condition->conditionAt(0), 'peer.sieve.condition.BooleanCondition');
    }

    /**
     * Test allof with two conditions
     *
     */
    #[@test]
    public function twoConditions() {
      $condition= $this->parseCommandSetFrom('if allof (size :over 1000, false) { discard; }')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.AllOfCondition');
      $this->assertEquals(2, $condition->numConditions());
      $this->assertClass($condition->conditionAt(0), 'peer.sieve.condition.LargerThanCondition');
      $this->assertClass($condition->conditionAt(1), 'peer.sieve.condition.BooleanCondition');
    }

    /**
     * Test allof with two conditions
     *
     */
    #[@test]
    public function threeConditions() {
      $condition= $this->parseCommandSetFrom('if allof (
        header :contains ["to", "cc"] "admin",
        header :contains "From" "admin.example.com",
        header :is "X-Admin" "yes"
      ) { 
        fileinto "admin"; stop; 
      }')->commandAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.condition.AllOfCondition');
      $this->assertEquals(3, $condition->numConditions());
      $this->assertClass($condition->conditionAt(0), 'peer.sieve.condition.HeaderCondition');
      $this->assertClass($condition->conditionAt(1), 'peer.sieve.condition.HeaderCondition');
      $this->assertClass($condition->conditionAt(2), 'peer.sieve.condition.HeaderCondition');
    }
  }
?>
