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
    public function canbuildMockForEmptyInterface() {
      $object= $this->sut->buildMock('net.xp_framework.unittest.tests.mock.IEmptyInterface');
      $this->assertInstanceOf('net.xp_framework.unittest.tests.mock.IEmptyInterface', $object);
    }

     /**
     * Can create mock for non-empty interface
     */
    #[@test]
    public function canbuildMockForComplexInterface() {
      $object= $this->sut->buildMock('net.xp_framework.unittest.tests.mock.IComplexInterface');
      $this->assertInstanceOf('net.xp_framework.unittest.tests.mock.IComplexInterface', $object);
    }

    /**
     * Can create mock for non-empty interface
     */
    #[@test, @expect('lang.ClassNotFoundException')]
    public function cannotbuildMockForUnknownTypes() {
      $this->sut->buildMock('foooooo.Unknown');
    }

    /**
     * Can create mock for non-empty interface
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function cannotbuildMockForNonXPClassTypes() {
      $this->sut->buildMock('string');
    }

    /**
     * Can call replay
     */
    #[@test]
    public function canCallReplay() {
      $object= $this->sut->buildMock('net.xp_framework.unittest.tests.mock.IComplexInterface');
      $object->replay();
    }

    /**
     * Can call interface methods
     */
    #[@test]
    public function canCallInterfaceMethods() {
      $object= $this->sut->buildMock('net.xp_framework.unittest.tests.mock.IComplexInterface');
      $object->foo();
    }

    /**
     * Can call returns() on mocked object
     */
    #[@test]
    public function canCallReturnsFluently() {
      $object= $this->sut->buildMock('net.xp_framework.unittest.tests.mock.IComplexInterface');
      $object->foo()->returns(null);
    }

    /**
     * Defined value returned in replay mode
     */
    #[@test, @ignore]
    public function canDefineReturnValue() {
      $object= $this->sut->buildMock('net.xp_framework.unittest.tests.mock.IComplexInterface');

      $return = new Object();
      $object->foo()->returns($return);

      $object->replay();
      $this->assertTrue($object->foo()=== $return);
    }

  }
?>
