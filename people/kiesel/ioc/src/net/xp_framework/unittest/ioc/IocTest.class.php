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
    protected $injector= NULL;
  
    /**
     * Populates fixtureClass member with a unique name
     *
     */
    public function setUp() {
      $this->fixtureClass= 'Ioc'.$this->name;
      $this->injector= IoC::getInjectorFor(newinstance('ioc.AbstractModule', array(), '{
        public function configure() {
          $this->bind(XPClass::forName("Injectee"))->to(XPClass::forName("InjecteeImpl"));
        }
      }'));
    }
    
    /**
     * Tests constructor injection
     *
     */
    #[@test]
    public function constructorInjection() {
      $class= ClassLoader::defineClass($this->fixtureClass, 'lang.Object', array(), '{
        public $injectee = NULL;
        
        #[@inject]
        public function __construct(Injectee $i) {
          $this->injectee= $i;
        }
      }');
      
      $instance= $this->injector->getInstance($this->fixtureClass);
      $this->assertInstanceOf($this->fixtureClass, $instance);
      $this->assertInstanceOf('InjecteeImpl', $instance->injectee);
    }

    /**
     * Tests method injection
     *
     */
    #[@test]
    public function methodInjection() {
      $class= ClassLoader::defineClass($this->fixtureClass, 'lang.Object', array(), '{
        public $injectee = NULL;
        
        #[@inject]
        public function setInjectee(Injectee $i) {
          $this->injectee= $i;
        }
      }');
      
      $instance= $this->injector->getInstance($this->fixtureClass);
      $this->assertInstanceOf($this->fixtureClass, $instance);
      $this->assertInstanceOf('InjecteeImpl', $instance->injectee);
    }

    /**
     * Tests method injection
     *
     */
    #[@test]
    public function methodInjectionWithMultipleParameters() {
      $class= ClassLoader::defineClass($this->fixtureClass, 'lang.Object', array(), '{
        public $injectees = array(NULL, NULL);
        
        #[@inject]
        public function setInjectee(Injectee $i1, Injectee $i2) {
          $this->injectees= array($i1, $i2);
        }
      }');
      
      $instance= $this->injector->getInstance($this->fixtureClass);
      $this->assertInstanceOf($this->fixtureClass, $instance);
      $this->assertInstanceOf('InjecteeImpl', $instance->injectees[0]);
      $this->assertInstanceOf('InjecteeImpl', $instance->injectees[1]);
    }
  }
?>
