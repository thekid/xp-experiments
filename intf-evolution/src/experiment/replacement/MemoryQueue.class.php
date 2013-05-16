<?php
  namespace experiment\replacement;

  class MemoryQueue extends \lang\Object {
    use Queue;

    protected $messages= [];

    public function __construct($messages) { 
      $this->messages= $messages; 
    }

    public function get() { 
      return array_shift($this->messages); 
    }
  }
?>