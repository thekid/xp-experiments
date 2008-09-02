<?php

  $a= "valueA";
  class classA {
    public static $b= "valueB";
  }

  var_dump($a);
  var_dump(classA::$b);

?>
