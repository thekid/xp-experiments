<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
 
  uses('unittest.mock.MockBuilder',
       'lang.Type',
       'lang.reflect.Proxy',
       'net.xp_framework.unittest.tests.mock.IEmptyInterface',
       'net.xp_framework.unittest.tests.mock.IComplexInterface'
  );

  /**
   * Class for automaticly stubbing interfaces
   *
   * @see      xp://unittest.MockBuilder
   * @purpose  Unit Test
   */
  class MockBuilderTest extends TestCase {

    private $sut=null;
    /**
     * Creates the fixture;
     *
     */
    public function setUp() {
      $this->sut=new MockBuilder();
    }
      
    /**
     * Can create.
     */
    #[@test]
    public function canCreate() {
      new MockBuilder();
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
     * Can create mock for non-empty interface
     */
    #[@test]
    public function mockedReturnValueIsNullByDefault() {
      $object= $this->sut->buildMock('net.xp_framework.unittest.tests.mock.IComplexInterface');
      $this->assertTrue($object->foo()=== NULL);
    }

    /**
     * Can create mock for non-empty interface
     */
    #[@test]
    public function canDefineReturnValue() {
      $object= $this->sut->buildMock('net.xp_framework.unittest.tests.mock.IComplexInterface');

      $return = new Object();
      $object->setReturnValue('foo', $return);

      $this->assertTrue($object->foo()=== $return);
    }
  }
?>
