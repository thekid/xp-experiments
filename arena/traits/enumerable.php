<?php
  trait Enumerable {
    public function map($block) {
      $r= array();
      foreach ($this->values as $value) {
        $r[]= $block($value);
      }
      return $r;
    }
  }

  class ArrayList implements IteratorAggregate {
    use Enumerable;

    public $values;
    public function __construct() { $this->values= func_get_args(); }

    public function getIterator() {
      return new ArrayIterator($this->values);
    }
  }

  $list= new ArrayList(1, 2, 3);
  var_dump($list->map(function($e) { return $e * 2; }));
?>
