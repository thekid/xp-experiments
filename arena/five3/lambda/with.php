<?php
  // {{{ Node class
  class Node {
    protected $name;
    
    public function setName($name) {
      $this->name= $name;
    }
    
    public function __destruct() {
      echo 'Destroy node ', $this->name, "\n";
    }
  }
  // }}}
  
  // {{{ with(Object* o, Closure block)
  function with() {
    $args= func_get_args();
    if (($block= array_pop($args)) instanceof Closure)  {
      call_user_func_array($block, $args);
    }
  }
  // }}}

  // {{{ main
  with (new Node(), function($self) {
    $self->setName('Name');
    var_dump($self);
  });
  echo '/with', "\n";
  // }}}
?>
