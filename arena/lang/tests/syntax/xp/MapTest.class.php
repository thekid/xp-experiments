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
     * Test a non-empty untyped map
     *
     */
    #[@test]
    public function untypedMap() {
      $this->assertEquals(
        array(new MapNode(array(
          'elements'      => array(
            array(
              new IntegerNode(array('value' => '1')),
              new StringNode(array('value' => 'one')),
            ),
            array(
              new IntegerNode(array('value' => '2')),
              new StringNode(array('value' => 'two')),
            ),
            array(
              new IntegerNode(array('value' => '3')),
              new StringNode(array('value' => 'three')),
            ),
          ),
          'type'          => NULL,
        ))), 
        $this->parse('[ 1 : "one", 2 : "two", 3 : "three" ];')
      );
    }
  }
?>
