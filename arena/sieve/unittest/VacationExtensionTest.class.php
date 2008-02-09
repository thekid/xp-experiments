<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase for vacation extension
   *
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
      $action= $this->parseCommandSetFrom('
        if true { 
          vacation "Out of office";
        }
      ')->commandAt(0)->commands[0];
      $this->assertClass($action, 'peer.sieve.action.VacationAction');
      $this->assertEquals('Out of office', $action->reason);
    }

    /**
     * Test a vacation with days tag
     *
     */
    #[@test]
    public function withDays() {
      $action= $this->parseCommandSetFrom('
        if true { 
          vacation :days 7 "Out of office";
        }
      ')->commandAt(0)->commands[0];
      $this->assertClass($action, 'peer.sieve.action.VacationAction');
      $this->assertEquals(7, $action->days);
      $this->assertEquals('Out of office', $action->reason);
    }

    /**
     * Test a vacation with subject tag
     *
     */
    #[@test]
    public function withSubject() {
      $action= $this->parseCommandSetFrom('
        if true { 
          vacation :subject "Out of office" "I\'ll be back";
        }
      ')->commandAt(0)->commands[0];
      $this->assertClass($action, 'peer.sieve.action.VacationAction');
      $this->assertEquals('Out of office', $action->subject);
      $this->assertEquals('I\'ll be back', $action->reason);
    }

    /**
     * Test a vacation with from tag
     *
     */
    #[@test]
    public function withFrom() {
      $action= $this->parseCommandSetFrom('
        if true { 
          vacation :from "oo@example.com" "I\'ll be back";
        }
      ')->commandAt(0)->commands[0];
      $this->assertClass($action, 'peer.sieve.action.VacationAction');
      $this->assertEquals('oo@example.com', $action->from);
      $this->assertEquals('I\'ll be back', $action->reason);
    }

    /**
     * Test a vacation with mime tag
     *
     */
    #[@test, @ignore('Out of office assigned to :mime tag due to parser')]
    public function withMime() {
      $action= $this->parseCommandSetFrom('
        if true { 
          vacation :mime "Out of office";
        }
      ')->commandAt(0)->commands[0];
      $this->assertClass($action, 'peer.sieve.action.VacationAction');
      $this->assertTrue($action->mime);
      $this->assertEquals('Out of office', $action->reason);
    }

    /**
     * Test a vacation with addresses tag
     *
     */
    #[@test]
    public function withAddresses() {
      $action= $this->parseCommandSetFrom('
        if true { 
          vacation :addresses ["me@example.com", "you@example.com"] "Out of office";
        }
      ')->commandAt(0)->commands[0];
      $this->assertClass($action, 'peer.sieve.action.VacationAction');
      $this->assertEquals(array('me@example.com', 'you@example.com'), $action->addresses);
    }

    /**
     * Test a vacation with addresses tag
     *
     */
    #[@test]
    public function withHandle() {
      $action= $this->parseCommandSetFrom('
        require "vacation";

        if header :contains "subject" "lunch" {
            vacation :handle "ran-away" "I\'m out and can\'t meet for lunch";
        } else {
            vacation :handle "ran-away" "I\'m out";
        }
      ')->commandAt(0)->commands[0];
      $this->assertClass($action, 'peer.sieve.action.VacationAction');
      $this->assertEquals('ran-away', $action->handle);
    }
  }
?>
