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
  class FieldDeclarationTest extends TestCase {
  
    /**
     * Parse method source and return statements inside this method.
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
          'name'       => '$_name',
          'type'       => new TypeName('string'),
          'initialization' => NULL,
        )),
        new PropertyNode(array(
          'position'   => array(3, 43),
          'modifiers'  => MODIFIER_PUBLIC,
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
          'name'       => '$_name',
          'type'       => new TypeName('string'),
          'initialization' => NULL,
        )),
        new PropertyNode(array(
          'position'   => array(3, 57),
          'modifiers'  => MODIFIER_PUBLIC,
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
          'type'       => new TypeName('string'),
          'initialization' => NULL,
        )),
        new PropertyNode(array(
          'position'   => array(3, 61),
          'modifiers'  => MODIFIER_PUBLIC,
          'name'       => '$name',
          'get'        => array(new ReturnNode(array(
            'position'   => array(3, 39),
            'expression' => new VariableNode(array(
              'position'    => array(3, 46), 
              'name'        => '$this',
              'chained'     => new VariableNode(array(
                'position'    => array(3, 58), 
                'name'        => '_name'
              ))
            ))
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
