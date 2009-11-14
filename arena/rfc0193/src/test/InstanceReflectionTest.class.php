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
   * TestCase for instance reflection
   *
   * @see   xp://collections.Lookup
   */
  class InstanceReflectionTest extends TestCase {
    protected $fixture= NULL;
    
    /**
     * Creates fixture, a Lookup with String and TestCase as component
     * types.
     *
     */  
    public function setUp() {
      $this->fixture= create('new Lookup<String, TestCase>()');
    }
  
    /**
     * Test getClassName() on generic instance
     *
     */
    #[@test]
    public function getClassNameMethod() {
      $this->assertEquals(
        'collections.Lookup··String¸TestCase', 
        $this->fixture->getClassName()
      );
    }

    /**
     * Test getClass()
     *
     */
    #[@test]
    public function nameOfClass() {
      $class= $this->fixture->getClass();
      $this->assertEquals(
        'collections.Lookup··String¸TestCase', 
        $class->getName()
      );
    }

    /**
     * Test getClass()
     *
     */
    #[@test]
    public function simpleNameOfClass() {
      $class= $this->fixture->getClass();
      $this->assertEquals(
        'Lookup··String¸TestCase', 
        $class->getSimpleName()
      );
    }

    /**
     * Test isGeneric()
     *
     */
    #[@test]
    public function instanceIsGeneric() {
      $this->assertTrue($this->fixture->getClass()->isGeneric());
    }

    /**
     * Test isGenericDefinition()
     *
     */
    #[@test]
    public function instanceIsNoGenericDefinition() {
      $this->assertFalse($this->fixture->getClass()->isGenericDefinition());
    }

    /**
     * Test isGenericDefinition()
     *
     */
    #[@test]
    public function genericArguments() {
      $this->assertEquals(
        array(XPClass::forName('lang.types.String'), XPClass::forName('unittest.TestCase')),
        $this->fixture->getClass()->genericArguments()
      );
    }
  }
?>
