<?php

  class classA {
    public static function methA($a) { var_dump($a, "called methA"); }
    public static function methB($a) { var_dump($a, "called methB"); }
    public static function methC(&$a) { var_dump($a, "called methC"); $a= NULL; }
  }

  $b= "paramB";
  $c= "paramC";

  classA::methA("paramA");
  classA::methB($b);
  classA::methC($c);
  var_dump($c);

?>
