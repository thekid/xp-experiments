<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('tests.syntax.xp.ParserTestCase');

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
        'm',
        new InvocationNode(array(
          'position'       => array(4, 18), 
          'name'           => 'invoke',
          'parameters'     => array(
            $this->create(new VariableNode('args'), array(4, 19))
          )
        ))
      ), array(4, 9))), $this->parse('
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
        'l',
        new InvocationNode(array(
          'position'       => array(4, 24), 
          'name'           => 'withAppender',
          'parameters'     => NULL,
          'chained'          => new InvocationNode(array(
            'position'       => array(4, 32), 
            'name'           => 'debug',
            'parameters'     => NULL,
          ))
        ))
      ), array(4, 9))), $this->parse('
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
        'position'       => array(4, 9), 
        'type'           => new TypeName('Date'),
        'parameters'     => NULL,
        'chained'        => new InvocationNode(array(
          'position'       => array(4, 28), 
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
        'l',
        new InvocationNode(array(
          'position'       => array(4, 20), 
          'name'           => 'elements',
          'parameters'     => NULL,
          'chained'          => new ArrayAccessNode(array(
            'position'       => array(4, 22), 
            'offset'         => new NumberNode(array('position' => array(4, 23), 'value' => '0')),
            'chained'        => $this->create(new VariableNode('name'), array(4, 30)),
          ))
        ))
      ), array(4, 9))), $this->parse('
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
        'position'       => array(4, 15),
        'class'          => new TypeName('Logger'),
        'member'         => new InvocationNode(array(
          'position'       => array(4, 29), 
          'name'           => 'getInstance',
          'parameters'     => NULL,
          'chained'          => new InvocationNode(array(
            'position'       => array(4, 40), 
            'name'           => 'configure',
            'parameters'     => array(
              new StringNode(array('position' => array(4, 41), 'value' => 'etc'))
            ),
          ))
        ))
      ))), $this->parse('
        Logger::getInstance().configure("etc");
      '));
    }
  }
?>
