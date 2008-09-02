<?php

  $aa= "a";
  $bb= "b";

  $a= "valueA";
  class classA {
    public static $b= "valueB";
  }

  var_dump($$aa);
  var_dump(classA::$$bb);

?>
