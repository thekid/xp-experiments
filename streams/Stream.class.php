<?php
use util\Objects;

/**
 * Streams API for PHP
 *
 * @test xp://StreamTest
 */
#[@generic(self= 'T')]
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

  /**
   * Creates a new stream
   *
   * @param  var $elements an iterator, generator or array
   * @return self<R>
   */
  #[@generic(return= 'self<R>')]
  public static function of($elements) {
    if ($elements instanceof \Traversable) {
      return new self($elements);
    } else if ($elements instanceof \Closure) {
      return new self($elements());
    } else {
      return new self($elements);
    }
  }

  /**
   * Creates a new stream iteratively calling the given operation, starting
   * with a given seed, and continuing with op(seed), op(op(seed)), etc.
   *
   * @param  R $seed
   * @param  function<R: R> $op
   * @return self<R>
   */
  #[@generic(return= 'self<R>')]
  public static function iterate($seed, callable $op) {
    $it= $seed;
    return new self(new Yielder(
      $seed,
      function() use(&$it, $op) { $it= $op($it); return $it; },
      true
    ));
  }

  /**
   * Creates a new stream which uses a given supplier to provide the values
   *
   * @param  function<(): R> $supplier
   * @return self<R>
   */
  #[@generic(return= 'self<R>')]
  public static function generate(callable $supplier) {
    return new self(new Yielder(
      $supplier,
      $supplier,
      true
    ));
  }

  /**
   * Concatenates two streams
   *
   * @param  self<R> $a
   * @param  self<R> $b
   * @return self<R>
   */
  #[@generic(params= 'self<R>, self<R>', return= 'self<R>')]
  public static function concat(self $a, self $b) {
    $it= new \AppendIterator();
    $it->append($a->getIterator());
    $it->append($b->getIterator());
    return new self($it);
  }

  /**
   * Returns the first element of this stream, or NULL
   *
   * @return T
   */
  #[@generic(return= 'T')]
  public function first() {
    foreach ($this->elements as $element) {
      return $element;
    }
    return null;
  }

  /**
   * Collects all elements in an array
   *
   * @return T[]
   */
  #[@generic(return= 'T[]')]
  public function toArray() {
    $return= [];
    foreach ($this->elements as $element) {
      $return[]= $element;
    }
    return $return;
  }

  /**
   * Counts all elements
   *
   * @return int
   */
  public function count() {
    $return= 0;
    foreach ($this->elements as $element) {
      $return++;
    }
    return $return;
  }

  /**
   * Returns the sum of all elements
   *
   * @return T
   */
  #[@generic(return= 'T')]
  public function sum() {
    $return= 0;
    foreach ($this->elements as $element) {
      $return+= $element;
    }
    return $return;
  }

  /**
   * Returns the smallest element
   *
   * @return T
   */
  #[@generic(return= 'T')]
  public function min() {
    $return= null;
    foreach ($this->elements as $element) {
      if (null === $return || $element < $return) $return= $element;
    }
    return $return;
  }

  /**
   * Returns the largest element
   *
   * @return T
   */
  #[@generic(return= 'T')]
  public function max() {
    $return= null;
    foreach ($this->elements as $element) {
      if (null === $return || $element > $return) $return= $element;
    }
    return $return;
  }

  /**
   * Performs a reduction on the elements of this stream, using the provided identity
   * value and an associative accumulation function, and returns the reduced value.
   *
   * @param  T $identity
   * @param  function<T, T: T> $function
   * @return self<T>
   */
  public function reduce($identity, $accumulator) {
    $return= $identity;
    foreach ($this->elements as $element) {
      $return= $accumulator($return, $element);
    }
    return $return;
  }

  /**
   * Performs a mutable reduction operation on the elements of this stream.
   *
   * @param  function<(): R> $supplier
   * @param  function<R, T: void> $accumulator
   * @param  function<R: R> $finisher
   * @return R
   */
  public function collect($supplier, $accumulator, $finisher= null) {
    $return= $supplier();
    $f= function($arg) use(&$return, $accumulator) { return $accumulator($return, $arg); };
    foreach ($this->elements as $element) {
      $f($element);
    }
    return $finisher ? $finisher($return) : $return;
  }

  /**
   * Invokes a given consumer on each element
   *
   * @param  function<T> $function
   * @return void
   */
  public function each($consumer) {
    foreach ($this->elements as $element) {
      $consumer($element);
    }
  }

  /**
   * Returns a new stream with only the first `n` elements
   *
   * @param  int $n
   * @return self<T>
   */
  #[@generic(return= 'self<T>')]
  public function limit($n) {
    return new self(new \LimitIterator($this->getIterator(), 0, $n));
  }

  /**
   * Returns a new stream with elements matching the given predicta
   *
   * @param  function<T: bool> $function
   * @return self<T>
   */
  #[@generic(return= 'self<T>')]
  public function filter($predicate) {
    return new self(new \CallbackFilterIterator($this->getIterator(), $predicate));
  }

  /**
   * Returns a new stream which maps the given function to each element
   *
   * @param  function<T: R> $function
   * @return self<R>
   */
  #[@generic(return= 'self<R>')]
  public function map($function) {
    return new self(new Mapper($this->getIterator(), $function));
  }

  /**
   * Returns a stream with distinct elements
   *
   * @return self<T>
   */
  #[@generic(return= 'self<T>')]
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