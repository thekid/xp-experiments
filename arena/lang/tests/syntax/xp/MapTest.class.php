<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('tests.syntax.xp.ParserTestCase');

  /**
   * TestCase
   *
   */
  class MapTest extends ParserTestCase {
  
    /**
     * Test an empty untyped map
     *
     */
    #[@test]
    public function emptyUntypedMap() {
      $this->assertEquals(
        array(new MapNode(array(
          'elements'      => NULL,
          'type'          => NULL,
        ))), 
        $this->parse('[:];')
      );
    }

    /**
     * Test an empty typed map
     *
     */
    #[@test]
    public function emptyTypedMap() {
      $this->assertEquals(array(new MapNode(array(
        'elements'      => NULL,
        'type'          => new TypeName('[int:string]'),
      ))), $this->parse('
        new [int:string] {:};
      '));
    }

    /**
     * Test a non-empty untyped map
     *
     */
    #[@test]
    public function untypedMap() {
      $this->assertEquals(
        array(new MapNode(array(
          'elements'      => array(
            array(
              new IntegerNode('1'),
              new StringNode('one'),
            ),
            array(
              new IntegerNode('2'),
              new StringNode('two'),
            ),
            array(
              new IntegerNode('3'),
              new StringNode('three'),
            ),
          ),
          'type'          => NULL,
        ))), 
        $this->parse('[ 1 : "one", 2 : "two", 3 : "three" ];')
      );
    }

    /**
     * Test a non-empty typed map
     *
     */
    #[@test]
    public function typedMap() {
      $this->assertEquals(
        array(new MapNode(array(
          'elements'      => array(
            array(
              new IntegerNode('1'),
              new StringNode('one'),
            ),
            array(
              new IntegerNode('2'),
              new StringNode('two'),
            ),
            array(
              new IntegerNode('3'),
              new StringNode('three'),
            ),
          ),
        'type'          => new TypeName('[int:string]'),
        ))), 
        $this->parse('new [int:string] { 1 : "one", 2 : "two", 3 : "three" };')
      );
    }

    /**
     * Test a non-empty untyped map
     *
     */
    #[@test]
    public function untypedMapWithDanglingComma() {
      $this->assertEquals(
        array(new MapNode(array(
          'elements'      => array(
            array(
              new IntegerNode('1'),
              new StringNode('one'),
            ),
            array(
              new IntegerNode('2'),
              new StringNode('two'),
            ),
            array(
              new IntegerNode('3'),
              new StringNode('three'),
            ),
          ),
          'type'          => NULL,
        ))), 
        $this->parse('[ 1 : "one", 2 : "two", 3 : "three", ];')
      );
    }
  }
?>
