<?php
  namespace experiment\defaults;

  class MemoryQueue extends \lang\Object implements Queue {
    use __QueueDefaults;

    protected $messages= [];

    public function __construct($messages) { 
      $this->messages= $messages; 
    }

    public function get() { 
      return array_shift($this->messages); 
    }
  }
?>