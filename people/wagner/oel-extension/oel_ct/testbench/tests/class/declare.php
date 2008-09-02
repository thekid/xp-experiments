<?php

  var_dump(
    FALSE,
    FALSE,
    FALSE
  );

  var_dump(
    FALSE,
    FALSE,
    FALSE
  );

       interface IClassA {}
  abstract class AClassA {}
           class ClassA  {}

  var_dump(
    interface_exists("IClassA"),
    class_exists("AClassA"),
    class_exists("ClassA")
  );

  $i= new ReflectionClass("IClassA");
  $a= new ReflectionClass("AClassA");

  var_dump(
    $i->isInterface(),
    $a->isAbstract()
  );

?>
