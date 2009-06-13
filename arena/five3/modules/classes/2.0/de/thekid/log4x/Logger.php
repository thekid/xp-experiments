<?php
  namespace de\thekid\log4x;

  class Logger {
    protected static $instance;
    protected $appender;
    
    public function getInstance() {
      if (!self::$instance) self::$instance= new self();
      return self::$instance;
    }
    
    public function setAppender(Appender $appender) {
      $this->appender= $appender;
    }
  }
?>
