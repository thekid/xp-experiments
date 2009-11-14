<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'collections.Lookup'
  );

  /**
   * TestCase for generic behaviour at runtime.
   *
   * @see   xp://collections.Lookup
   */
  class PrimitivesTest extends TestCase {
  
    /**
     * Test put() and get() methods with a primitive string as key
     *
     */
    #[@test]
    public function primitiveStringKey() {
      $l= create('new Lookup<string, TestCase>', array(
        'this' => $this
      ));
      $this->assertEquals($this, $l->get('this'));
    }
  }
?>
