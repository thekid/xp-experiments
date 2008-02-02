<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase
   *
   * @see      xp://peer.sieve.EnvelopeCondition
   * @purpose  Unittest
   */
  class EnvelopeTest extends SieveParserTestCase {

    /**
     * Test
     *
     */
    #[@test]
    public function allIsFrom() {
      $condition= $this->parseRuleSetFrom('
        require "envelope";
        if envelope :all :is "from" "tim@example.com" {
           discard;
        }
      ')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.EnvelopeCondition');
      $this->assertEquals(MatchType::is(), $condition->matchtype);
      $this->assertEquals(AddressPart::$all, $condition->addresspart);
      $this->assertEquals(array('from'), $condition->headers);
      $this->assertEquals(array('tim@example.com'), $condition->keys);
    }
  }
?>
