<?php

  class classA {
    public static function methA() {}
  }

  $c= new ReflectionClass("classA");
  var_dump($c->hasMethod("methA"));
  $cm= $c->getMethod("methA");
  var_dump($cm->isStatic());

?>
