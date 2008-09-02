<?php

  class classA {
    public function funcA($a) {
      echo $a;
    }
  }

  $oA= new classA();
  var_dump($oA->funcA("\na\n\n"));

?>
