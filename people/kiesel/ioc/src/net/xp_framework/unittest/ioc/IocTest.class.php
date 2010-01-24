<?php














uses('unittest.TestCase'); class IocTest extends TestCase{
protected $fixtureClass;
protected $injector;





public function setUp(){
$this->fixtureClass=(__CLASS__) . (('··') . ($this->name));




$this->injector=IoC::getInjectorFor(new AbstractModule··4b5c3f12e5001());
}






public function constructorInjection(){
ClassLoader::defineClass($this->fixtureClass,'lang.Object',array(),'{
      public $injectee = NULL;

      #[@inject]
      public function __construct(Injectee $i) {
        $this->injectee= $i;
      }
    }');

$instance=$this->injector->getInstance($this->fixtureClass);
$this->assertInstanceOf($this->fixtureClass,$instance);
$this->assertInstanceOf('net.xp_framework.unittest.ioc.InjecteeImpl',$instance->injectee);
}






public function constructorInjectionWithMultipleParameters(){
ClassLoader::defineClass($this->fixtureClass,'lang.Object',array(),'{
      public $injectees = array(NULL, NULL);

      #[@inject]
      public function __construct(Injectee $i1, Injectee $i2) {
        $this->injectees= array($i1, $i2);
      }
    }');

$instance=$this->injector->getInstance($this->fixtureClass);
$this->assertInstanceOf($this->fixtureClass,$instance);
$this->assertInstanceOf('net.xp_framework.unittest.ioc.InjecteeImpl',$instance->injectees[0]);
$this->assertInstanceOf('net.xp_framework.unittest.ioc.InjecteeImpl',$instance->injectees[1]);
}






public function methodInjection(){
ClassLoader::defineClass($this->fixtureClass,'lang.Object',array(),'{
      public $injectee = NULL;

      #[@inject]
      public function setInjectee(Injectee $i) {
        $this->injectee= $i;
      }
    }');

$instance=$this->injector->getInstance($this->fixtureClass);
$this->assertInstanceOf($this->fixtureClass,$instance);
$this->assertInstanceOf('net.xp_framework.unittest.ioc.InjecteeImpl',$instance->injectee);
}






public function methodInjectionWithMultipleParameters(){
ClassLoader::defineClass($this->fixtureClass,'lang.Object',array(),'{
      public $injectees = array(NULL, NULL);

      #[@inject]
      public function setInjectee(Injectee $i1, Injectee $i2) {
        $this->injectees= array($i1, $i2);
      }
    }');

$instance=$this->injector->getInstance($this->fixtureClass);
$this->assertInstanceOf($this->fixtureClass,$instance);
$this->assertInstanceOf('net.xp_framework.unittest.ioc.InjecteeImpl',$instance->injectees[0]);
$this->assertInstanceOf('net.xp_framework.unittest.ioc.InjecteeImpl',$instance->injectees[1]);
}






public function nonExistantNamedInstance(){
$this->injector->getInstance('net.xp_framework.unittest.ioc.Injectee','hello');
}}xp::$registry['class.IocTest']= 'net.xp_framework.unittest.ioc.IocTest';xp::$registry['details.net.xp_framework.unittest.ioc.IocTest']= array (
  0 => 
  array (
    'fixtureClass' => 
    array (
      5 => 
      array (
        'type' => 'string',
      ),
    ),
    'injector' => 
    array (
      5 => 
      array (
        'type' => 'inject.Injector',
      ),
    ),
  ),
  1 => 
  array (
    'setUp' => 
    array (
      1 => 
      array (
      ),
      2 => 'void',
      3 => 
      array (
      ),
      4 => '
  
  Sets up this test case
  
  ',
      5 => 
      array (
      ),
    ),
    'constructorInjection' => 
    array (
      1 => 
      array (
      ),
      2 => 'void',
      3 => 
      array (
      ),
      4 => '
  
  Tests constructor injection
  
  ',
      5 => 
      array (
        'test' => NULL,
      ),
    ),
    'constructorInjectionWithMultipleParameters' => 
    array (
      1 => 
      array (
      ),
      2 => 'void',
      3 => 
      array (
      ),
      4 => '
  
  Tests constructor injection
  
  ',
      5 => 
      array (
        'test' => NULL,
      ),
    ),
    'methodInjection' => 
    array (
      1 => 
      array (
      ),
      2 => 'void',
      3 => 
      array (
      ),
      4 => '
  
  Tests method injection
  
  ',
      5 => 
      array (
        'test' => NULL,
      ),
    ),
    'methodInjectionWithMultipleParameters' => 
    array (
      1 => 
      array (
      ),
      2 => 'void',
      3 => 
      array (
      ),
      4 => '
  
  Tests method injection
  
  ',
      5 => 
      array (
        'test' => NULL,
      ),
    ),
    'nonExistantNamedInstance' => 
    array (
      1 => 
      array (
      ),
      2 => 'void',
      3 => 
      array (
      ),
      4 => '
  
  Tests named instance
  
  ',
      5 => 
      array (
        'test' => NULL,
        'expect' => 'util.NoSuchElementException',
      ),
    ),
  ),
  'class' => 
  array (
    4 => '

Testcase for DI container

',
  ),
);uses('inject.AbstractModule'); class AbstractModule··4b5c3f12e5001 extends AbstractModule{
protected function configure(){
$this->bind(XPClass::forName('net.xp_framework.unittest.ioc.Injectee'))->to(XPClass::forName('net.xp_framework.unittest.ioc.InjecteeImpl'));
}}xp::$registry['class.AbstractModule··4b5c3f12e5001']= 'net.xp_framework.unittest.ioc.AbstractModule··4b5c3f12e5001';xp::$registry['details.net.xp_framework.unittest.ioc.AbstractModule··4b5c3f12e5001']= array (
  0 => 
  array (
  ),
  1 => 
  array (
    'configure' => 
    array (
      1 => 
      array (
      ),
      2 => 'void',
      3 => 
      array (
      ),
      4 => '
 ',
      5 => 
      array (
      ),
    ),
  ),
  'class' => 
  array (
    4 => '
 ',
  ),
);uses('unittest.TestCase','inject.Injector','inject.AbstractModule','inject.IoC','lang.ClassLoader','lang.Generic','net.xp_framework.unittest.ioc.Injectee','inject.Binding','net.xp_framework.unittest.ioc.InjecteeImpl');
?>
