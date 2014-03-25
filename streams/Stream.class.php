<?php
class Stream extends \lang\Object {
  protected $elements;

  protected function __construct($elements) {
    $this->elements= $elements;
  }

  public static function of($elements) {
    return new self($elements);
  }

  public function toArray() {
    $return= [];
    foreach ($this->elements as $element) {
      $return[]= $element;
    }
    return $return;
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