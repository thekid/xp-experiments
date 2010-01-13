<?php
  uses(
    'unittest.TestCase',
    'ioc.IoC',
    'ioc.AbstractModule'
  );
  
  class IocTest extends TestCase {
    
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
      
      $module= ClassLoader::defineClass('IocSimpleModule', 'ioc.AbstractModule', array(), '{
        public function configure() {
          $this->bind(XPClass::forName("Injectee"))->to(XPClass::forName("InjecteeImpl"));
        }
      }');
      
      $instance= IoC::getInjectorFor($module->newInstance())->get("IocSimpleClass");
      $this->assertClass($instance, 'IocSimpleClass');
      $this->assertClass($instance->getInjectee(), 'InjecteeImpl');
    }
  }
?>