<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'peer.net.dns.RCode'
  );

  /**
   * TestCase
   *
   * @see   xp://peer.net.dns.RCode
   */
  class RCodeTest extends TestCase {
  
    /**
     * Test withId() method
     *
     */
    #[@test]
    public function success() {
      $this->assertEquals(RCode::$SUCCESS, RCode::withId(0));
    }

    /**
     * Test withId() method
     *
     */
    #[@test]
    public function coverage() {
      foreach (RCode::values() as $rcode) {
        $this->assertEquals($rcode, RCode::withId($rcode->ordinal()), $rcode->name());
      }
    }

    /**
     * Test withId() method
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function negativeId() {
      RCode::withId(-1);
    }
  }
?>
