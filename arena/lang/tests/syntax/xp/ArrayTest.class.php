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
  class ArrayTest extends ParserTestCase {

    /**
     * Test an empty untyped array
     *
     */
    #[@test]
    public function emptyUntypedArray() {
      $this->assertEquals(array(new ArrayNode(array(
        'position'      => array(4, 9),
        'values'        => NULL,
        'type'          => NULL,
      ))), $this->parse('
        [];
      '));
    }

    /**
     * Test an empty typed array
     *
     */
    #[@test]
    public function emptyTypedArray() {
      $this->assertEquals(array(new ArrayNode(array(
        'position'      => array(4, 9),
        'values'        => NULL,
        'type'          => new TypeName('int'),
      ))), $this->parse('
        new int[] {};
      '));
    }

    /**
     * Test a non-empty untyped array
     *
     */
    #[@test]
    public function untypedArray() {
      $this->assertEquals(array(new ArrayNode(array(
        'position'      => array(4, 9),
        'values'        => array(
          new IntegerNode(array('position' => array(4, 10), 'value' => '1')),
          new IntegerNode(array('position' => array(4, 13), 'value' => '2')),
          new IntegerNode(array('position' => array(4, 16), 'value' => '3')),
        ),
        'type'          => NULL,
      ))), $this->parse('
        [1, 2, 3];
      '));
    }

    /**
     * Test a non-empty typed array
     *
     */
    #[@test]
    public function typedArray() {
      $this->assertEquals(array(new ArrayNode(array(
        'position'      => array(4, 9),
        'values'        => array(
          new IntegerNode(array('position' => array(4, 20), 'value' => '1')),
          new IntegerNode(array('position' => array(4, 23), 'value' => '2')),
          new IntegerNode(array('position' => array(4, 26), 'value' => '3')),
        ),
        'type'          => new TypeName('int'),
      ))), $this->parse('
        new int[] {1, 2, 3};
      '));
    }
  }
?>
