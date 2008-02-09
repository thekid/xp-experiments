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
      $action= $this->parseCommandSetFrom('
        if true { 
          notify "mailto:alm@example.com";
        }
      ')->commandAt(0)->commands[0];
      $this->assertClass($action, 'peer.sieve.action.NotifyAction');
      $this->assertEquals('mailto:alm@example.com', $action->method);
    }

    /**
     * Test a notify with method as its sole argument
     *
     */
    #[@test]
    public function telephoneUri() {
      $action= $this->parseCommandSetFrom('
        # don\'t need high importance notification for
        # a \'for your information\'
        if not header :contains "subject" "FYI:" {
            notify :importance "1" :message "BOSS: Dude!"
                               "tel:+14085551212";
        }
      ')->commandAt(0)->commands[0];
      $this->assertClass($action, 'peer.sieve.action.NotifyAction');
      $this->assertEquals('tel:+14085551212', $action->method);
    }

    /**
     * Test a notify with from
     *
     */
    #[@test]
    public function withFrom() {
      $action= $this->parseCommandSetFrom('
        if true { 
          notify :from "notify@example.com" "mailto:alm@example.com";
        }
      ')->commandAt(0)->commands[0];
      $this->assertClass($action, 'peer.sieve.action.NotifyAction');
      $this->assertEquals('notify@example.com', $action->from);
    }

    /**
     * Test a notify with importance
     *
     */
    #[@test]
    public function withImportance() {
      $action= $this->parseCommandSetFrom('
        if true { 
          notify :importance 1 "mailto:alm@example.com";
        }
      ')->commandAt(0)->commands[0];
      $this->assertClass($action, 'peer.sieve.action.NotifyAction');
      $this->assertEquals(1, $action->importance);
    }

    /**
     * Test a notify with options
     *
     */
    #[@test]
    public function withOptions() {
      $action= $this->parseCommandSetFrom('
        if true { 
          notify :options ["foo=bar"] "mailto:alm@example.com";
        }
      ')->commandAt(0)->commands[0];
      $this->assertClass($action, 'peer.sieve.action.NotifyAction');
      $this->assertEquals(array('foo=bar'), $action->options);
    }
    
    /**
     * Test a notify with options
     *
     */
    #[@test, @ignore('Tags without values cause problems!')]
    public function oldSyntax() {
      $action= $this->parseCommandSetFrom('
        if true {
          notify :method "mailto" :options "tom@example.com" :low :message "8ung Baby";
        }
      ')->commandAt(0)->commands[0];
      $this->assertClass($action, 'peer.sieve.action.NotifyAction');
    }
  }
?>
