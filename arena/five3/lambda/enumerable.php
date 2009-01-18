<?php
  class Enumerable {

    public static function each(Traversable $list, Closure $closure) {
      foreach ($list as $element) {
        $closure($element);
      }
    }
  
    public static function find(Traversable $list, Closure $closure) {
      foreach ($list as $element) {
        if ($closure($element)) return $element;
      }
      return NULL;
    }

    public static function findAll(Traversable $list, Closure $closure) {
      $r= new ArrayList();
      foreach ($list as $element) {
        if ($closure($element)) $r->values[]= $element;
      }
      return $r;
    }

    public static function get(Traversable $list, Closure $closure) {
      foreach ($list as $element) {
        if ($closure($element)) return $element;
      }
      throw new UnderflowException('No element found');
    }

    public static function getAll(Traversable $list, Closure $closure) {
      $r= new ArrayList();
      foreach ($list as $element) {
        if ($closure($element)) $r->values[]= $element;
      }
      if (0 == sizeof($r->values)) {
         throw new UnderflowException('No element found');
      }
      return $r;
    }

    public static function collect(Traversable $list, Closure $closure) {
      $r= new ArrayList();
      foreach ($list as $element) {
        $r->values[]= $closure($element);
      }
      return $r;
    }

    public static function size(Traversable $list) {
      $s= 0;
      foreach ($list as $element) $s++;
      return $s;
    }

    public static function partition(Traversable $list, Closure $closure) {
      $t= new ArrayList();
      $f= new ArrayList();
      $r= new ArrayList($t, $f);
      foreach ($list as $element) {
        if ($closure($element)) $t->values[]= $element; else $f->values[]= $element;
      }
      return $r;
    }
  }

  class ArrayList implements IteratorAggregate {
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
  
  function tryto(Closure $c) {
    try {
      return $c();
    } catch (Exception $e) {
      return get_class($e).': '.$e->getMessage();
    }
  }
  
  function with() {
    $args= func_get_args();
    call_user_func_array(array_pop($args), $args);
  }
  
  function println() {
    foreach (func_get_args() as $arg) echo $arg;
    echo "\n";
  }
  
  with (new ArrayList(1, 2, 3, 4), function($probe) {
    println('== Probe: ', $probe, ' ==');

    println('size             : ', Enumerable::size($probe));

    print('each(echo)       : ');
    Enumerable::each($probe, function($e) { echo $e, ' '; });
    println();
    
    println('find(e % 2)      : ', Enumerable::find($probe, function($e) {
      return $e % 2 == 0;
    }));

    println('findAll(e % 2)   : ', Enumerable::findAll($probe, function($e) {
      return $e % 2 == 0;
    }));

    println('get(e % 7)       : ', tryto(function() use($probe) {
      return Enumerable::get($probe, function($e) {
        return $e % 7 == 0;
      });
    }));

    println('getAll(e % 7)    : ', tryto(function() use($probe) {
      return Enumerable::getAll($probe, function($e) {
        return $e % 7 == 0;
      });
    }));

    println('collect(e * 2)   : ', Enumerable::collect($probe, function($e) {
      return $e * 2;
    }));

    println('partition(e % 2) : ', Enumerable::partition($probe, function($e) {
      return $e % 2;
    }));
  });
?>
