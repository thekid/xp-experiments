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
  class ArrayTest extends TestCase {
  
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
