<?php

  abstract class AClassA {}
  class ClassA extends AClassA {}

  $a= new ClassA();
  $c= new ReflectionClass("ClassA");

  var_dump(
    $c->isInstance(new ReflectionClass("AClassA")),
    $a instanceof AClassA
  );

?>
