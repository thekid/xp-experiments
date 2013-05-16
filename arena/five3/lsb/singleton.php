<?php
  abstract class Singleton {
    private static $instances= array();
    
    private final function __construct() { }
    private final function __clone() { }
    
    public static function getInstance() {
      $id= get_called_class();
      if (!isset(self::$instances[$id])) {
        self::$instances[$id]= new static();
      }
      return self::$instances[$id];
    }
  }
  
  class Logger extends Singleton {
    public function log($arg) {
      var_dump($arg);
    }
  }

  class DriverManager extends Singleton {
    protected $drivers= array(
      'mysql' => 'rdbms.mysql.MySQLConnection'
    );
  
    public static function getConnection($dsn) {
      $u= parse_url($dsn);
      return self::getInstance()->drivers[$u['scheme']];
    }
  }
  
  Logger::getInstance()->log('Hello');
  var_dump(DriverManager::getConnection('mysql://root@localhost'));

  // Fatal error: Call to private Singleton::__construct 
  // new Logger();
  
  // Fatal error: Call to private Singleton::__clone 
  // clone Logger::getInstance();
?>
