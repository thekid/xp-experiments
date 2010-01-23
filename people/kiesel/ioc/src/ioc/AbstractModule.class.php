<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('ioc.Module', 'ioc.Binding');
  
  /**
   * Abstract base class for modules
   *
   */
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
    protected abstract function configure();
    
    /**
     * Binds a class
     *
     * @param   lang.XPClass class
     * @return  ioc.Binding
     */
    public function bind(XPClass $class) {
      return $this->bindings[$class->getName()]= new ioc·Binding();
    }
  
    /**
     * Resolves a class
     *
     * @param   lang.XPClass class
     * @return  lang.XPClass
     */
    public function resolve(XPClass $class) {
      $n= $class->getName();
      return isset($this->bindings[$n]) ? $this->bindings[$n]->impl : $class;
    }
  }
?>
