<?php
  class ContentType extends Object {
    protected $value= '';

    public function __construct($value) {
      $this->value= $value;
    }

    public function equals($cmp) {
      return $cmp instanceof self && $cmp->value === $this->value;
    }

    public function toString() {
      return $this->getClassName().'<'.$this->value.'>';
    }
  }
?>