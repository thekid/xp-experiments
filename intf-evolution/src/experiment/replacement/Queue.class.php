<?php
  namespace experiment\replacement;
  
  trait Queue {
    abstract public function get();
    function clear() {
      while (NULL !== $this->get()) {
      }
    }
  }
?>