<?php
  namespace de\thekid\log4x;

  abstract class Appender {
    
    protected abstract function log($prefix, $args);
    
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
