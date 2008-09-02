<?php

class classA {
  public function funcA() {return 1; }
  public function funcB() {return "a"; }
  public function funcC() {return FALSE; }
}

$oA= new classA();
var_dump(
  $oA->funcA(),
  $oA->funcB(),
  $oA->funcC()
);

?>
