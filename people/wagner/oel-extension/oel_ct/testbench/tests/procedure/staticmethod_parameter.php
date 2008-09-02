<?php

  class classA {
    public static function funcA($a) {
      echo $a;
    }
  }

  var_dump(classA::funcA("\na\n\n"));

?>
