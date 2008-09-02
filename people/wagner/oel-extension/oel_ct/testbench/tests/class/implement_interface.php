<?php

  interface IClassA {}
  class ClassA implements IClassA {}

  $i= new ReflectionClass("IClassA");
  $c= new ReflectionClass("ClassA");

  var_dump(
    $i->isInterface(),
    $c->implementsInterface("IClassA")
  );

?>
