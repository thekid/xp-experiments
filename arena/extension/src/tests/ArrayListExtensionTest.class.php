<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'lang.extension.ArrayListExtension'
  );

  /**
   * TestCase
   *
   * @see      xp://lang.extension.ArrayListExtension
   */
  class ArrayListExtensionTest extends TestCase {
  
    /**
     * Test
     *
     */
    #[@test]
    public function sorted() {
      $this->assertEquals(
        new ArrayList(1, 2, 3), 
        create(new ArrayList(3, 1, 2))->sorted()
      );
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.Error')]
    public function notAnExtensionMethod() {
      create(new ArrayList(3, 1, 2))->notAnExtensionMethod();
    }

    /**
     * Test
     *
     */
    #[@test]
    public function instanceMethod() {
      $this->assertEquals(
        'lang.types.ArrayList[3]@{3, 1, 2}', 
        create(new ArrayList(3, 1, 2))->toString()
      );
    }
  }
?>
