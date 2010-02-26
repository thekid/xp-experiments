<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('net.xp_lang.tests.syntax.xp.ParserTestCase');

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
     * Test "[string:int[]]"
     *
     */
    #[@test]
    public function stringToIntArray() {
      $this->assertEquals(array(new MapNode(array(
        'elements'      => NULL,
        'type'          => new TypeName('[string:int[]]'),
      ))), $this->parse('
        new [string:int[]] {:};
      '));
    }

    /**
     * Test "[var:var[]]"
     *
     */
    #[@test]
    public function varToVarArray() {
      $this->assertEquals(array(new MapNode(array(
        'elements'      => NULL,
        'type'          => new TypeName('[var:var[]]'),
      ))), $this->parse('
        new [var:var[]] {:};
      '));
    }

    /**
     * Test "[string:[string:int]]"
     *
     */
    #[@test]
    public function stringToStringIntArrayMap() {
      $this->assertEquals(array(new MapNode(array(
        'elements'      => NULL,
        'type'          => new TypeName('[string:[string:int]]'),
      ))), $this->parse('
        new [string:[string:int]] {:};
      '));
    }

    /**
     * Test "[string:util.Vector<lang.types.String>]"
     *
     */
    #[@test]
    public function stringToGeneric() {
      $this->assertEquals(array(new MapNode(array(
        'elements'      => NULL,
        'type'          => new TypeName('[string:util.Vector<lang.types.String>]'),
      ))), $this->parse('
        new [string:util.Vector<lang.types.String>] {:};
      '));
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function keyMayNotBeAnArray() {
      $this->parse('new [int[]:string] {:};');
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function keyMayNotBeAMap() {
      $this->parse('new [[string:string]:string] {:};');
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function keyMayNotBeGeneric() {
      $this->parse('new [util.Vector<lang.types.String>:string] {:};');
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
