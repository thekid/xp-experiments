<?php
  namespace experiment;

  interface Enumerable {} trait __Enumerable {
    public function map($block) {
      $r= array();
      foreach ($this as $value) {
        $r[]= $block($value);
      }
      return $r;
    }
  }
?>