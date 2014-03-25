<?php
class Stream extends \lang\Object {
  protected $elements;

  protected function __construct(\Traversable $elements) {
    $this->elements= $elements;
  }

  public static function of($elements) {
    if ($elements instanceof \Traversable) {
      return new self($elements);
    } else if ($elements instanceof \Closure) {
      return new self($elements());
    } else {
      return new self(new \ArrayIterator($elements));
    }
  }

  public static function iterate($seed, $op) {
    $func= function() use($seed, $op) {
      for ($i= $seed; ; $i= $op($i)) {
        yield $i;
      }
      // Runs forever
    };
    return new self($func());
  }

  public function first() {
    foreach ($this->elements as $element) {
      return $element;
    }
    return null;
  }

  public function toArray() {
    $return= [];
    foreach ($this->elements as $element) {
      $return[]= $element;
    }
    return $return;
  }

  public function count() {
    $return= 0;
    foreach ($this->elements as $element) {
      $return++;
    }
    return $return;
  }

  public function sum() {
    $return= 0;
    foreach ($this->elements as $element) {
      $return+= $element;
    }
    return $return;
  }

  public function reduce($identity, $accumulator) {
    $return= $identity;
    foreach ($this->elements as $element) {
      $return= $accumulator($return, $element);
    }
    return $return;
  }

  public function collect($supplier, $accumulator, $finisher= null) {
    $return= $supplier();
    $f= function($arg) use(&$return, $accumulator) { return $accumulator($return, $arg); };
    foreach ($this->elements as $element) {
      $f($element);
    }
    return $finisher ? $finisher($return) : $return;
  }

  public function each($consumer) {
    foreach ($this->elements as $element) {
      $consumer($element);
    }
  }

  public function limit($n) {
    $func= function() use($n) {
      $i= 0;
      foreach ($this->elements as $element) {
        yield $element;
        if (++$i >= $n) break;
      }
    };
    return new self($func());
  }

  public function filter($predicate) {
    $func= function() use($predicate) {
      foreach ($this->elements as $element) {
        if ($predicate($element)) yield $element;
      }
    };
    return new self($func());
  }

  public function map($function) {
    $func= function() use($function) {
      foreach ($this->elements as $element) {
        yield $function($element);
      }
    };
    return new self($func());
  }
}