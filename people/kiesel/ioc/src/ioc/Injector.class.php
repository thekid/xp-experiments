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
     * Gets an instance
     *
     * @param   string fqcn
     * @return  lang.Generic instance
     */
    public function get($fqcn) {
      $class= $this->module->resolve(XPClass::forName($fqcn));
      $instance= NULL;
      
      if ($class->hasConstructor() && $class->getConstructor()->numParameters() > 0) {
        $constructor= $class->getConstructor();
        
        $args= array();
        foreach ($constructor->getParameters() as $param) {
          $type= $param->getTypeRestriction();
          $args[]= $this->get($type->getName());
        }
        $instance= $constructor->newInstance($args);
      } else {
        $instance= $class->newInstance();
      }
      
      foreach ($class->getMethods() as $method) {
        if (!$method->hasAnnotation('inject')) continue;
        
        $args= array();
        foreach ($method->getParameters() as $param) {
          $type= $param->getTypeRestriction();
          $args[]= $this->get($type->getName());
        }
        $method->invoke($instance, $args);
      }
      
      return $instance;
    }
  }
?>
