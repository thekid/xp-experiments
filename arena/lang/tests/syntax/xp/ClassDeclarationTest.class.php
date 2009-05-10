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
  class ClassDeclarationTest extends ParserTestCase {
  
    /**
     * Parse method source and return statements inside this method.
     *
     * @param   string src
     * @return  xp.compiler.Node
     */
    protected function parse($src) {
      return create(new xp·compiler·syntax·xp·Parser())->parse(new xp·compiler·syntax·xp·Lexer($src, '<string:'.$this->name.'>'))->declaration;
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function emtpyClass() {
      $this->assertEquals(
        $this->create(new ClassNode(
          0,                          // Modifiers
          NULL,                       // Annotations
          new TypeName('Empty'),      // Name
          NULL,                       // Parent
          array(),                    // Implements
          NULL                        // Body
        ), array(1, 1)), 
        $this->parse('class Empty { }')
      );
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function annotatedClass() {
      $this->assertEquals(
        $this->create(new ClassNode(
          0,
          array(new AnnotationNode(array(
            'position'   => array(1, 13),
            'type'       => 'Deprecated'
          ))),
          new TypeName('Empty'),
          NULL,
          array(),
          NULL
        ), array(1, 15)), 
        $this->parse('[@Deprecated] class Empty { }')
      );
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function classWithParentClass() {
      $this->assertEquals(
        $this->create(new ClassNode(
          0,
          NULL,
          new TypeName('Class'),
          new TypeName('lang.Object'),
          array(),
          NULL
        ), array(1, 1)), 
        $this->parse('class Class extends lang.Object { }')
      );
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function classWithInterface() {
      $this->assertEquals(
        $this->create(new ClassNode(
          0,
          NULL,
          new TypeName('HttpConnection'),
          NULL,
          array(new TypeName('Traceable')),
          NULL
        ), array(1, 1)), 
        $this->parse('class HttpConnection implements Traceable { }')
      );
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function classWithInterfaces() {
      $this->assertEquals(
        $this->create(new ClassNode(
          0,
          NULL,
          new TypeName('Math'),
          NULL,
          array(new TypeName('util.Observer'), new TypeName('Traceable')),
          NULL
        ), array(1, 1)), 
        $this->parse('class Math implements util.Observer, Traceable { }')
      );
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function classWithParentClassAndInterface() {
      $this->assertEquals(
        $this->create(new ClassNode(
          0,
          NULL,
          new TypeName('Integer'),
          new TypeName('Number'),
          array(new TypeName('Observer')),
          NULL
        ), array(1, 1)), 
        $this->parse('class Integer extends Number implements Observer { }')
      );
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function publicClass() {
      $this->assertEquals(
        $this->create(new ClassNode(
          MODIFIER_PUBLIC,
          NULL,
          new TypeName('Class'),
          NULL,
          array(),
          NULL
        ), array(1, 8)), 
        $this->parse('public class Class { }')
      );
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function abstractClass() {
      $this->assertEquals(
        $this->create(new ClassNode(
          MODIFIER_PUBLIC | MODIFIER_ABSTRACT,
          NULL,
          new TypeName('Base'),
          NULL,
          array(),
          NULL
        ), array(1, 17)), 
        $this->parse('public abstract class Base { }')
      );
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function genericClass() {
      $this->assertEquals(
        $this->create(new ClassNode(
          0,
          NULL,
          new TypeName('Class', array(new TypeName('T'))),
          NULL,
          array(),
          NULL
        ), array(1, 1)), 
        $this->parse('class Class<T> { }')
      );
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function hashTableClass() {
      $this->assertEquals(
        $this->create(new ClassNode(
          0,
          NULL,
          new TypeName('HashTable', array(new TypeName('K'), new TypeName('V'))),
          NULL,
          array(new TypeName('Map', array(new TypeName('K'), new TypeName('V')))),
          NULL
        ), array(1, 1)), 
        $this->parse('class HashTable<K, V> implements Map<K, V> { }')
      );
    }

    /**
     * Test interface declaration
     *
     */
    #[@test]
    public function emtpyInterface() {
      $this->assertEquals(new InterfaceNode(array(
        'position'   => array(1, 1),
        'modifiers'  => 0,
        'annotations'=> NULL,
        'name'       => new TypeName('Empty'),
        'parents'    => array(),
        'body'       => NULL
      )), $this->parse('interface Empty { }'));
    }

    /**
     * Test interface declaration
     *
     */
    #[@test]
    public function genericInterface() {
      $this->assertEquals(new InterfaceNode(array(
        'position'   => array(1, 1),
        'modifiers'  => 0,
        'annotations'=> NULL,
        'name'       => new TypeName('Filter', array(new TypeName('T'))),
        'parents'    => array(),
        'body'       => NULL
      )), $this->parse('interface Filter<T> { }'));
    }

    /**
     * Test interface declaration
     *
     */
    #[@test]
    public function twoComponentGenericInterface() {
      $this->assertEquals(new InterfaceNode(array(
        'position'   => array(1, 1),
        'modifiers'  => 0,
        'annotations'=> NULL,
        'name'       => new TypeName('Map', array(new TypeName('K'), new TypeName('V'))),
        'parents'    => array(),
        'body'       => NULL
      )), $this->parse('interface Map<K, V> { }'));
    }

    /**
     * Test interface declaration
     *
     */
    #[@test]
    public function interfaceWithParent() {
      $this->assertEquals(new InterfaceNode(array(
        'position'   => array(1, 1),
        'modifiers'  => 0,
        'annotations'=> NULL,
        'name'       => new TypeName('Debuggable'),
        'parents'    => array(new TypeName('util.log.Traceable')),
        'body'       => NULL
      )), $this->parse('interface Debuggable extends util.log.Traceable { }'));
    }

    /**
     * Test interface declaration
     *
     */
    #[@test]
    public function interfaceWithParents() {
      $this->assertEquals(new InterfaceNode(array(
        'position'   => array(1, 1),
        'modifiers'  => 0,
        'annotations'=> NULL,
        'name'       => new TypeName('Debuggable'),
        'parents'    => array(new TypeName('Traceable'), new TypeName('Observer', array(new TypeName('T')))),
        'body'       => NULL
      )), $this->parse('interface Debuggable extends Traceable, Observer<T> { }'));
    }

    /**
     * Test enum declaration
     *
     */
    #[@test]
    public function emtpyEnum() {
      $this->assertEquals(new EnumNode(array(
        'position'   => array(1, 1),
        'modifiers'  => 0,
        'annotations'=> NULL,
        'name'       => new TypeName('Days'),
        'parent'     => NULL,
        'implements' => array(),
        'body'       => NULL
      )), $this->parse('enum Days { }'));
    }

    /**
     * Test enum declaration
     *
     */
    #[@test]
    public function abstractEnum() {
      $this->assertEquals(new EnumNode(array(
        'position'   => array(1, 10),
        'modifiers'  => MODIFIER_ABSTRACT,
        'annotations'=> NULL,
        'name'       => new TypeName('Days'),
        'parent'     => NULL,
        'implements' => array(),
        'body'       => NULL
      )), $this->parse('abstract enum Days { }'));
    }

    /**
     * Test array type cannot be used as class name
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function noArrayTypeAsClassName() {
      $this->parse('class int[] { }');
    }

    /**
     * Test array type cannot be used as enum name
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function noArrayTypeAsEnumName() {
      $this->parse('enum int[] { }');
    }

    /**
     * Test array type cannot be used as interface name
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function noArrayTypeAsInterfaceName() {
      $this->parse('interface int[] { }');
    }
  }
?>
