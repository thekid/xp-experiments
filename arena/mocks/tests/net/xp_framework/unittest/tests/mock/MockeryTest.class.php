<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
 
  uses('unittest.mock.Mockery',
       'lang.Type',
       'lang.reflect.Proxy',
       'net.xp_framework.unittest.tests.mock.IEmptyInterface',
       'net.xp_framework.unittest.tests.mock.IComplexInterface'
  );

  /**
   * Class for automaticly stubbing interfaces
   *
   * @see      xp://unittest.mock.Mockery
   * @purpose  Unit Test
   */
  class MockeryTest extends TestCase {

    private $sut=null;
    /**
     * Creates the fixture;
     *
     */
    public function setUp() {
      $this->sut=new Mockery();
    }
      
    /**
     * Can create.
     */
    #[@test]
    public function canCreate() {
      new Mockery();
    }
    /**
     * Can create mock for empty interface
     */
    #[@test]
    public function canCreateMockForEmptyInterface() {
      $object= $this->sut->createMock('net.xp_framework.unittest.tests.mock.IEmptyInterface');
      $this->assertInstanceOf('net.xp_framework.unittest.tests.mock.IEmptyInterface', $object);
    }

     /**
     * Can create mock for non-empty interface
     */
    #[@test]
    public function canCreateMockForComplexInterface() {
      $object= $this->sut->createMock('net.xp_framework.unittest.tests.mock.IComplexInterface');
      $this->assertInstanceOf('net.xp_framework.unittest.tests.mock.IComplexInterface', $object);
    }

    /**
     * Can create mock for non-empty interface
     */
    #[@test, @expect('lang.ClassNotFoundException')]
    public function cannotCreateMockForUnknownTypes() {
      $this->sut->createMock('foooooo.Unknown');
    }

    /**
     * Can create mock for non-empty interface
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function cannotCreateMockForNonXPClassTypes() {
      $this->sut->createMock('string');
    }

    /**
     * Can call replay
     */
    #[@test]
    public function canCallReplay() {
      $object= $this->sut->createMock('net.xp_framework.unittest.tests.mock.IComplexInterface');
      $object->replay();
    }

    /**
     * Can call interface methods
     */
    #[@test]
    public function canCallInterfaceMethods() {
      $object= $this->sut->createMock('net.xp_framework.unittest.tests.mock.IComplexInterface');
      $object->foo();
    }

    /**
     * Can call returns() on mocked object
     */
    #[@test]
    public function canCallReturnsFluently() {
      $object= $this->sut->createMock('net.xp_framework.unittest.tests.mock.IComplexInterface');
      $object->foo()->returns(null);
    }

    /**
     * Defined value returned in replay mode
     */
    #[@test]
    public function canDefineReturnValue() {
      $object= $this->sut->createMock('net.xp_framework.unittest.tests.mock.IComplexInterface');

      $return = new Object();
      $object->foo()->returns($return);

      $object->replay();
      $this->assertTrue($object->foo()=== $return);
    }

    /**
     * If no expectations are left, null is returned
     */
    #[@test]
    public function missingExpectationLeadsToNull() {
      $object= $this->sut->createMock('net.xp_framework.unittest.tests.mock.IComplexInterface');

      $object->foo()->returns(new Object());

      $object->replay();
      $this->assertInstanceOf('lang.Object', $object->foo());
      $this->assertNull($object->foo());
      $this->assertNull($object->foo());
      $this->assertNull($object->foo());
    }
    
    /**
     * If no expectations are left, null is returned
     */
    #[@test]
    public function recordedReturnsAreInCorrectOrder() {
      $object= $this->sut->createMock('net.xp_framework.unittest.tests.mock.IComplexInterface');

      $return1="foo";
      $return2="bar";
      $return3="baz";
      
      $object->foo()->returns($return1);
      $object->foo()->returns($return2);
      $object->foo()->returns($return3);
      $object->replay();
      
      $this->assertEquals($return1, $object->foo());
      $this->assertEquals($return2, $object->foo());
      $this->assertEquals($return3, $object->foo());
      $this->assertNull($object->foo());

    }
  }
?>
