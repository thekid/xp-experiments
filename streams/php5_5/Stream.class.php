<?php
/**
 * Streams, PHP 5.5 implementation
 *
 * @see  php://yield
 * @test xp://StreamTest
 */
class Stream extends \lang\Object implements \IteratorAggregate {
  protected $elements;

  protected function __construct($elements) {
    $this->elements= $elements;
  }

  /**
   * Gets an iterator on this stream. Optimizes the case that the underlying
   * elements already is an Iterator, and handles both wrappers implementing
   * the Traversable interfaces as well as primitive arrays.
   *
   * @return  php.Iterator
   */
  public function getIterator() {
    if ($this->elements instanceof \Iterator) {
      return $this->elements;
    } else if ($this->elements instanceof \Traversable) {
      return new \IteratorIterator($this->elements);
    } else {
      return new \ArrayIterator($this->elements);
    }
  }

  public static function of($elements) {
    if ($elements instanceof \Traversable) {
      return new self($elements);
    } else if ($elements instanceof \Closure) {
      return new self($elements());
    } else {
      return new self($elements);
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

  public static function generate($supplier) {
    $func= function() use($supplier) {
      while (true) {
        yield $supplier();
      }
      // Runs forever
    };
    return new self($func());
  }

  public static function concat(self $a, self $b) {
    $func= function() use($a, $b) {
      foreach ($a->elements as $element) {
        yield $element;
      }
      foreach ($b->elements as $element) {
        yield $element;
      }
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

  public function min() {
    $return= null;
    foreach ($this->elements as $element) {
      if (null === $return || $element < $return) $return= $element;
    }
    return $return;
  }

  public function max() {
    $return= null;
    foreach ($this->elements as $element) {
      if (null === $return || $element > $return) $return= $element;
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