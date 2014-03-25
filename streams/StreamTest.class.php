<?php
class StreamTest extends \unittest\TestCase {

  #[@test]
  public function can_create_via_of() {
    $this->assertInstanceOf('Stream', Stream::of([1, 2, 3]));
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
}