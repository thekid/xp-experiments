<?php
  class Extension {
    public static $methods= array();
  }
  
  class Object {
    public function __call($method, $args) {
      foreach (Extension::$methods as $k => $v) {
        if (!isset($v[$method]) || !$this instanceof $k) continue;
        array_unshift($args, $this);
        return $v[$method]->invokeArgs($this, $args);
      }
      throw new BadMethodCallException('No such method '.get_class($this).'::'.$method);
    }
  }

  function uses() {
    foreach (func_get_args() as $class) {
      if (!include($class.'.class.php')) {
        throw new InvalidArgumentException('Cannot load class '.$class);
      }
      
      // Gather extension methods
      $r= new ReflectionClass($class);
      foreach ($r->getMethods() as $method) {
        $params= $method->getParameters();
        if (sizeof($params) == 0 || 'self' != $params[0]->name) continue;
        Extension::$methods[$params[0]->getClass()->name][$method->name]= $method;
      }
    }
  }

  function println() {
    foreach (func_get_args() as $arg) echo $arg;
    echo "\n";
  }
  
  uses('ArrayList', 'Enumerable');
  
  $a= new ArrayList(1, 2, 3, 4);
  println($a->findAll(function($e) {
    return $e % 2 == 0;
  }));
?>
