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
  class UnaryOpTest extends TestCase {
  
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
     * Test negation
     *
     */
    #[@test]
    public function negation() {
      $this->assertEquals(array(new UnaryOpNode(array(
        'position'      => array(4, 14),
        'expression'    => new VariableNode(array('position' => array(4, 12), 'name' => '$i')),
        'op'            => '!'
      ))), $this->parse('
        !$i;
      '));
    }

    /**
     * Test complement
     *
     */
    #[@test]
    public function complement() {
      $this->assertEquals(array(new UnaryOpNode(array(
        'position'      => array(4, 14),
        'expression'    => new VariableNode(array('position' => array(4, 12), 'name' => '$i')),
        'op'            => '~'
      ))), $this->parse('
        ~$i;
      '));
    }

    /**
     * Test increment
     *
     */
    #[@test]
    public function increment() {
      $this->assertEquals(array(new UnaryOpNode(array(
        'position'      => array(4, 15),
        'expression'    => new VariableNode(array('position' => array(4, 13), 'name' => '$i')),
        'op'            => '++'
      ))), $this->parse('
        ++$i;
      '));
    }

    /**
     * Test decrement
     *
     */
    #[@test]
    public function decrement() {
      $this->assertEquals(array(new UnaryOpNode(array(
        'position'      => array(4, 15),
        'expression'    => new VariableNode(array('position' => array(4, 13), 'name' => '$i')),
        'op'            => '--'
      ))), $this->parse('
        --$i;
      '));
    }
  }
?>
