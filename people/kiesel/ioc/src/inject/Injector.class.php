<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'inject';
  
  /**
   * IOC injector
   *
   */
  class inject·Injector extends Object {
    protected
      $module = NULL;
      
    /**
     * Creates a new injector for a given module
     *
     * @param   inject.Module module
     */
    public function __construct(inject·Module $module) {
      $this->module= $module;
    }
    
    /**
     * Returns arguments to pass to a certain routine
     *
     * @param   lang.reflect.Routine r
     * @param   string[] names
     * @return  var[] args
     * @throws  lang.IllegalStateException
     */
    protected function argsFor(Routine $r, array $names) {
      $args= array();
      foreach ($r->getParameters() as $i => $param) {
        if (NULL === ($type= $param->getTypeRestriction())) {
          throw new IllegalStateException(sprintf(
            'Cannot determine type for %s:%s()\'s parameter %s',
            $r->getDeclaringClass()->getName(),
            $r->getName(),
            $param->getName()
          ));
        }
        $args[]= $this->getInstance($type->getName(), isset($names[$i]) ? $names[$i] : NULL);
      }
      return $args;
    }
    
    /**
     * Gets an instance
     *
     * @param   string fqcn
     * @param   string name default NULL
     * @return  lang.Generic instance
     */
    public function getInstance($fqcn, $name= NULL) {
      $binding= $this->module->resolve(XPClass::forName($fqcn), $name);
      if (isset($binding->instance)) return $binding->instance;
      
      $class= $binding->impl;
      if ($class->hasConstructor() && $class->getConstructor()->numParameters() > 0) {
        $constructor= $class->getConstructor();
        $instance= $constructor->newInstance($this->argsFor($constructor, array()));
      } else {
        $instance= $class->newInstance();
      }
      
      foreach ($class->getMethods() as $method) {
        if (!$method->hasAnnotation('inject')) continue;
        $inject= $method->getAnnotation('inject');
        $method->invoke($instance, $this->argsFor(
          $method, 
          isset($inject['name']) ? array($inject['name']) : array()
        ));
      }
      
      return $instance;
    }
  }
?>
