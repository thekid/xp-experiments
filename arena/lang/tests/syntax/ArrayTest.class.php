<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('tests.syntax.ParserTestCase');

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
        'position'      => array(4, 11),
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
        'position'      => array(4, 11),
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
        'position'      => array(4, 11),
        'values'        => array(
          new NumberNode(array('position' => array(4, 12), 'value' => '1')),
          new NumberNode(array('position' => array(4, 15), 'value' => '2')),
          new NumberNode(array('position' => array(4, 18), 'value' => '3')),
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
        'position'      => array(4, 11),
        'values'        => array(
          new NumberNode(array('position' => array(4, 22), 'value' => '1')),
          new NumberNode(array('position' => array(4, 25), 'value' => '2')),
          new NumberNode(array('position' => array(4, 28), 'value' => '3')),
        ),
        'type'          => new TypeName('int'),
      ))), $this->parse('
        new int[] {1, 2, 3};
      '));
    }
  }
?>
