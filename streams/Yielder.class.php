<?php

class Yielder extends \lang\Object implements Iterator {
  protected $result;
  protected $invocations;

  public function __construct($init, callable $func, $close) {
    $this->init= $init;
    $this->func= $func;
    $this->close= $close;
  }

  public function rewind() {
    $this->invocations= 0;
    if ($this->init instanceof \Closure) {
      $f= $this->init;
      $this->result= $f();
    } else {
      $this->result= $this->init;
    }
  }

  public function current() {
    return $this->result;
  }

  public function key() {
    return $this->invocations++;
  }

  public function next() {
    $f= $this->func;
    $this->result= $f();
  }

  public function valid() {
    if ($this->close instanceof \Closure) {
      $f= $this->close;
      return $f();
    } else {
      return $this->close;
    }
  }
}