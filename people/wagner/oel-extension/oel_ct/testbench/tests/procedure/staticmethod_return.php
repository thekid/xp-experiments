<?php

class classA {
  public static function funcA() {return 1; }
  public static function funcB() {return "a"; }
  public static function funcC() {return FALSE; }
}

var_dump(
  classA::funcA(),
  classA::funcB(),
  classA::funcC()
);

?>
