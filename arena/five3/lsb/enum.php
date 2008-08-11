<?php
  // {{{ newinstance
  function newinstance($parent, $args, $src) {
    static $counter= 0;
    
    $name= $parent.'·'.($counter++);
    eval('class '.$name.' extends '.$parent.' '.$src);
    $c= new ReflectionClass($name);
    return $c->newInstanceArgs($args);
  }
  // }}}

  // {{{ Enum
  abstract class Enum {
    protected
      $name     = '',
      $ordinal  = 0;
  
    public function __construct($ordinal= 0, $name= '') {
      $this->ordinal= $ordinal;
      $this->name= $name;
    }
  
    public function __toString() {
      return $this->name;
    }

    public static function values() {
      $c= new ReflectionClass(get_called_class());
      return array_values($c->getStaticProperties());
    }
  }
  // }}}
  
  // {{{ Operation
  abstract class Operation extends Enum {
    public static $plus, $minus, $times, $divided_by;
    
    static function __static() {
      self::$plus= newinstance(__CLASS__, array(0, 'plus'), '{
        static function __static() { }
        public function evaluate($x, $y) { return $x + $y; } 
      }');
      self::$minus= newinstance(__CLASS__, array(1, 'minus'), '{
        static function __static() { }
        public function evaluate($x, $y) { return $x - $y; } 
      }');
      self::$times= newinstance(__CLASS__, array(2, 'times'), '{
        static function __static() { }
        public function evaluate($x, $y) { return $x * $y; } 
      }');
      self::$divided_by= newinstance(__CLASS__, array(3, 'divided_by'), '{
        static function __static() { }
        public function evaluate($x, $y) { return $x / $y; } 
      }');
    }

    public abstract function evaluate($x, $y);
  }
  Operation::__static();
  // }}}

  // {{{ main
  $a= @$argv[1] ?: 1;
  $b= @$argv[2] ?: 2;
  foreach (Operation::values() as $op) {
    echo $a, ' ', $op, ' ', $b, ' = ', $op->evaluate($a, $b), "\n";
  }
  // }}}
?>
