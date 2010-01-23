<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'inject.IoC',
    'inject.AbstractModule',
    'rdbms.DBConnection',
    'rdbms.mysql.MySQLConnection',
    'rdbms.sybase.SybaseConnection'
  );
  
  /**
   * Testcase for DI container
   *
   */
  class ConnectionTest extends TestCase {
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
          $this->bind(XPClass::forName("rdbms.DBConnection"))->named("news")->toInstance(
            new MySQLConnection(new DSN("mysql://localhost"))
          );
          $this->bind(XPClass::forName("rdbms.DBConnection"))->named("customers")->toInstance(
            new SybaseConnection(new DSN("sybase://localhost"))
          );
        }
      }'));
    }
    
    /**
     * Tests named injection
     *
     */
    #[@test]
    public function namedConnectionInjection() {
      ClassLoader::defineClass($this->fixtureClass, 'lang.Object', array(), '{
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
      
      $instance= $this->injector->getInstance($this->fixtureClass);
      $this->assertInstanceOf($this->fixtureClass, $instance);
      $this->assertInstanceOf('rdbms.mysql.MySQLConnection', $instance->news);
      $this->assertInstanceOf('rdbms.sybase.SybaseConnection', $instance->customers);
    }
  }
?>
