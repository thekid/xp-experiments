<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'inject.IoC',
    'inject.AbstractModule',
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
      $this->fixtureClass= __CLASS__.'··'.$this->name;
      $this->injector= IoC::getInjectorFor(newinstance('inject.AbstractModule', array(), '{
        protected function configure() {
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
      ClassLoader::defineClass($this->fixtureClass, 'lang.Object', array(), '{
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
     * Tests constructor injection
     *
     */
    #[@test]
    public function constructorInjectionWithMultipleParameters() {
      ClassLoader::defineClass($this->fixtureClass, 'lang.Object', array(), '{
        public $injectees = array(NULL, NULL);
        
        #[@inject]
        public function __construct(Injectee $i1, Injectee $i2) {
          $this->injectees= array($i1, $i2);
        }
      }');
      
      $instance= $this->injector->getInstance($this->fixtureClass);
      $this->assertInstanceOf($this->fixtureClass, $instance);
      $this->assertInstanceOf('InjecteeImpl', $instance->injectees[0]);
      $this->assertInstanceOf('InjecteeImpl', $instance->injectees[1]);
    }

    /**
     * Tests method injection
     *
     */
    #[@test]
    public function methodInjection() {
      ClassLoader::defineClass($this->fixtureClass, 'lang.Object', array(), '{
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
      ClassLoader::defineClass($this->fixtureClass, 'lang.Object', array(), '{
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

    /**
     * Tests named instance
     *
     */
    #[@test, @expect('util.NoSuchElementException')]
    public function nonExistantNamedInstance() {
      $this->injector->getInstance('Injectee', 'hello');
    }
  }
?>
