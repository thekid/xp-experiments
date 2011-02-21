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
   * A proxy derivitive which implements additional mock behaviour definition
   * and validation.
   *
   * @see      xp://unittest.mock.MockProxy
   * @purpose  Unit Test
   */
  class MockProxyTest extends TestCase {

    private $sut=null;
    /**
     * Creates the fixture;
     *
     */
    public function setUp() {
      $this->sut=new MockProxy();
    }

    /**
     * Can create.
     */
    #[@test]
    public function canCreate() {
      new MockProxy();
    }
    /**
     * Can call setReturnValue
     */
    #[@test]
    public function canSetReturnValue() {
      $this->sut->setReturnValue('foo', 'bar');
    }
    /**
     * Can call setReturnValue twice
     */
    #[@test]
    public function canSetReturnValueTwice() {
      $this->sut->setReturnValue('foo', 'bar');
      $this->sut->setReturnValue('foo', 'bar');
    }

    /**
     * Invoke returns null by default
     */
    #[@test]
    public function invokeReturnsNullByDefault() {
      $this->assertNull($this->sut->invoke('blub', 'foo', null));
    }

    /**
     * First parameter is ignored when calling invoke
     */
    #[@test]
    public function invokesFirstParameterMayBeNull() {
      $this->assertNull($this->sut->invoke(null, 'foo', null));
    }
    /**
     * The specified return value is actually stored and returned
     */
    #[@test]
    public function specifiedReturnValueIsActuallyReturned() {
      $return= 'asdfjklö';
      $this->sut->setReturnValue('foo', $return);
      $this->assertEquals( $return, $this->sut->invoke(null, 'foo', null));
    }
    
    /**
     * Return value can be redefined.
     */
    #[@test]
    public function canOverwriteReturnValue() {
      $return= 'asdfjklö';
      $this->sut->setReturnValue('foo', $return);
      $this->assertEquals( $return, $this->sut->invoke(null, 'foo', null));

      $otherReturn= 42;
      $this->sut->setReturnValue('foo', $otherReturn);
      $this->assertNotEquals($return, $this->sut->invoke(null, 'foo', null));
      $this->assertEquals( $otherReturn, $this->sut->invoke(null, 'foo', null));
    }
  }
?>
