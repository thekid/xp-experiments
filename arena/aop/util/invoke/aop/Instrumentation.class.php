<?php
  uses('util.invoke.aop.Weaver', 'util.invoke.aop.Aspects', 'lang.instrumentation.Instrumentation');

  $package= 'invoke.aop';
  
  class invoke·aop·Instrumentation extends Object {
    
    static function __static() {
      Instrumentation::$t= new self();
    }
    
    /**
     * Transform a class
     *
     * @param   lang.IClassLoader cl
     * @param   string class fully qualified class name
     * @return  string
     */
    public function transform(IClassLoader $cl, $class) {
      if (!isset(Aspects::$pointcuts[$class])) {
      
        // No pointcuts for this class, leave it alone!
        return NULL;
      }
      return Weaver::weaved($class, Aspects::$pointcuts[$class], $cl->loadClassBytes($class));
    }
  }
?>
