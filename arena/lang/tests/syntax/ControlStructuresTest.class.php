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
  class ControlStructuresTest extends TestCase {
  
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
      }', '<string:'.$this->name.'>'))->body['methods'][0]->body;
    }

    /**
     * Test if statement without else
     *
     */
    #[@test]
    public function ifStatement() {
      $this->assertEquals(array(new IfNode(array(
        'position'       => array(4, 11),
        'condition'      => new VariableNode(array('position' => array(4, 15), 'name' => '$i')),
        'statements'     => NULL,
        'otherwise'      => NULL, 
      ))), $this->parse('
        if ($i) { }
      '));
    }

    /**
     * Test if statement with else
     *
     */
    #[@test]
    public function ifElseStatement() {
      $this->assertEquals(array(new IfNode(array(
        'position'       => array(4, 11),
        'condition'      => new VariableNode(array('position' => array(4, 15), 'name' => '$i')),
        'statements'     => NULL, 
        'otherwise'      => new ElseNode(array(
          'position'       => array(4, 23),
          'statements'     => NULL,
        )), 
      ))), $this->parse('
        if ($i) { } else { }
      '));
    }

    /**
     * Test if /else cascades
     *
     */
    #[@test]
    public function ifElseCascades() {
      $this->assertEquals(array(new IfNode(array(
        'position'       => array(4, 11),
        'condition'      => new VariableNode(array('position' => array(4, 15), 'name' => '$i')),
        'statements'     => NULL, 
        'otherwise'      => new ElseNode(array(
          'position'       => array(4, 27),
          'statements'     => array(new IfNode(array(
            'position'       => array(4, 32),
            'condition'      => new VariableNode(array('position' => array(4, 36), 'name' => '$i')),
            'statements'     => NULL, 
            'otherwise'      => new ElseNode(array(
              'position'       => array(4, 48),
              'statements'     => NULL,
            )), 
          ))),
        )), 
      ))), $this->parse('
        if ($i % 3) { } else if ($i % 2) { } else { }
      '));
    }
  }
?>
