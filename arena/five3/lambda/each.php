<?php
  class ArrayList {
    protected $values;
  
    public function __construct() {
      $this->values= func_get_args();
    }

    public function each($closure) {
      foreach ($this->values as $value) $closure($value);
    }
  }

  $a= new ArrayList('one', 'two', 'three');
  $a->each(function($v) { echo $v, "\n"; });
?>
