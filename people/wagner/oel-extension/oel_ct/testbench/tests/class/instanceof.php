<?php

  abstract class AClassA {}
  class ClassA extends AClassA {}
  class ClassB {}

  $a= new ClassA();
  $c= $a instanceof AClassA;
  var_dump($c);

  $a= new ClassB();
  $c= $a instanceof AClassA;
  var_dump($c);

?>
