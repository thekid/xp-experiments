<?php
  namespace de\thekid\log4x;

  class Logger {
    protected static $instance;
    
    public function getInstance() {
      if (!self::$instance) self::$instance= new self();
      return self::$instance;
    }
    
    protected function dump($arg) {
      if (is_array($arg)) {
        echo '['; 
        foreach ($arg as $k => $v) {
          $this->dump($k); echo ' => '; $this->dump($v);
        }
        echo ']';
      } else if (NULL === $arg) {
        echo 'null';
      } else {
        echo $arg;
      }
    }
    
    protected function log($prefix, $args) {
      echo '['.date('Y-m-d H:i:s').' '.$prefix.'] '; 
      foreach ($args as $arg) {
        $this->dump($arg);
        echo ' ';
      }
      echo "\n";
    }
    
    public function info() {
      $this->log('info ', func_get_args());
    }

    public function warn() {
      $this->log('warn ', func_get_args());
    }

    public function error() {
      $this->log('error', func_get_args());
    }
  }
?>
