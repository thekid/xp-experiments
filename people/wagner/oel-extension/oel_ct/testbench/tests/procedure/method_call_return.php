<?php

  class classA {
    public function methA() { var_dump("called methA"); return "return_methA"; }
  }

  $oA= new classA();
  var_dump($oA->methA());

?>
