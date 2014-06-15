<?php
use util\Objects;

/**
 * Streams API for PHP
 *
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

  public static function iterate($seed, callable $op) {
    $it= $seed;
    return new self(new Yielder(
      $seed,
      function() use(&$it, $op) { $it= $op($it); return $it; },
      true
    ));
  }

  public static function generate(callable $supplier) {
    return new self(new Yielder(
      $supplier,
      $supplier,
      true
    ));
  }

  public static function concat(self $a, self $b) {
    $it= new \AppendIterator();
    $it->append($a->getIterator());
    $it->append($b->getIterator());
    return new self($it);
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
    return new self(new \LimitIterator($this->getIterator(), 0, $n));
  }

  public function filter($predicate) {
    return new self(new \CallbackFilterIterator($this->getIterator(), $predicate));
  }

  public function map($function) {
    return new self(new Mapper($this->getIterator(), $function));
  }

  public function distinct() {
    $set= [];
    return new self(new \CallbackFilterIterator($this->getIterator(), function($e) use(&$set) {
      $h= Objects::hashOf($e);
      if (isset($set[$h])) {
        return false;
      } else {
        $set[$h]= true;
        return true;
      }
    }));
  }
}