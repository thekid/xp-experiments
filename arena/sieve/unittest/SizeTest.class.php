<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase
   *
   * @see      xp://peer.sieve.SizeCondition
   * @purpose  Unittest
   */
  class SizeTest extends SieveParserTestCase {

    /**
     * Test :over
     *
     */
    #[@test]
    public function largerThanCondition() {
      $condition= $this->parseRuleSetFrom('if size :over 1000 { discard; }')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.LargerThanCondition');
      $this->assertEquals(1000, $condition->value);
    }
    
    /**
     * Test :under
     *
     */
    #[@test]
    public function smallerThanCondition() {
      $condition= $this->parseRuleSetFrom('if size :under 1000 { discard; }')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.SmallerThanCondition');
      $this->assertEquals(1000, $condition->value);
    }

    /**
     * Test :exceeds is not a valid argument
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function invalidArgument() {
      $this->parseRuleSetFrom('if size :exceeds 1000 { discard; }');
    }
  }
?>
