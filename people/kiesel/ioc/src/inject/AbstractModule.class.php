<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('inject.Module', 'inject.Binding');
  
  /**
   * Abstract base class for modules
   *
   */
  abstract class AbstractModule extends Object implements inject·Module {
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
     * @return  inject.Binding
     */
    public function bind(XPClass $class) {
      return $this->bindings[$class->getName()]= new inject·Binding();
    }
  
    /**
     * Resolves a class
     *
     * @param   lang.XPClass class
     * @return  inject.Binding
     */
    public function resolve(XPClass $class) {
      $n= $class->getName();
      return isset($this->bindings[$n]) ? $this->bindings[$n] : create(new inject·Binding())->to($class);
    }
  }
?>
