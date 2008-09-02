<?php

function funcA() {return 1; }
function funcB() {return "a"; }
function funcC() {return FALSE; }

var_dump(
  funcA(),
  funcB(),
  funcC()
);

?>
