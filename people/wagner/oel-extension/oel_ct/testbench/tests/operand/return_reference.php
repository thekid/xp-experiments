<?php

  function &funcA() {
    static $a= NULL;
    return $a;
  }

  $b= &funcA();
  var_dump($b);
  $b= 3.4;
  var_dump(funcA());

  $b= funcA();
  var_dump($b);
  $b= 4.9;
  var_dump(funcA());

?>
