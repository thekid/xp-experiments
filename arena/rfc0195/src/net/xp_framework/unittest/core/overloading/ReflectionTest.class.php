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
     * Test
     *
     */
    #[@test]
    public function withStringSignature() {
      $this->assertEquals(
        'serialize··þstring¸þstring', 
        $this->fixture->getMethod('serialize', array(Primitive::$STRING))->getName()
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function withStringStringSignature() {
      $this->assertEquals(
        'serialize··þstring¸þstring', 
        $this->fixture->getMethod('serialize', array(Primitive::$STRING, Primitive::$STRING))->getName()
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function withIntSignature() {
      $this->assertEquals(
        'serialize··þint', 
        $this->fixture->getMethod('serialize', array(Primitive::$INTEGER))->getName()
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function withObjectSignature() {
      $this->assertEquals(
        'serialize··Generic', 
        $this->fixture->getMethod('serialize', array(XPClass::forName('lang.Generic')))->getName()
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function withDateSignature() {
      $this->assertEquals(
        'serialize··Date', 
        $this->fixture->getMethod('serialize', array(XPClass::forName('util.Date')))->getName()
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
