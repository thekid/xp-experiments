<?php
  $package= 'ioc';
  
  interface ioc·Module {
    public function resolve($fqcn);
  }
?>