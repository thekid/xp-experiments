<?php

use lang\Type;
use lang\ClassLoader;

class CreationWithFunction extends Object {
  protected $prop, $new;

  public function __construct($new) {
    $this->new= $new;
  }

  public static final function of($new) {
    return new self($new);
  }

  public function __call($name, $args) { $this->prop[$name]= $args[0]; return $this; }

  public function create() {
    $f= $this->new;
    return $f($this->prop);
  }

  public function toString() {
    return $this->getClassName().'('.\xp::stringOf($this->new).')';
  }
}