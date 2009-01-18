<?php
  class Object {
    public static function prototype() {
      return new Prototype(get_called_class());
    }
    
    public function __call($method, $args) {
      array_unshift($args, $this);
      return call_user_func_array(Prototype::$methods[get_class($this)][$method], $args);
    }
  }
  
  
  class Prototype {
    public $class;
    public static $methods= array();
    
    public function __construct($class) {
      $this->class= $class;
      self::$methods[$class]= array();
    }

    public function __set($name, $value) {
      self::$methods[$this->class][$name]= $value;
    }
  }
  
  class ArrayList extends Object implements IteratorAggregate {
    public $values;
  
    public function __construct() {
      $this->values= func_get_args();
    }
    
    public function getIterator() {
      return new ArrayIterator($this->values);
    }
    
    public function __toString() {
      return '['.implode(', ', $this->values).']';
    }
  }
  $a= new ArrayList(1, 2, 3, 4);

  $a->each(function($e) { var_dump($e); });

  ArrayList::prototype()->each= function($self, $closure) {
    foreach ($self->values as $value) {
      $closure($value);
    }
  };
  
  $a= new ArrayList(1, 2, 3, 4);
  $a->each(function($e) { var_dump($e); });
?>
