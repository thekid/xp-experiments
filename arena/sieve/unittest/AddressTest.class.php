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
      $this->assertEquals(MatchType::is(), $condition->matchtype);
      $this->assertEquals(AddressPart::$all, $condition->addresspart);
      $this->assertEquals(array('from'), $condition->headers);
      $this->assertEquals(array('tim@example.com'), $condition->keys);
    }

    /**
     * Test
     *
     */
    #[@test]
    public function isDomainFrom() {
      $condition= $this->parseRuleSetFrom('
        if address :is :domain "from" "example.com" {
           discard;
        }
      ')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.AddressCondition');
      $this->assertEquals(MatchType::is(), $condition->matchtype);
      $this->assertEquals(AddressPart::$domain, $condition->addresspart);
      $this->assertEquals(array('from'), $condition->headers);
      $this->assertEquals(array('example.com'), $condition->keys);
    }

    /**
     * Test
     *
     */
    #[@test]
    public function isLocalpartFrom() {
      $condition= $this->parseRuleSetFrom('
        if address :is :localpart "from" "tim" {
           discard;
        }
      ')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.AddressCondition');
      $this->assertEquals(MatchType::is(), $condition->matchtype);
      $this->assertEquals(AddressPart::$localpart, $condition->addresspart);
      $this->assertEquals(array('from'), $condition->headers);
      $this->assertEquals(array('tim'), $condition->keys);
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
      $this->assertEquals(MatchType::contains(), $condition->matchtype);
      $this->assertEquals(array('To', 'TO', 'Cc', 'CC'), $condition->headers);
      $this->assertEquals(array('tsk@example.com'), $condition->keys);
    }

    /**
     * Test
     *
     */
    #[@test]
    public function matches() {
      $condition= $this->parseRuleSetFrom('
        if address :matches ["To", "Cc"] ["coyote@**.com", "wile@**.com"] {
           fileinto "INBOX.business.${2}"; stop;
        }
      ')->ruleAt(0)->condition;
      $this->assertClass($condition, 'peer.sieve.AddressCondition');
      $this->assertEquals(MatchType::matches(), $condition->matchtype);
      $this->assertEquals(array('To', 'Cc'), $condition->headers);
      $this->assertEquals(array('coyote@**.com', 'wile@**.com'), $condition->keys);
    }
  }
?>
