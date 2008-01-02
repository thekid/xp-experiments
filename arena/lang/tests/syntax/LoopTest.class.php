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
  class LoopTest extends TestCase {
  
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
     * Test for loop
     *
     */
    #[@test]
    public function forLoop() {
      $this->assertEquals(array(new ForNode(array(
        'position'       => array(4, 11),
        'initialization' => array(new AssignmentNode(array(
          'position'       => array(4, 21),
          'variable'       => new VariableNode(array('position' => array(4, 16), 'name' => '$i')),
          'expression'     => '0'
        ))),
        'condition'      => array(new VariableNode(array('position' => array(4, 23), 'name' => '$i'))),
        'loop'           => array(new VariableNode(array('position' => array(4, 34), 'name' => '$i'))),
        'statements'     => NULL, 
      ))), $this->parse('
        for ($i= 0; $i < 1000; $i++) { }
      '));
    }

    /**
     * Test foreach loop
     *
     */
    #[@test]
    public function foreachLoop() {
      $this->assertEquals(array(new ForeachNode(array(
        'position'      => array(4, 11),
        'expression'    => new VariableNode(array('position' => array(4, 20), 'name' => '$list')),
        'statements'    => NULL, 
      ))), $this->parse('
        foreach ($list as $key => $value) { }
      '));
    }

    /**
     * Test while loop
     *
     */
    #[@test]
    public function whileLoop() {
      $this->assertEquals(array(new WhileNode(array(
        'position'      => array(4, 11),
        'expression'    => new VariableNode(array('position' => array(4, 18), 'name' => '$i')),
        'statements'    => NULL, 
      ))), $this->parse('
        while ($i++ < 10000) { }
      '));
    }

    /**
     * Test foreach loop
     *
     */
    #[@test]
    public function doLoop() {
      $this->assertEquals(array(new DoNode(array(
        'position'      => array(4, 11),
        'expression'    => new VariableNode(array('position' => array(4, 25), 'name' => '$i')),
        'statements'    => NULL, 
      ))), $this->parse('
        do { } while ($i++ < 10000)
      '));
    }
  }
?>
