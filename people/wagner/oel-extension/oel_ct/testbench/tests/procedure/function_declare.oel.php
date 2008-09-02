<?php

  $op_a= oel_new_op_array();
  $func_a= oel_new_function($op_a, "funcA");
  var_dump(function_exists("funcA"));

  oel_finalize($op_a);
  oel_execute($op_a);
  var_dump(function_exists("funcA"));

?>
