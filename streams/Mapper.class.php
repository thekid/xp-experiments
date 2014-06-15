<?php

class Mapper extends \lang\Object implements Iterator {
  protected $it;
  protected $func;

  public function __construct(\Iterator $it, callable $func) {
    $this->it= $it;
    $this->func= $func;
  }

  public function rewind() {
    $this->it->rewind();
  }

  public function current() {
    $f= $this->func;
    return $f($this->it->current());
  }

  public function key() {
    return $this->it->key();
  }

  public function next() {
    $this->it->next();
  }

  public function valid() {
    return $this->it->valid();
  }
}