<?php
  $package= 'ioc';
  
  class ioc·Injector extends Object {
    protected
      $module = NULL;
      
    public function __construct(ioc·Module $module) {
      $this->module= $module;
    }
    
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
        $instance= $class->newInstance($args);
      } else {
        $instance= $class->newInstance();
      }
      
      /* foreach ($class->getMethods() as $method) {
        if ($method->hasAnnotation('inject')) {
          // TBI
        }
      } */
      
      return $instance;
    }
  }
?>