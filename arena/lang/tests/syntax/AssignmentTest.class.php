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
  class AssignmentTest extends TestCase {
  
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
     * Test assigning to a variable
     *
     */
    #[@test]
    public function toVariable() {
      $this->assertEquals(array(new AssignmentNode(array(
        'position'      => array(4, 16),
        'variable'      => new VariableNode(array('position' => array(4, 11), 'name' => '$i')),
        'expression'    => new NumberNode(array('position' => array(4, 15), 'value' => '0')),
        'op'            => '='
      ))), $this->parse('
        $i= 0;
      '));
    }

    /**
     * Test assigning to an instance member
     *
     */
    #[@test]
    public function toInstanceMember() {
      $this->assertEquals(array(new AssignmentNode(array(
        'position'      => array(4, 28),
        'variable'      => new VariableNode(array(
          'position'      => array(4, 11), 
          'name'          => '$class',
          'chained'       => new VariableNode(array(
            'position'      => array(4, 25), 
            'name'          => 'member',
          ))
        )),
        'expression'    => new NumberNode(array('position' => array(4, 27), 'value' => '0')),
        'op'            => '='
      ))), $this->parse('
        $class->member= 0;
      '));
    }

    /**
     * Test assigning to a class member
     *
     */
    #[@test]
    public function toClassMember() {
      $this->assertEquals(array(new AssignmentNode(array(
        'position'      => array(4, 32),
        'variable'      => new ClassMemberNode(array(
          'position'      => array(4, 17), 
          'class'         => new TypeName('self'),
          'member'        => new VariableNode(array(
            'position'      => array(4, 26), 
            'name'          => '$instance',
          ))
        )),
        'expression'    => 'NULL',    // FIXME: ConstantNode?
        'op'            => '='
      ))), $this->parse('
        self::$instance= NULL;
      '));
    }

    /**
     * Test assigning to a class member
     *
     */
    #[@test]
    public function toChain() {
      $this->assertEquals(array(new AssignmentNode(array(
        'position'      => array(4, 51),
        'variable'      => new ClassMemberNode(array(
          'position'      => array(4, 17), 
          'class'         => new TypeName('self'),
          'member'        => new VariableNode(array(
            'position'      => array(4, 48), 
            'name'          => '$instance',
            'chained'       => new InvocationNode(array(
              'position'       => array(4, 39), 
              'name'           => 'addAppender',
              'parameters'     => NULL,
              'chained'        => new VariableNode(array('position' => array(4, 48), 'name' => 'flags')),
            ))
          ))
        )),
        'expression'    =>  new NumberNode(array('position' => array(4, 50), 'value' => '0')),
        'op'            => '='
      ))), $this->parse('
        self::$instance->addAppender()->flags= 0;
      '));
    }
  }
?>
