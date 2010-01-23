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
    'rdbms.DriverManager'
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
      $this->fixtureClass= 'Ioc'.$this->name;
      $this->injector= IoC::getInjectorFor(newinstance('inject.AbstractModule', array(), '{
        protected function configure() {
          $this->bind(XPClass::forName("rdbms.DBConnection"))->toInstance(
            DriverManager::getConnection("mysql://localhost")
          );
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
        public $conn = NULL;
        
        #[@inject]
        public function __construct(DBConnection $conn) {
          $this->conn= $conn;
        }
      }');
      
      $instance= $this->injector->getInstance($this->fixtureClass);
      $this->assertInstanceOf($this->fixtureClass, $instance);
      $this->assertInstanceOf('rdbms.mysql.MySQLConnection', $instance->conn);
    }
  }
?>
