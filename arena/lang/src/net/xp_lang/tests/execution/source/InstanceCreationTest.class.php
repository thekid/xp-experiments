<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'net.xp_lang.tests.execution.source';

  uses('net.xp_lang.tests.execution.source.ExecutionTest');

  /**
   * Tests class instance creation
   *
   */
  class net·xp_lang·tests·execution·source·InstanceCreationTest extends ExecutionTest {

    /**
     * Assert a given instance is an anonymous instance
     *
     * @param   string name
     * @param   lang.Generic instance
     * @throws  unittest.AssertionFailedError
     */
    protected function assertAnonymousInstanceOf($name, Generic $instance) {
      $this->assertSubclass($instance, $name);
      $this->assertTrue((bool)strstr($instance->getClassName(), '··'), $instance->getClassName());
    }
    
    /**
     * Test creating a new object
     *
     */
    #[@test]
    public function newObject() {
      $this->assertClass($this->run('return new Object();'), 'lang.Object');
    }

    /**
     * Test creating a new generic hashtable
     *
     */
    #[@test]
    public function newGenericHashTable() {
      $hash= $this->run('return new util.collections.HashTable<lang.types.String, lang.Generic>();');
      $this->assertEquals(
        array(XPClass::forName('lang.types.String'), XPClass::forName('lang.Generic')), 
        $hash->getClass()->genericArguments()
      );
    }

    /**
     * Test creating a new generic hashtable
     *
     */
    #[@test]
    public function newGenericVector() {
      $hash= $this->run('return new util.collections.Vector<int>();');
      $this->assertEquals(
        array(Primitive::$INT), 
        $hash->getClass()->genericArguments()
      );
    }

    /**
     * Test creating a new object
     *
     */
    #[@test]
    public function newObjectFullyQualified() {
      $this->assertClass($this->run('return new lang.Object();'), 'lang.Object');
    }
    
    /**
     * Test creating a new anonymous instance from an interface
     *
     */
    #[@test]
    public function anonymousInterfaceInstance() {
      $runnable= $this->run('return new lang.Runnable() {
        public void run() {
          throw new lang.MethodNotImplementedException("run");
        }
      };');
      $this->assertAnonymousInstanceOf('lang.Runnable', $runnable);
    }

    /**
     * Test creating a new anonymous instance from lang.Object
     *
     */
    #[@test]
    public function anonymousInstance() {
      $object= $this->run('return new lang.Object() {
        public void run() {
          throw new lang.MethodNotImplementedException("run");
        }
      };');
      $this->assertAnonymousInstanceOf('lang.Object', $object);
    }

    /**
     * Test creating a new anonymous instance from an abstract class
     *
     */
    #[@test]
    public function anonymousInstanceFromAbstractBase() {
      $command= $this->run('return new util.cmd.Command() {
        public void run() {
          throw new lang.MethodNotImplementedException("run");
        }
      };');
      $this->assertAnonymousInstanceOf('util.cmd.Command', $command);
    }
  }
?>
