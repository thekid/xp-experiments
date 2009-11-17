<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'collections.Lookup',
    'lang.types.String'
  );

  /**
   * TestCase for generic behaviour at runtime.
   *
   * @see   xp://collections.Lookup
   */
  class PrimitivesTest extends TestCase {
  
    /**
     * Test put() and get() methods with a primitive string as key
     *
     */
    #[@test]
    public function primitiveStringKey() {
      $l= create('new Lookup<string, TestCase>', array(
        'this' => $this
      ));
      $this->assertEquals($this, $l->get('this'));
    }

    /**
     * Test put() and get() methods with a primitive string as key
     *
     */
    #[@test]
    public function primitiveStringValue() {
      $l= create('new Lookup<TestCase, string>()');
      $l->put($this, 'this');
      $this->assertEquals('this', $l->get($this));
    }

    /**
     * Test put() does not accept another primitive
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function primitiveVerification() {
      $l= create('new Lookup<string, TestCase>()');
      $l->put(1, $this);
    }

    /**
     * Test put() does not accept instance
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function instanceVerification() {
      $l= create('new Lookup<string, TestCase>()');
      $l->put(new String('Hello'), $this);
    }

    /**
     * Test getClass()
     *
     */
    #[@test]
    public function nameOfClass() {
      $type= XPClass::forName('collections.Lookup')->newGenericType(array(
        Primitive::$STRING,
        XPClass::forName('unittest.TestCase')
      ));
      $this->assertEquals('collections.Lookup`2[string,unittest.TestCase]', $type->getName());
    }

    /**
     * Test genericArguments()
     *
     */
    #[@test]
    public function typeArguments() {
      $this->assertEquals(
        array(Primitive::$STRING, XPClass::forName('unittest.TestCase')),
        create('new Lookup<string, TestCase>()')->getClass()->genericArguments()
      );
    }
  }
?>
