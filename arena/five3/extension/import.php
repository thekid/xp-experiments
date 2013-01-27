<?php
  define('import', '');

  import> new Extension('Enumerable');

  class Extension {
    public static $methods= array();

    public function __construct($class) {
      $r= new ReflectionClass($class);
      foreach ($r->getMethods() as $method) {
        $params= $method->getParameters();
        if (sizeof($params) == 0 || 'self' != $params[0]->name) continue;
        Extension::$methods[$params[0]->getClass()->name][$method->name]= $method;
      }
    }
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

  function __autoload($class) {
    include($class.'.class.php');
  }

  function println() {
    foreach (func_get_args() as $arg) echo $arg;
    echo "\n";
  }

  $a= new ArrayList(1, 2, 3, 4);
  println($a->findAll(function($e) {
    return $e % 2 == 0;
  }));
?>
