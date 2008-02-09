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
      $rule= $this->parseCommandSetFrom('
        if header :contains "from" "coyote" {
           discard;
        }
      ')->commandAt(0);
      $this->assertClass($rule, 'peer.sieve.Rule');
      $this->assertClass($rule->condition, 'peer.sieve.condition.HeaderCondition');
      $this->assertNull($rule->otherwise);
    }

    /**
     * Test if with else
     *
     */
    #[@test]
    public function ifWithElse() {
      $rule= $this->parseCommandSetFrom('
        if header :contains "from" "coyote" {
           discard;
        } else {
           fileinto "INBOX";
        }
      ')->commandAt(0);
      $this->assertClass($rule, 'peer.sieve.Rule');
      $this->assertClass($rule->condition, 'peer.sieve.condition.HeaderCondition');
      $this->assertClass($rule->otherwise, 'peer.sieve.Rule');
      $this->assertClass($rule->otherwise->condition, 'peer.sieve.condition.NegationOfCondition');
      $this->assertEquals($rule->otherwise->condition->negated, $rule->condition);
    }

    /**
     * Test if with elsif
     *
     */
    #[@test]
    public function ifWithElseIf() {
      $rule= $this->parseCommandSetFrom('
        if header :contains "from" "coyote" {
           discard;
        } elsif header :contains ["subject"] ["$$$"] {
           discard;
        }
      ')->commandAt(0);
      $this->assertClass($rule, 'peer.sieve.Rule');
      $this->assertClass($rule->condition, 'peer.sieve.condition.HeaderCondition');
      $this->assertClass($rule->otherwise, 'peer.sieve.Rule');
      $this->assertClass($rule->otherwise->condition, 'peer.sieve.condition.HeaderCondition');
    }

    /**
     * Test if with elsif
     *
     */
    #[@test]
    public function ifWithElseIfAndElse() {
      $rule= $this->parseCommandSetFrom('
        if header :contains "from" "coyote" {
           discard;
        } elsif header :contains ["subject"] ["$$$"] {
           discard;
        } else {
           fileinto "INBOX";
        }
      ')->commandAt(0);
      $this->assertClass($rule, 'peer.sieve.Rule');
      $this->assertClass($rule->condition, 'peer.sieve.condition.HeaderCondition');
      $this->assertClass($rule->otherwise, 'peer.sieve.Rule');
      $this->assertClass($rule->otherwise->condition, 'peer.sieve.condition.HeaderCondition');
      $this->assertClass($rule->otherwise->otherwise, 'peer.sieve.Rule');
      $this->assertClass($rule->otherwise->otherwise->condition, 'peer.sieve.condition.NegationOfCondition');
      $this->assertEquals($rule->otherwise->otherwise->condition->negated, $rule->otherwise->condition);
    }

    /**
     * Test else may not be followed by elseif
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function elseMayNotFollowElseIf() {
      $this->parse('
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
      $this->parse('
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
