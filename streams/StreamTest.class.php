<?php
class StreamTest extends \unittest\TestCase {

  #[@test]
  public function can_create_via_of() {
    $this->assertInstanceOf('Stream', Stream::of([1, 2, 3]));
  }

  #[@test]
  public function can_create_via_iterate() {
    $this->assertInstanceOf('Stream', Stream::iterate(0, function($i) { return $i++; }));
  }

  #[@test, @values([
  #  [[1, 2, 3]],
  #  [function() { yield 1; yield 2; yield 3; }]
  #])]
  public function toArray_returns_elements_as_array($input) {
    $this->assertEquals([1, 2, 3], Stream::of($input)->toArray());
  }

  #[@test]
  public function filter() {
    $this->assertEquals([2, 4], Stream::of([1, 2, 3, 4])
      ->filter(function($e) { return 0 === $e % 2; })
      ->toArray()
    );
  }

  #[@test]
  public function map() {
    $this->assertEquals([2, 4, 6, 8], Stream::of([1, 2, 3, 4])
      ->map(function($e) { return $e * 2; })
      ->toArray()
    );
  }

  #[@test, @values([
  #  [0, []],
  #  [1, [1]],
  #  [4, [1, 2, 3, 4]]
  #])]
  public function count($length, $values) {
    $this->assertEquals($length, Stream::of($values)->count());
  }

  #[@test, @values([
  #  [0, []],
  #  [1, [1]],
  #  [10, [1, 2, 3, 4]]
  #])]
  public function sum($length, $values) {
    $this->assertEquals($length, Stream::of($values)->sum());
  }

  #[@test]
  public function reduce_returns_identity_for_empty_input() {
    $this->assertEquals(-1, Stream::of([])->reduce(-1, function($a, $b) {
      $this->fail('Should not be called');
    }));
  }

  #[@test]
  public function reduce_used_for_summing() {
    $this->assertEquals(10, Stream::of([1, 2, 3, 4])->reduce(0, function($a, $b) {
      return $a + $b;
    }));
  }

  #[@test]
  public function reduce_used_for_concatenation() {
    $this->assertEquals('Hello World', Stream::of(['Hello', ' ', 'World'])->reduce('', function($a, $b) {
      return $a.$b;
    }));
  }

  #[@test]
  public function collect() {
    $result= Stream::of([1, 2, 3, 4])->collect(
      function() { return ['total' => 0, 'sum' => 0]; },
      function(&$result, $arg) { $result['total']++; $result['sum']+= $arg; }
    );
    $this->assertEquals(2.5, $result['sum'] / $result['total']);
  }


  #[@test]
  public function first_returns_null_for_empty_input() {
    $this->assertNull(Stream::of([])->first());
  }

  #[@test]
  public function first_returns_first_array_element() {
    $this->assertEquals(1, Stream::of([1, 2, 3])->first());
  }

  #[@test]
  public function each() {
    $collect= [];
    Stream::of([1, 2, 3, 4])->each(function($e) use(&$collect) { $collect[]= $e; });
    $this->assertEquals([1, 2, 3, 4], $collect);
  }

  #[@test]
  public function limit_stops_at_nth_array_element() {
    $this->assertEquals([1, 2], Stream::of([1, 2, 3])->limit(2)->toArray());
  }

  #[@test]
  public function limit_stops_at_nth_iterator_element() {
    $this->assertEquals([1, 2], Stream::iterate(1, function($i) { return ++$i; })
      ->limit(2)
      ->toArray()
    );
  }
}