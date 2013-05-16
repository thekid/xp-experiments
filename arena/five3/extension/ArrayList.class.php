<?php
  class ArrayList extends Object implements IteratorAggregate {
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
?>
