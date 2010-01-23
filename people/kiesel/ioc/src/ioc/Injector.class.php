<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'ioc';
  
  /**
   * IOC injector
   *
   */
  class ioc·Injector extends Object {
    protected
      $module = NULL;
      
    /**
     * Creates a new injector for a given module
     *
     * @param   ioc.Module module
     */
    public function __construct(ioc·Module $module) {
      $this->module= $module;
    }
    
    /**
     * Returns arguments to pass to a certain routine
     *
     * @param   lang.reflect.Routine r
     * @return  var[] args
     */
    protected function argsFor(Routine $r) {
      $args= array();
      foreach ($r->getParameters() as $param) {
        $type= $param->getTypeRestriction();
        $args[]= $this->getInstance($type->getName());
      }
      return $args;
    }
    
    /**
     * Gets an instance
     *
     * @param   string fqcn
     * @return  lang.Generic instance
     */
    public function getInstance($fqcn) {
      $class= $this->module->resolve(XPClass::forName($fqcn));
      $instance= NULL;
      
      if ($class->hasConstructor() && $class->getConstructor()->numParameters() > 0) {
        $constructor= $class->getConstructor();
        $instance= $constructor->newInstance($this->argsFor($constructor));
      } else {
        $instance= $class->newInstance();
      }
      
      foreach ($class->getMethods() as $method) {
        if (!$method->hasAnnotation('inject')) continue;
        $method->invoke($instance, $this->argsFor($method));
      }
      
      return $instance;
    }
  }
?>
