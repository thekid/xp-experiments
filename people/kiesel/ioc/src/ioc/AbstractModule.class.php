<?php
  uses('ioc.Module');
  
  class AbstractModule extends Object implements ioc·Module {
    public function resolve($fqcn) {
      return $fqcn;
    }
  }
?>