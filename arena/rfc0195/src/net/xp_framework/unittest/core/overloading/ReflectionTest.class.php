<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
 
  $package= 'net.xp_framework.unittest.core.overloading';

  uses(
    'unittest.TestCase',
    'net.xp_framework.unittest.core.overloading.TypeDispatchFixture',
    'util.Date'
  );

  /**
   * TestCase
   *
   * @see      xp://net.xp_framework.unittest.core.overloading.TypeDispatchFixture
   */
  class net·xp_framework·unittest·core·overloading·ReflectionTest extends TestCase {
    protected $fixture= NULL;
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->fixture= XPClass::forName('net.xp_framework.unittest.core.overloading.TypeDispatchFixture');
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function withoutSignature() {
      $this->assertEquals(
        'serialize', 
        $this->fixture->getMethod('serialize')->getName()
      );
    }
    
    /**
     * Assertion helper
     *
     * @param   lang.Type[]
     * @param   lang.reflect.Routine
     * @throws  unittest.AssertionFailedError
     */
    protected function assertSignatureEquals($types, Routine $method) {
      foreach ($types as $i => $type) {
        $this->assertEquals($type, $method->getParameter($i)->getType(), 'parameter #'.$i);
      }
    }
 
    /**
     * Test
     *
     */
    #[@test]
    public function withStringSignature() {
      $this->assertSignatureEquals(
        array(Primitive::$STRING, Primitive::$STRING), 
        $this->fixture->getMethod('serialize', array(Primitive::$STRING))
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function withStringStringSignature() {
      $this->assertSignatureEquals(
        array(Primitive::$STRING, Primitive::$STRING), 
        $this->fixture->getMethod('serialize', array(Primitive::$STRING, Primitive::$STRING))
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function withIntSignature() {
      $this->assertSignatureEquals(
        array(Primitive::$INTEGER), 
        $this->fixture->getMethod('serialize', array(Primitive::$INTEGER))
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function withObjectSignature() {
      $this->assertSignatureEquals(
        array(XPClass::forName('lang.Generic')), 
        $this->fixture->getMethod('serialize', array(XPClass::forName('lang.Generic')))
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function withDateSignature() {
      $this->assertSignatureEquals(
        array(XPClass::forName('util.Date')), 
        $this->fixture->getMethod('serialize', array(XPClass::forName('util.Date')))
      );
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.ElementNotFoundException')]
    public function nonExistantOverload() {
      $this->fixture->getMethod('serialize', array(Primitive::$DOUBLE));
    }
  }
?>
