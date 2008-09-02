<?php

  class classA {
    public static function methA() { var_dump("called methA"); return "return_methA"; }
  }

  var_dump(classA::methA());

?>
