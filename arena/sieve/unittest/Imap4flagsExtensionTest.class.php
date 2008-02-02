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
  class Imap4flagsExtensionTest extends SieveParserTestCase {
 
    /**
     * Test a vacation with reason as sole argument
     *
     */
    #[@test]
    public function deleteFlag() {
      $action= $this->parseRuleSetFrom('
        if size :over 500K {
          addflag "\\Deleted";
        }
      ')->ruleAt(0)->actions[0];
      $this->assertClass($action, 'peer.sieve.AddFlagAction');
      $this->assertEquals(array('\Deleted'), $action->flags);
    }
  }
?>
