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
  class TernaryTest extends TestCase {
  
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
     * Test ternary - expr ? expr : expr
     *
     */
    #[@test]
    public function ternary() {
      $this->assertEquals(array(new TernaryNode(array(
        'position'      => array(4, 21),
        'condition'     => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'expression'    => new NumberNode(array('position' => array(4, 16), 'value' => '1')),
        'conditional'   => new NumberNode(array('position' => array(4, 20), 'value' => '2')),
      ))), $this->parse('
        $i ? 1 : 2;
      '));
    }

    /**
     * Test ternary - expr ?: expr
     *
     */
    #[@test]
    public function withoutExpression() {
      $this->assertEquals(array(new TernaryNode(array(
        'position'      => array(4, 18),
        'condition'     => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'expression'    => NULL,
        'conditional'   => new NumberNode(array('position' => array(4, 17), 'value' => '2')),
      ))), $this->parse('
        $i ?: 2;
      '));
    }

    /**
     * Test ternary - expr ?: (expr ? expr : expr)
     *
     */
    #[@test]
    public function nested() {
      $this->assertEquals(array(new TernaryNode(array(
        'position'      => array(4, 29),
        'condition'     => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'expression'    => NULL,
        'conditional'   => new TernaryNode(array(
          'position'      => array(4, 28),
          'condition'     => new VariableNode(array('position' => array(4, 18), 'name' => '$f')),
          'expression'    => new NumberNode(array('position' => array(4, 23), 'value' => '1')),
          'conditional'   => new NumberNode(array('position' => array(4, 27), 'value' => '2')),
        ))
      ))), $this->parse('
        $i ?: ($f ? 1 : 2);
      '));
    }
  }
?>
