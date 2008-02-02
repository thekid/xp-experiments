<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase for vacation extension
   *
   * Syntax:
   * <pre>
   *   vacation [":days" number] [":subject" string]
   *    [":from" string] [":addresses" string-list]
   *    [":mime"] [":handle" string] <reason: string>
   * </pre>
   *
   * @see      rfc://5230
   * @see      xp://peer.sieve.VacationAction
   * @purpose  Unittest
   */
  class VacationExtensionTest extends SieveParserTestCase {
 
    /**
     * Test a vacation with reason as sole argument
     *
     */
    #[@test]
    public function reasonOnly() {
      $action= $this->parseRuleSetFrom('
        if true { 
          vacation "Out of office";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.VacationAction');
      $this->assertEquals('Out of office', $action->reason);
    }

    /**
     * Test a vacation with days tag
     *
     */
    #[@test]
    public function withDays() {
      $action= $this->parseRuleSetFrom('
        if true { 
          vacation :days 7 "Out of office";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.VacationAction');
      $this->assertEquals(7, $action->days);
      $this->assertEquals('Out of office', $action->reason);
    }

    /**
     * Test a vacation with subject tag
     *
     */
    #[@test]
    public function withSubject() {
      $action= $this->parseRuleSetFrom('
        if true { 
          vacation :subject "Out of office" "I\'ll be back";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.VacationAction');
      $this->assertEquals('Out of office', $action->subject);
      $this->assertEquals('I\'ll be back', $action->reason);
    }

    /**
     * Test a vacation with from tag
     *
     */
    #[@test]
    public function withFrom() {
      $action= $this->parseRuleSetFrom('
        if true { 
          vacation :from "oo@example.com" "I\'ll be back";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.VacationAction');
      $this->assertEquals('oo@example.com', $action->from);
      $this->assertEquals('I\'ll be back', $action->reason);
    }

    /**
     * Test a vacation with mime tag
     *
     */
    #[@test, @ignore('Out of office assigned to :mime tag due to parser')]
    public function withMime() {
      $action= $this->parseRuleSetFrom('
        if true { 
          vacation :mime "Out of office";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.VacationAction');
      $this->assertTrue($action->mime);
      $this->assertEquals('Out of office', $action->reason);
    }

    /**
     * Test a vacation with addresses tag
     *
     */
    #[@test]
    public function withAddresses() {
      $action= $this->parseRuleSetFrom('
        if true { 
          vacation :addresses ["me@example.com", "you@example.com"] "Out of office";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.VacationAction');
      $this->assertEquals(array('me@example.com', 'you@example.com'), $action->addresses);
    }

    /**
     * Test a vacation with addresses tag
     *
     */
    #[@test]
    public function withHandle() {
      $action= $this->parseRuleSetFrom('
        require "vacation";

        if header :contains "subject" "lunch" {
            vacation :handle "ran-away" "I\'m out and can\'t meet for lunch";
        } else {
            vacation :handle "ran-away" "I\'m out";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.VacationAction');
      $this->assertEquals('ran-away', $action->handle);
    }
  }
?>
