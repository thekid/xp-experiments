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
      $this->assertEquals(array(new MapNode(array(
        'position'      => array(4, 11),
        'elements'      => NULL,
        'type'          => NULL,
      ))), $this->parse('
        [:];
      '));
    }

    /**
     * Test a non-empty untyped map
     *
     */
    #[@test]
    public function untypedMap() {
      $this->assertEquals(array(new MapNode(array(
        'position'      => array(4, 11),
        'elements'      => array(
          array(
            new NumberNode(array('position' => array(4, 13), 'value' => '1')),
            new StringNode(array('position' => array(4, 17), 'value' => 'one')),
          ),
          array(
            new NumberNode(array('position' => array(4, 22), 'value' => '2')),
            new StringNode(array('position' => array(4, 26), 'value' => 'two')),
          ),
          array(
            new NumberNode(array('position' => array(4, 31), 'value' => '3')),
            new StringNode(array('position' => array(4, 35), 'value' => 'three')),
          ),
        ),
        'type'          => NULL,
      ))), $this->parse('
        [ 1 : "one", 2 : "two", 3 : "three" ];
      '));
    }
  }
?>
