<?php

  class classA {
    public function methA($a, $b, $c) { var_dump($c); }
  }

  $oA= new classA();
  $oA->methA("a", "b", "c");

?>
