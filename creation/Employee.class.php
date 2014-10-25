<?php

class Employee extends Object {
  protected $id, $name;
  public function __construct($id, $name) {
    $this->id= $id;
    $this->name= $name;
  }

  public function id() { return $this->id; }
  public function name() { return $this->name; }

  public static function create() {
    return new Creation(function($prop) {
      return new self($prop['id'], $prop['name']); }
    );
  }
}