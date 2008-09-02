<?php

  class classA {
    public function funcA() {}
  }

  $c= new ReflectionClass("classA");
  var_dump($c->hasMethod("methA"));

?>
