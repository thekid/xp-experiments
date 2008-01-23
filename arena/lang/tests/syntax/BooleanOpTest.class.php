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
  class BooleanOpTest extends TestCase {
  
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
     * Test boolean "or" operator (||)
     *
     */
    #[@test]
    public function booleanOr() {
      $this->assertEquals(array(new BooleanOpNode(array(
        'position'      => array(4, 19),
        'lhs'           => new VariableNode(array('position' => array(4, 11), 'name' => '$a')),
        'rhs'           => new VariableNode(array('position' => array(4, 17), 'name' => '$b')),
        'op'            => '||'
      ))), $this->parse('
        $a || $b;
      '));
    }

    /**
     * Test boolean "and" operator (&&)
     *
     */
    #[@test]
    public function booleanAnd() {
      $this->assertEquals(array(new BooleanOpNode(array(
        'position'      => array(4, 19),
        'lhs'           => new VariableNode(array('position' => array(4, 11), 'name' => '$a')),
        'rhs'           => new VariableNode(array('position' => array(4, 17), 'name' => '$b')),
        'op'            => '&&'
      ))), $this->parse('
        $a && $b;
      '));
    }
  }
?>
