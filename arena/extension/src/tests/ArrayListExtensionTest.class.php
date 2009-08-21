<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'lang.extension.ArrayFiltersExtension',
    'lang.extension.ArraySortingExtension'
  );

  /**
   * TestCase
   *
   * @see      xp://lang.extension.ArraySortingExtension
   * @see      xp://lang.extension.ArrayFiltersExtension
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
    #[@test]
    public function filtered() {
      $this->assertEquals(
        new ArrayList(2, 4), 
        create(new ArrayList(1, 2, 3, 4))->filtered(newinstance('util.Filter', array(), '{
          public function accept($v) { return $v % 2 == 0; }
        }'))
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
