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
    
    /**
     * Tests constructor injection
     *
     */
    #[@test]
    public function injectConstructor() {
      $class= ClassLoader::defineClass('IocSimpleClass', 'lang.Object', array(), '{
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
      
      $instance= $injector->get('IocSimpleClass');
      $this->assertInstanceOf('IocSimpleClass', $instance);
      $this->assertInstanceOf('InjecteeImpl', $instance->getInjectee());
    }
  }
?>
