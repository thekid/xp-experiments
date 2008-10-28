<?php

  interface ClassA {
    function methA();
  }

  interface ClassB {
    function methB();
  }

  interface ClassC extends ClassA, ClassB {
    function methC();
  }

  $c= new ReflectionClass("ClassC");
  var_dump(
    $c->getMethods(),
    $c->getInterfaces(),
    $c->getParentclass()
  );

?>
