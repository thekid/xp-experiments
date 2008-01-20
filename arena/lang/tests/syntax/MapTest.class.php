<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.Lexer',
    'xp.compiler.Parser'
  );

  /**
   * TestCase
   *
   */
  class MapTest extends TestCase {
  
    /**
     * Parse method source and return statements inside this method.
     *
     * @param   string src
     * @return  xp.compiler.Node[]
     */
    protected function parse($src) {
      return create(new Parser())->parse(new xp·compiler·Lexer('class Container {
        public void method() {
          '.$src.'
        }
      }', '<string:'.$this->name.'>'))->declaration->body['methods'][0]->body;
    }

    /**
     * Test an empty untyped map
     *
     */
    #[@test, @ignore('Syntax yet to be defined')]
    public function emptyUntypedMap() {
      $this->assertEquals(array(new MapNode(array(
        'position'      => array(4, 11),
        'elements'      => NULL,
        'type'          => NULL,
      ))), $this->parse('
        {};
      '));
    }

    /**
     * Test a non-empty untyped map
     *
     */
    #[@test, @ignore('Syntax yet to be defined')]
    public function untypedMap() {
      $this->assertEquals(array(new MapNode(array(
        'position'      => array(4, 11),
        'elements'      => array(
          array(
            new NumberNode(array('position' => array(4, 13), 'value' => '1')),
            new StringNode(array('position' => array(4, 18), 'value' => 'one')),
          ),
          array(
            new NumberNode(array('position' => array(4, 23), 'value' => '2')),
            new StringNode(array('position' => array(4, 28), 'value' => 'two')),
          ),
          array(
            new NumberNode(array('position' => array(4, 33), 'value' => '3')),
            new StringNode(array('position' => array(4, 38), 'value' => 'three')),
          ),
        ),
        'type'          => NULL,
      ))), $this->parse('
        { 1 => "one", 2 => "two", 3 => "three" };
      '));
    }
  }
?>
