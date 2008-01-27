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
  class ArrayOperatorTest extends TestCase {
  
    /**
     * Parse class source and return methods inside this class
     *
     * @param   string src
     * @return  xp.compiler.Node[]
     */
    protected function parse($src) {
      return create(new Parser())
        ->parse(new xp·compiler·Lexer($src, '<string:'.$this->name.'>'))
        ->declaration
        ->body['methods'];
    }

    /**
     * Test hashmap with operators
     *
     */
    #[@test]
    public function hashMap() {
      $this->assertEquals(array(
        new OperatorNode(array(
          'position'    => array(2, 38),
          'modifiers'   => MODIFIER_PUBLIC,
          'annotations' => NULL,
          'returns'     => new TypeName('void'),
          'symbol'      => array('name' => '$k', 'type' => new TypeName('K')),
          'arguments'   => array(array('name' => '$v', 'type' => new TypeName('V'))),
          'throws'      => NULL,
          'body'        => NULL,
        )),
        new OperatorNode(array(
          'position'    => array(3, 35),
          'modifiers'   => MODIFIER_PUBLIC,
          'annotations' => NULL,
          'returns'     => new TypeName('V'),
          'symbol'      => array('name' => '$k', 'type' => new TypeName('K')),
          'arguments'   => NULL,
          'throws'      => NULL,
          'body'        => NULL,
        )), 
      ), $this->parse('class HashMap<K, V> { 
        public void operator[K $k] (V $v) { }
        public V operator[K $k] () { }
      }'));
    }

    /**
     * Test vector with operators
     *
     */
    #[@test]
    public function vector() {
      $this->assertEquals(array(
        new OperatorNode(array(
          'position'    => array(2, 34),
          'modifiers'   => MODIFIER_PUBLIC,
          'annotations' => NULL,
          'returns'     => new TypeName('void'),
          'symbol'      => '[]',
          'arguments'   => array(array('name' => '$t', 'type' => new TypeName('T'))),
          'throws'      => NULL,
          'body'        => NULL,
        )),
        new OperatorNode(array(
          'position'    => array(3, 45),
          'modifiers'   => MODIFIER_PUBLIC,
          'annotations' => NULL,
          'returns'     => new TypeName('void'),
          'symbol'      => array('name' => '$offset', 'type' => new TypeName('int')),
          'arguments'   => array(array('name' => '$t', 'type' => new TypeName('T'))),
          'throws'      => NULL,
          'body'        => NULL,
        )),
        new OperatorNode(array(
          'position'    => array(4, 42),
          'modifiers'   => MODIFIER_PUBLIC,
          'annotations' => NULL,
          'returns'     => new TypeName('T'),
          'symbol'      => array('name' => '$offset', 'type' => new TypeName('int')),
          'arguments'   => NULL,
          'throws'      => NULL,
          'body'        => NULL,
        )), 
      ), $this->parse('class Vector<T> { 
        public void operator[] (T $t) { }
        public void operator[int $offset] (T $t) { }
        public T operator[int $offset] () { }
      }'));
    }
  }
?>
