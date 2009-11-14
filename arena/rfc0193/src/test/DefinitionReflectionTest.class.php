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
   * TestCase for definition reflection
   *
   * @see   xp://collections.Lookup
   */
  class DefinitionReflectionTest extends TestCase {
    protected $fixture= NULL;
    
    /**
     * Creates fixture, a Lookup class
     *
     */  
    public function setUp() {
      $this->fixture= XPClass::forName('collections.Lookup');
    }
  
    /**
     * Test isGenericDefinition()
     *
     */
    #[@test]
    public function isAGenericDefinition() {
      $this->assertTrue($this->fixture->isGenericDefinition());
    }

    /**
     * Test isGenericDefinition()
     *
     */
    #[@test]
    public function isNotAGeneric() {
      $this->assertFalse($this->fixture->isGeneric());
    }

    /**
     * Test newGenericType()
     *
     */
    #[@test]
    public function newGenericTypeIsGeneric() {
      $t= $this->fixture->newGenericType(array(
        XPClass::forName('lang.types.String'), 
        XPClass::forName('unittest.TestCase')
      ));
      $this->assertTrue($t->isGeneric());
    }

    /**
     * Test newGenericType()
     *
     */
    #[@test]
    public function newLookupWithStringAndTestCase() {
      $arguments= array(
        XPClass::forName('lang.types.String'), 
        XPClass::forName('unittest.TestCase')
      );
      $t= $this->fixture->newGenericType($arguments);
      $this->assertEquals($arguments, $t->genericArguments());
    }

    /**
     * Test newGenericType()
     *
     */
    #[@test]
    public function newLookupWithStringAndObject() {
      $arguments= array(
        XPClass::forName('lang.types.String'), 
        XPClass::forName('lang.Object')
      );
      $t= $this->fixture->newGenericType($arguments);
      $this->assertEquals($arguments, $t->genericArguments());
    }

    /**
     * Test classes created via newGenericType() and from an instance
     * instantiated via create() are equal.
     *
     */
    #[@test]
    public function classesFromReflectionAndCreateAreEqual() {
      $this->assertEquals(
        create('new Lookup<String, TestCase>()')->getClass(),
        $this->fixture->newGenericType(array(
          XPClass::forName('lang.types.String'), 
          XPClass::forName('unittest.TestCase')
        ))
      );
    }

    /**
     * Test newGenericType()
     *
     */
    #[@test]
    public function classesCreatedWithDifferentTypesAreNotEqual() {
      $this->assertNotEquals(
        $this->fixture->newGenericType(array(
          XPClass::forName('lang.types.String'), 
          XPClass::forName('lang.Object')
        )),
        $this->fixture->newGenericType(array(
          XPClass::forName('lang.types.String'), 
          XPClass::forName('unittest.TestCase')
        ))
      );
    }
  }
?>
