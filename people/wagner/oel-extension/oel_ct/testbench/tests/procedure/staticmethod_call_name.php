<?php

  class classA {
    public static function methA() { var_dump("called methA by name"); }
  }

  $a= "methA";
  classA::$a();

?>
