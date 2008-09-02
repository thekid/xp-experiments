<?php

  class classA {
    public $propA= NULL;
  }

  $oA1= new classA();
  $oA2= $oA1;
  $oA3= clone $oA1;

  var_dump(
    $oA1,
    $oA2,
    $oA3
  );

  $oA1->propA= 1;
  $oA2->propA= 2;
  $oA3->propA= 3;

  var_dump(
    $oA1,
    $oA2,
    $oA3
  );

?>
