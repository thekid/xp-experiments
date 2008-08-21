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
  
  Logger::getInstance()->log('Hello');

  // Fatal error: Call to private Singleton::__construct 
  // new Logger();
  
  // Fatal error: Call to private Singleton::__clone 
  // clone Logger::getInstance();
?>
