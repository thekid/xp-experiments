<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('tests.syntax.ParserTestCase');

  /**
   * TestCase
   *
   */
  class ChainingTest extends ParserTestCase {
  
    /**
     * Test simple method call on an object
     *
     */
    #[@test]
    public function methodCall() {
      $this->assertEquals(array($this->create(new VariableNode(
        '$m',
        new InvocationNode(array(
          'position'       => array(4, 20), 
          'name'           => 'invoke',
          'parameters'     => array(
            $this->create(new VariableNode('$args'), array(4, 21))
          )
        ))
      ), array(4, 11))), $this->parse('
        $m.invoke($args);
      '));
    }

    /**
     * Test chained method calls
     *
     */
    #[@test]
    public function chainedMethodCalls() {
      $this->assertEquals(array($this->create(new VariableNode(
        '$l',
        new InvocationNode(array(
          'position'       => array(4, 26), 
          'name'           => 'withAppender',
          'parameters'     => NULL,
          'chained'          => new InvocationNode(array(
            'position'       => array(4, 34), 
            'name'           => 'debug',
            'parameters'     => NULL,
          ))
        ))
      ), array(4, 11))), $this->parse('
        $l.withAppender().debug();
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
          'position'       => array(4, 30), 
          'name'           => 'toString',
          'parameters'     => NULL,
        ))
      ))), $this->parse('
        new Date().toString();
      '));
    }

    /**
     * Test chained method calls
     *
     */
    #[@test]
    public function arrayOffsetOnMethod() {
      $this->assertEquals(array($this->create(new VariableNode(
        '$l',
        new InvocationNode(array(
          'position'       => array(4, 22), 
          'name'           => 'elements',
          'parameters'     => NULL,
          'chained'          => new ArrayAccessNode(array(
            'position'       => array(4, 24), 
            'offset'         => new NumberNode(array('position' => array(4, 25), 'value' => '0')),
            'chained'        => $this->create(new VariableNode('name'), array(4, 32)),
          ))
        ))
      ), array(4, 11))), $this->parse('
        $l.elements()[0].name;
      '));
    }

    /**
     * Test chained method calls
     *
     */
    #[@test]
    public function chainedAfterStaticMethod() {
      $this->assertEquals(array(new ClassMemberNode(array(
        'position'       => array(4, 19), 
        'class'          => new TypeName('Logger'),
        'member'         => new InvocationNode(array(
          'position'       => array(4, 31), 
          'name'           => 'getInstance',
          'parameters'     => NULL,
          'chained'          => new InvocationNode(array(
            'position'       => array(4, 42), 
            'name'           => 'configure',
            'parameters'     => array(
              new StringNode(array('position' => array(4, 43), 'value' => 'etc'))
            ),
          ))
        ))
      ))), $this->parse('
        Logger::getInstance().configure("etc");
      '));
    }
  }
?>
