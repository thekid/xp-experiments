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
  class BinaryOpTest extends TestCase {
  
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
     * Test addition operator
     *
     */
    #[@test]
    public function addition() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 18),
        'lhs'           => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '+'
      ))), $this->parse('
        $i + 10;
      '));
    }

    /**
     * Test subtraction operator
     *
     */
    #[@test]
    public function subtraction() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 18),
        'lhs'           => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '-'
      ))), $this->parse('
        $i - 10;
      '));
    }

    /**
     * Test multiplication operator
     *
     */
    #[@test]
    public function multiplication() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 18),
        'lhs'           => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '*'
      ))), $this->parse('
        $i * 10;
      '));
    }

    /**
     * Test division operator
     *
     */
    #[@test]
    public function division() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 18),
        'lhs'           => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '/'
      ))), $this->parse('
        $i / 10;
      '));

    }

    /**
     * Test modulo operator
     *
     */
    #[@test]
    public function modulo() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 18),
        'lhs'           => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '%'
      ))), $this->parse('
        $i % 10;
      '));
    }
  }
?>
