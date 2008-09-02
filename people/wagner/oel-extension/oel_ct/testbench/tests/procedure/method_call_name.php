<?php

  class classA {
    public function methA() { var_dump("called methA by name"); }
  }

  $a= "methA";
  $oA= new classA();
  $oA->$a();

?>
