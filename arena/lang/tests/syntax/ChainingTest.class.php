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
  class ChainingTest extends TestCase {
  
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
     * Test simple method call on an object
     *
     */
    #[@test]
    public function methodCall() {
      $this->assertEquals(array(new VariableNode(array(
        'position'       => array(4, 11), 
        'name'           => '$m',
        'chained'        => new InvocationNode(array(
          'position'       => array(4, 21), 
          'name'           => 'invoke',
          'parameters'     => array(new VariableNode(array(
            'position'       => array(4, 22), 
            'name'           => '$args',
          )))
        ))
      ))), $this->parse('
        $m->invoke($args);
      '));
    }

    /**
     * Test chained method calls
     *
     */
    #[@test]
    public function chainedMethodCalls() {
      $this->assertEquals(array(new VariableNode(array(
        'position'       => array(4, 11), 
        'name'           => '$l',
        'chained'        => new InvocationNode(array(
          'position'       => array(4, 27), 
          'name'           => 'withAppender',
          'parameters'     => NULL,
          'chained'          => new InvocationNode(array(
            'position'       => array(4, 36), 
            'name'           => 'debug',
            'parameters'     => NULL,
          ))
        ))
      ))), $this->parse('
        $l->withAppender()->debug();
      '));
    }

    /**
     * Test chained method calls
     *
     */
    #[@test]
    public function chainedAfterNew() {
      $this->assertEquals(array(new InstanceCreationNode(array(
        'position'       => array(4, 11), 
        'type'           => new TypeName('Date'),
        'parameters'     => NULL,
        'chained'        => new InvocationNode(array(
          'position'       => array(4, 31), 
          'name'           => 'toString',
          'parameters'     => NULL,
        ))
      ))), $this->parse('
        new Date()->toString();
      '));
    }

    /**
     * Test chained method calls
     *
     */
    #[@test]
    public function arrayOffsetOnMethod() {
      $this->assertEquals(array(new VariableNode(array(
        'position'       => array(4, 11), 
        'name'           => '$l',
        'chained'        => new InvocationNode(array(
          'position'       => array(4, 23), 
          'name'           => 'elements',
          'parameters'     => NULL,
          'chained'          => new ArrayAccessNode(array(
            'position'       => array(4, 25), 
            'offset'         => new NumberNode(array('position' => array(4, 26), 'value' => '0')),
            'chained'        => new VariableNode(array(
              'position'       => array(4, 34), 
              'name'           => 'name'            
            ))
          ))
        ))
      ))), $this->parse('
        $l->elements()[0]->name;
      '));
    }
  }
?>
