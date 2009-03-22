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
  class FieldDeclarationTest extends ParserTestCase {
  
    /**
     * Parse class source and return statements inside field declaration
     *
     * @param   string src
     * @return  xp.compiler.Node[]
     */
    protected function parse($src) {
      return create(new xp·compiler·syntax·xp·Parser())->parse(new xp·compiler·syntax·xp·Lexer($src, '<string:'.$this->name.'>'))->declaration->body['fields'];
    }

    /**
     * Test field declaration
     *
     */
    #[@test]
    public function publicField() {
      $this->assertEquals(array(new FieldNode(array(
        'position'   => array(2, 30),
        'modifiers'  => MODIFIER_PUBLIC,
        'annotations'=> NULL,
        'name'       => '$name',
        'type'       => new TypeName('string'),
        'initialization' => NULL,
      ))), $this->parse('class Person { 
        public string $name;
      }'));
    }

    /**
     * Test field declaration
     *
     */
    #[@test]
    public function privateStaticField() {
      $this->assertEquals(array(new FieldNode(array(
        'position'   => array(2, 46),
        'modifiers'  => MODIFIER_PRIVATE | MODIFIER_STATIC,
        'annotations'=> NULL,
        'name'       => '$instance',
        'type'       => new TypeName('self'),
        'initialization' => new ConstantNode(array(
          'position'   => array(2, 46),
          'value'      => 'NULL'
        ))
      ))), $this->parse('class Logger { 
        private static self $instance= NULL;
      }'));
    }

    /**
     * Test property declaration
     *
     */
    #[@test]
    public function readOnlyProperty() {
      $this->assertEquals(array(
        new FieldNode(array(
          'position'   => array(2, 32),
          'modifiers'  => MODIFIER_PRIVATE,
          'annotations'=> NULL,
          'name'       => '$_name',
          'type'       => new TypeName('string'),
          'initialization' => NULL,
        )),
        new PropertyNode(array(
          'position'   => array(3, 30),
          'modifiers'  => MODIFIER_PUBLIC,
          'annotations'=> NULL,
          'type'       => new TypeName('string'),
          'name'       => 'name',
          'handlers'   => array(
            'get' => array(
              new ReturnNode(array(
                'position'   => array(3, 38),
                'expression' => $this->create(new VariableNode(
                  '$this',
                  $this->create(new VariableNode('_name'), array(3, 56))
                ), array(3, 45))
              ))
            )
          )
        ))
      ), $this->parse('class Person {
        private string $_name;
        public string name { get { return $this._name; } }
      }'));
    }

    /**
     * Test property declaration
     *
     */
    #[@test]
    public function readWriteProperty() {
      $this->assertEquals(array(
        new FieldNode(array(
          'position'   => array(2, 32),
          'modifiers'  => MODIFIER_PRIVATE,
          'annotations'=> NULL,
          'name'       => '$_name',
          'type'       => new TypeName('string'),
          'initialization' => NULL,
        )),
        new PropertyNode(array(
          'position'   => array(3, 30),
          'modifiers'  => MODIFIER_PUBLIC,
          'annotations'=> NULL,
          'type'       => new TypeName('string'),
          'name'       => 'name',
          'handlers'   => array(
            'get' => array(
              new ReturnNode(array(
                'position'   => array(4, 19),
                'expression' => $this->create(new VariableNode(
                  '$this',
                  $this->create(new VariableNode('_name'), array(4, 37))
                ), array(4, 26))
              ))
            ),
            'set' => array(
              new AssignmentNode(array(
                'position'   => array(5, 38),
                'variable'   => $this->create(new VariableNode(
                  '$this',
                  $this->create(new VariableNode('_name'), array(5, 30))
                ), array(5, 19)),
                'expression' => $this->create(new VariableNode(
                  '$value'
                ), array(5, 32)),
                'op'         => '='
              ))
            )
          )
        ))
      ), $this->parse('class Person {
        private string $_name;
        public string name { 
          get { return $this._name; } 
          set { $this._name= $value; }
        }
      }'));
    }

    /**
     * Test indexer property declaration
     *
     */
    #[@test]
    public function indexerProperty() {
      $this->assertEquals(array(
        new PropertyNode(array(
          'position'   => array(2, 36),
          'modifiers'  => MODIFIER_PUBLIC,
          'annotations'=> NULL,
          'type'       => new TypeName('T'),
          'name'       => 'this',
          'arguments'  => array(
            array(
              'name' => '$offset',
              'type' => new TypeName('int')
            )
          ),
          'handlers'   => array(
            'get'   => NULL,
            'set'   => NULL,
            'isset' => NULL,
            'unset' => NULL
          )
        ))
      ), $this->parse('class ArrayList {
        public T this[int $offset] { 
          get {  } 
          set {  }
          isset {  }
          unset {  }
        }
      }'));
    }
  }
?>
