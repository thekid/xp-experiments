<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.SieveParserTestCase');

  /**
   * TestCase for notify extension
   *
   * @see      xp://peer.sieve.NotifyAction
   * @purpose  Unittest
   */
  class NotifyExtensionTest extends SieveParserTestCase {
 
    /**
     * Test a notify with method as its sole argument
     *
     */
    #[@test]
    public function methodOnly() {
      $action= $this->parseRuleSetFrom('
        if true { 
          notify "mailto:alm@example.com";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.NotifyAction');
      $this->assertEquals('mailto:alm@example.com', $action->method);
    }

    /**
     * Test a notify with method as its sole argument
     *
     */
    #[@test]
    public function telephoneUri() {
      $action= $this->parseRuleSetFrom('
        # don\'t need high importance notification for
        # a \'for your information\'
        if not header :contains "subject" "FYI:" {
            notify :importance "1" :message "BOSS: Dude!"
                               "tel:+14085551212";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.NotifyAction');
      $this->assertEquals('tel:+14085551212', $action->method);
    }

    /**
     * Test a notify with from
     *
     */
    #[@test]
    public function withFrom() {
      $action= $this->parseRuleSetFrom('
        if true { 
          notify :from "notify@example.com" "mailto:alm@example.com";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.NotifyAction');
      $this->assertEquals('notify@example.com', $action->from);
    }

    /**
     * Test a notify with importance
     *
     */
    #[@test]
    public function withImportance() {
      $action= $this->parseRuleSetFrom('
        if true { 
          notify :importance 1 "mailto:alm@example.com";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.NotifyAction');
      $this->assertEquals(1, $action->importance);
    }

    /**
     * Test a notify with options
     *
     */
    #[@test]
    public function withOptions() {
      $action= $this->parseRuleSetFrom('
        if true { 
          notify :options ["foo=bar"] "mailto:alm@example.com";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.NotifyAction');
      $this->assertEquals(array('foo=bar'), $action->options);
    }
    
    /**
     * Test a notify with options
     *
     */
    #[@test, @ignore('Tags without values cause problems!')]
    public function oldSyntax() {
      $action= $this->parseRuleSetFrom('
        if true {
          notify :method "mailto" :options "tom@example.com" :low :message "8ung Baby";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.NotifyAction');
    }
  }
?>
