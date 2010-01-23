<?php
  uses('ioc.Module', 'ioc.Binding');
  
  abstract class AbstractModule extends Object implements ioc·Module {
    protected $bindings= array();
  
    /**
     * Constructor. Calls configure() method
     *
     */
    public function __construct() {
      $this->configure();
    }
    
    /**
     * Configure method. This is where you register bindings
     *
     */
    public abstract function configure();
    
    public function bind(XPClass $class) {
      return $this->bindings[$class->getName()]= new ioc·Binding();
    }
  
    public function resolve(XPClass $class) {
      $n= $class->getName();
      return isset($this->bindings[$n]) ? $this->bindings[$n]->impl : $class;
    }
  }
?>
