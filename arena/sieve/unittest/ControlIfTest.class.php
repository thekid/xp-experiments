<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase
   *
   * @see      xp://peer.sieve.Rule
   * @purpose  Unittest
   */
  class ControlIfTest extends SieveParserTestCase {

    /**
     * Test if
     *
     */
    #[@test]
    public function ifWithoutElse() {
      $ruleset= $this->parseRuleSetFrom('
        if header :contains "from" "coyote" {
           discard;
        }
      ');
      $this->assertEquals(1, $ruleset->size());
    }

    /**
     * Test if with else
     *
     */
    #[@test]
    public function ifWithElse() {
      $ruleset= $this->parseRuleSetFrom('
        if header :contains "from" "coyote" {
           discard;
        } else {
           fileinto "INBOX";
        }
      ');
      $this->assertEquals(1, $ruleset->size());
    }

    /**
     * Test if with elsif
     *
     */
    #[@test]
    public function ifWithElseIf() {
      $ruleset= $this->parseRuleSetFrom('
        if header :contains "from" "coyote" {
           discard;
        } elsif header :contains ["subject"] ["$$$"] {
           discard;
        }
      ');
      $this->assertEquals(1, $ruleset->size());
    }

    /**
     * Test if with elsif
     *
     */
    #[@test]
    public function ifWithElseIfAndElse() {
      $ruleset= $this->parseRuleSetFrom('
        if header :contains "from" "coyote" {
           discard;
        } elsif header :contains ["subject"] ["$$$"] {
           discard;
        } else {
           fileinto "INBOX";
        }
      ');
      $this->assertEquals(1, $ruleset->size());
    }

    /**
     * Test else may not be followed by elseif
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function elseMayNotFollowElseIf() {
      $this->parseRuleSetFrom('
        if header :contains "from" "coyote" {
           discard;
        } else {
           fileinto "INBOX";
        } elsif header :contains ["subject"] ["$$$"] {
           discard;
        }
      ');
    }

    /**
     * Test else may not be followed by else
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function elseMayNotFollowElse() {
      $this->parseRuleSetFrom('
        if header :contains "from" "coyote" {
           discard;
        } else {
           fileinto "INBOX";
        } else {
           discard;
        }
      ');
    }
  }
?>