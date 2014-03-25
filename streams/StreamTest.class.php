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
}