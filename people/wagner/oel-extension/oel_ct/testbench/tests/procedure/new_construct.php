<?php

  class classA {
    public $propA= NULL;

    public function __construct($a) {
      $this->propA= $a;
    }
  }

  $oA1= new classA("wertA");
  var_dump($oA1);

?>
