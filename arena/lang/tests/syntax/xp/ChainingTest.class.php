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
      $this->assertEquals(array(
        $this->create(new ChainNode(array(
          0 => $this->create(new VariableNode('m'), array(4, 9)),
          1 => $this->create(new InvocationNode(array(
            'name'           => 'invoke',
            'parameters'     => array($this->create(new VariableNode('args'), array(4, 19)))
          )), array(4, 18))
        )), array(4, 25))), $this->parse('
        $m.invoke($args);
      '));
    }

    /**
     * Test chained method calls
     *
     */
    #[@test]
    public function chainedMethodCalls() {
      $this->assertEquals(array(
        $this->create(new ChainNode(array(
          0 => $this->create(new VariableNode('l'), array(4, 9)),
          1 => $this->create(new InvocationNode(array(
            'name'           => 'withAppender',
            'parameters'     => array()
          )), array(4, 24)),
          2 => $this->create(new InvocationNode(array(
            'name'           => 'debug',
            'parameters'     => array()
          )), array(4, 32)),
        )), array(4, 34))), $this->parse('
        $l.withAppender().debug();
      '));
    }

    /**
     * Test chained method calls
     *
     */
    #[@test]
    public function chainedAfterNew() {
      $this->assertEquals(array(
        $this->create(new ChainNode(array(
          0 => $this->create(new InstanceCreationNode(array(
            'type'           => new TypeName('Date'),
            'parameters'     => NULL,
          )), array(4, 9)),
          1 => $this->create(new InvocationNode(array(
            'name'           => 'toString',
            'parameters'     => array()
          )), array(4, 28))
        )), array(4, 30))), $this->parse('
        new Date().toString();
      '));
    }

    /**
     * Test chained method calls
     *
     */
    #[@test]
    public function arrayOffsetOnMethod() {
      $this->assertEquals(array(
        $this->create(new ChainNode(array(
          0 => $this->create(new VariableNode('l'), array(4, 9)),
          1 => $this->create(new InvocationNode(array(
            'name'           => 'elements',
            'parameters'     => array()
          )), array(4, 20)),
          2 => $this->create(new ArrayAccessNode(array(
            'offset'         => $this->create(new IntegerNode(array('value' => '0')), array(4, 23)),
          )), array(4, 22)),
          3 => $this->create(new VariableNode('name'), array(4, 30)),
        )), array(4, 30))), $this->parse('
        $l.elements()[0].name;
      '));
    }

    /**
     * Test chained method calls
     *
     */
    #[@test]
    public function chainedAfterStaticMethod() {
      $this->assertEquals(array(
        $this->create(new ChainNode(array(
          0 => $this->create(new ClassMemberNode(array(
            'class'  => new TypeName('Logger'),
            'member' => $this->create(new InvocationNode(array(
              'name'      => 'getInstance',
              'parameters' => array()
            )), array(4, 29)),
          )), array(4, 15)),
          1 => $this->create(new InvocationNode(array(
            'name'       => 'configure',
            'parameters' => array($this->create(new StringNode(array('value' => 'etc')), array(4, 41)))
          )), array(4, 40))
        )), array(4, 47))), $this->parse('
        Logger::getInstance().configure("etc");
      '));
    }
  }
?>
