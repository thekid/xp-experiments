<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'lang.types.ArrayList',
    'lang.extension.ArrayFiltersExtension',
    'lang.extension.ArraySortingExtension',
    'xml.extension.XmlExtension'
  );

  /**
   * TestCase
   *
   * @see      xp://lang.extension.ArraySortingExtension
   * @see      xp://lang.extension.ArrayFiltersExtension
   */
  class ArrayListExtensionTest extends TestCase {
  
    /**
     * Test sorted() extension method provided by ArraySortingExtension
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
     * Test filtered() extension method provided by ArrayFiltersExtension
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
     * Test a non-existing method, neither in the class nor as an 
     * extension.
     *
     */
    #[@test, @expect('lang.Error')]
    public function notAnExtensionMethod() {
      create(new ArrayList(3, 1, 2))->notAnExtensionMethod();
    }

    /**
     * Test a regular instance method call still works.
     *
     */
    #[@test]
    public function instanceMethod() {
      $this->assertEquals(
        'lang.types.ArrayList[3]@{3, 1, 2}', 
        create(new ArrayList(3, 1, 2))->toString()
      );
    }

    /**
     * Test sorted() extension method provided by ArraySortingExtension
     * also works for subclasses of ArrayList
     *
     */
    #[@test]
    public function subClassSorted() {
      $this->assertEquals(
        new ArrayList(1, 2, 3), 
        create(newinstance('lang.types.ArrayList', array(3, 1, 2), '{}'))->sorted()
      );
    }

    /**
     * Test 
     *
     */
    #[@test]
    public function onInterface() {
      $this->assertEquals(
        '<array><values><value>3</value><value>1</value><value>2</value></values><length>3</length><__id></__id></array>',
        create(new ArrayList(3, 1, 2))->asNode('array')->getSource(INDENT_NONE)
      );
    }
  }
?>
