<?php

















uses('unittest.TestCase'); class ConnectionTest extends TestCase{
protected $fixtureClass;
protected $injector;





public function setUp(){
$this->fixtureClass=(__CLASS__) . (('··') . ($this->name));









$this->injector=IoC::getInjectorFor(new AbstractModule··4b5c3f12d2268());
}






public function namedConnectionInjection(){
ClassLoader::defineClass($this->fixtureClass,'lang.Object',array(),'{
      public $news = NULL;
      public $customers = NULL;

      #[@inject(name= "news")]
      public function setNewsConnection(DBConnection $conn) {
        $this->news= $conn;
      }

      #[@inject(name= "customers")]
      public function setCustomersConnection(DBConnection $conn) {
        $this->customers= $conn;
      }
    }');

$instance=$this->injector->getInstance($this->fixtureClass);
$this->assertInstanceOf($this->fixtureClass,$instance);
$this->assertInstanceOf('rdbms.mysql.MySQLConnection',$instance->news);
$this->assertInstanceOf('rdbms.sybase.SybaseConnection',$instance->customers);
}}xp::$registry['class.ConnectionTest']= 'net.xp_framework.unittest.ioc.ConnectionTest';xp::$registry['details.net.xp_framework.unittest.ioc.ConnectionTest']= array (
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
    'namedConnectionInjection' => 
    array (
      1 => 
      array (
      ),
      2 => 'void',
      3 => 
      array (
      ),
      4 => '
  
  Tests named injection
  
  ',
      5 => 
      array (
        'test' => NULL,
      ),
    ),
  ),
  'class' => 
  array (
    4 => '

Tests named injections

',
  ),
);uses('inject.AbstractModule'); class AbstractModule··4b5c3f12d2268 extends AbstractModule{
protected function configure(){
$this->bind(XPClass::forName('rdbms.DBConnection'))->named('news')->toInstance(new MySQLConnection(new DSN('mysql://localhost')));$this->bind(XPClass::forName('rdbms.DBConnection'))->named('customers')->toInstance(new SybaseConnection(new DSN('sybase://localhost')));
}}xp::$registry['class.AbstractModule··4b5c3f12d2268']= 'net.xp_framework.unittest.ioc.AbstractModule··4b5c3f12d2268';xp::$registry['details.net.xp_framework.unittest.ioc.AbstractModule··4b5c3f12d2268']= array (
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
);uses('unittest.TestCase','inject.Injector','inject.AbstractModule','rdbms.DBConnection','rdbms.mysql.MySQLConnection','rdbms.sybase.SybaseConnection','inject.IoC','lang.ClassLoader','lang.Generic','inject.Binding','rdbms.DSN');
?>
