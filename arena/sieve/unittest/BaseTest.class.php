<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class BaseTest extends SieveParserTestCase {

    /**
     * Test
     *
     */
    #[@test]
    public function emptyScript() {
      $this->assertTrue($this->parseRuleSetFrom('')->isEmpty());
    }

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
  }
?>
