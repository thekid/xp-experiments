<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase
   *
   * @see      xp://peer.sieve.AddressCondition
   * @purpose  Unittest
   */
  class AddressTest extends SieveParserTestCase {

    /**
     * Test
     *
     */
    #[@test]
    public function isAllFrom() {
      $condition= $this->parseRuleSetFrom('
        if address :is :all "from" "tim@example.com" {
           discard;
        }
      ')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.AddressCondition');
      $this->assertEquals('is', $condition->matchtype);
      $this->assertEquals('all', $condition->addresspart);
      $this->assertEquals(array('from'), $condition->headers);
      $this->assertEquals(array('tim@example.com'), $condition->keys);
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function contains() {
      $condition= $this->parseRuleSetFrom('
        if address :contains ["To","TO","Cc","CC"] "tsk@example.com" {
           discard;
        }
      ')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.AddressCondition');
      $this->assertEquals('contains', $condition->matchtype);
      $this->assertEquals(array('To', 'TO', 'Cc', 'CC'), $condition->headers);
      $this->assertEquals(array('tsk@example.com'), $condition->keys);
    }
  }
?>
