<?php

  class classA {
    function funcA($a, $b, $c) {
      return $c;
    }
  }

  $oA= new classA();
  var_dump($oA->funcA("a", "b", "c"));


?>
