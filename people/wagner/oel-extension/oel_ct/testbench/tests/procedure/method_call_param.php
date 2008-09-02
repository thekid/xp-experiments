<?php

  class classA {
    public function methA($a) { var_dump($a, "called methA"); }
    public function methB($a) { var_dump($a, "called methB"); }
    public function methC(&$a) { var_dump($a, "called methC"); $a= NULL; }
  }

  $b= "paramB";
  $c= "paramC";
  $oA= new classA();

  $oA->methA("paramA");
  $oA->methB($b);
  $oA->methC($c);
  var_dump($c);

?>
