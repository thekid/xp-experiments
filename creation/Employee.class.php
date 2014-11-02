<?php

class Employee extends Object { use CreateWith;
  protected $id, $name;
  public function __construct($id, $name) {
    $this->id= $id;
    $this->name= $name;
  }

  public function id() { return $this->id; }
  public function name() { return $this->name; }
  public function toString() { return $this->getClassName().'(#'.$this->id.' "'.$this->name.'")'; }
}