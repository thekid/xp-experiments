<?php

class Creation extends Object {
  protected $new, $prop= [];

  public function __construct($new) {
    $this->new= $new;
  }

  public function __call($name, $args) {
    $this->prop[$name]= $args[0];
    return $this;
  }

  public function instance() {
    $new= $this->new;
    return $new($this->prop);
  }
}