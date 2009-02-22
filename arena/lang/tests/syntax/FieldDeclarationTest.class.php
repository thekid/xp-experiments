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
      return create(new Parser())->parse(new xp·compiler·Lexer($src, '<string:'.$this->name.'>'))->declaration->body['fields'];
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
        'initialization' => 'NULL',
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
          'position'   => array(3, 43),
          'modifiers'  => MODIFIER_PUBLIC,
          'annotations'=> NULL,
          'name'       => '$name',
          'get'        => '$_name',
          'set'        => NULL,
        ))
      ), $this->parse('class Person {
        private string $_name;
        public property $name get $_name;
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
          'position'   => array(3, 57),
          'modifiers'  => MODIFIER_PUBLIC,
          'annotations'=> NULL,
          'name'       => '$name',
          'get'        => '$_name',
          'set'        => 'setName',
        ))
      ), $this->parse('class Person {
        private string $_name;
        public property $name get $_name set setName();
      }'));
    }

    /**
     * Test property declaration
     *
     */
    #[@test]
    public function propertyWithGetBlock() {
      $this->assertEquals(array(
        new FieldNode(array(
          'position'   => array(2, 32),
          'modifiers'  => MODIFIER_PRIVATE,
          'name'       => '$_name',
          'annotations'=> NULL,
          'type'       => new TypeName('string'),
          'initialization' => NULL,
        )),
        new PropertyNode(array(
          'position'   => array(3, 61),
          'modifiers'  => MODIFIER_PUBLIC,
          'name'       => '$name',
          'annotations'=> NULL,
          'get'        => array(new ReturnNode(array(
            'position'   => array(3, 39),
            'expression' => $this->create(new VariableNode('$this', $this->create(new VariableNode('_name'), array(3, 58))), array(3, 46)),
          ))),
          'set'        => NULL,
        ))
      ), $this->parse('class Person {
        private string $_name;
        public property $name get { return $this->_name; };
      }'));
    }
  }
?>
