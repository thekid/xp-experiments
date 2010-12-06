<?php
  namespace remote;
  
  class Remote {
    protected $dsn= '';
  
    protected function __construct($dsn) {
      $this->dsn= $dsn;
    }
  
    public static function forName($dsn) {
      return new self($dsn);
    }
  }
?>
