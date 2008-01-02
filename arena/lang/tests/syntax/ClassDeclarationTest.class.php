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
  class ClassDeclarationTest extends TestCase {
  
    /**
     * Parse method source and return statements inside this method.
     *
     * @param   string src
     * @return  xp.compiler.Node
     */
    protected function parse($src) {
      return create(new Parser())->parse(new xp·compiler·Lexer($src, '<string:'.$this->name.'>'));
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function emtpyClass() {
      $this->assertEquals(new ClassNode(array(
        'position'   => array(1, 1),
        'modifiers'  => 0,
        'name'       => new TypeName('Empty'),
        'parent'     => NULL,
        'implements' => array(),
        'body'       => NULL
      )), $this->parse('class Empty { }'));
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function classWithParentClass() {
      $this->assertEquals(new ClassNode(array(
        'position'   => array(1, 1),
        'modifiers'  => 0,
        'name'       => new TypeName('Class'),
        'parent'     => new TypeName('lang.Object'),
        'implements' => array(),
        'body'       => NULL
      )), $this->parse('class Class extends lang.Object { }'));
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function classWithInterface() {
      $this->assertEquals(new ClassNode(array(
        'position'   => array(1, 1),
        'modifiers'  => 0,
        'name'       => new TypeName('HttpConnection'),
        'parent'     => NULL,
        'implements' => array(new TypeName('Traceable')),
        'body'       => NULL
      )), $this->parse('class HttpConnection implements Traceable { }'));
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function classWithInterfaces() {
      $this->assertEquals(new ClassNode(array(
        'position'   => array(1, 1),
        'modifiers'  => 0,
        'name'       => new TypeName('Math'),
        'parent'     => NULL,
        'implements' => array(new TypeName('util.Observer'), new TypeName('Traceable')),
        'body'       => NULL
      )), $this->parse('class Math implements util.Observer, Traceable { }'));
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function classWithParentClassAndInterface() {
      $this->assertEquals(new ClassNode(array(
        'position'   => array(1, 1),
        'modifiers'  => 0,
        'name'       => new TypeName('Integer'),
        'parent'     => new TypeName('Number'),
        'implements' => array(new TypeName('Observer')),
        'body'       => NULL
      )), $this->parse('class Integer extends Number implements Observer { }'));
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function publicClass() {
      $this->assertEquals(new ClassNode(array(
        'position'   => array(1, 8),
        'modifiers'  => MODIFIER_PUBLIC,
        'name'       => new TypeName('Class'),
        'parent'     => NULL,
        'implements' => array(),
        'body'       => NULL
      )), $this->parse('public class Class { }'));
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function abstractClass() {
      $this->assertEquals(new ClassNode(array(
        'position'   => array(1, 17),
        'modifiers'  => MODIFIER_PUBLIC | MODIFIER_ABSTRACT,
        'name'       => new TypeName('Base'),
        'parent'     => NULL,
        'implements' => array(),
        'body'       => NULL
      )), $this->parse('public abstract class Base { }'));
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function genericClass() {
      $this->assertEquals(new ClassNode(array(
        'position'   => array(1, 1),
        'modifiers'  => 0,
        'name'       => new TypeName('Class', array(new TypeName('T'))),
        'parent'     => NULL,
        'implements' => array(),
        'body'       => NULL
      )), $this->parse('class Class<T> { }'));
    }

    /**
     * Test class declaration
     *
     */
    #[@test]
    public function hashTableClass() {
      $this->assertEquals(new ClassNode(array(
        'position'   => array(1, 1),
        'modifiers'  => 0,
        'name'       => new TypeName('HashTable', array(new TypeName('K'), new TypeName('V'))),
        'parent'     => NULL,
        'implements' => array(new TypeName('Map', array(new TypeName('K'), new TypeName('V')))),
        'body'       => NULL
      )), $this->parse('class HashTable<K, V> implements Map<K, V> { }'));
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
        'name'       => new TypeName('Days'),
        'parent'     => NULL,
        'implements' => array(),
        'body'       => NULL
      )), $this->parse('abstract enum Days { }'));
    }
  }
?>
