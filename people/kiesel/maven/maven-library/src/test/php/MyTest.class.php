<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'foo.FooClass'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class MyTest extends TestCase {
  
    /**
     * Test
     *
     */
    #[@test]
    public function testAnything() {
      $this->assertTrue(TRUE);
      // Yay
    }
  }
?>
