<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'ioc.IoC',
    'ioc.AbstractModule',
    'Injectee'
  );
  
  /**
   * Testcase for DI container
   *
   */
  class IocTest extends TestCase {
    protected $fixtureClass= NULL;
  
    /**
     * Populates fixtureClass member with a unique name
     *
     */
    public function setUp() {
      $this->fixtureClass= 'Ioc'.$this->name;
    }
    
    /**
     * Tests constructor injection
     *
     */
    #[@test]
    public function constructorInjection() {
      $class= ClassLoader::defineClass($this->fixtureClass, 'lang.Object', array(), '{
        protected $injectee = NULL;
        
        #[@inject]
        public function __construct(Injectee $i) {
          $this->injectee= $i;
        }
        
        public function getInjectee() { return $this->injectee; }
      }');
      
      $injector= IoC::getInjectorFor(newinstance('ioc.AbstractModule', array(), '{
        public function configure() {
          $this->bind(XPClass::forName("Injectee"))->to(XPClass::forName("InjecteeImpl"));
        }
      }'));
      
      $instance= $injector->get($this->fixtureClass);
      $this->assertInstanceOf($this->fixtureClass, $instance);
      $this->assertInstanceOf('InjecteeImpl', $instance->getInjectee());
    }

    /**
     * Tests method injection
     *
     */
    #[@test]
    public function methodInjection() {
      $class= ClassLoader::defineClass($this->fixtureClass, 'lang.Object', array(), '{
        protected $injectee = NULL;
        
        #[@inject]
        public function setInjectee(Injectee $i) {
          $this->injectee= $i;
        }
        
        public function getInjectee() { return $this->injectee; }
      }');
      
      $injector= IoC::getInjectorFor(newinstance('ioc.AbstractModule', array(), '{
        public function configure() {
          $this->bind(XPClass::forName("Injectee"))->to(XPClass::forName("InjecteeImpl"));
        }
      }'));
      
      $instance= $injector->get($this->fixtureClass);
      $this->assertInstanceOf($this->fixtureClass, $instance);
      $this->assertInstanceOf('InjecteeImpl', $instance->getInjectee());
    }
  }
?>
