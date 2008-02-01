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
    
  }
?>
