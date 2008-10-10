<?php

$op_a= oel_new_op_array();

$func_a= oel_new_function($op_a, "funcA");
  oel_add_receive_arg($func_a, 1, "a");
  oel_add_receive_arg($func_a, 2, "b");
  oel_add_receive_arg($func_a, 3, "c");
  oel_add_begin_variable_parse($func_a);
  oel_push_variable($func_a, "c");
  oel_add_return($func_a);

oel_finalize($op_a);
oel_execute($op_a);

var_dump(funcA("a", "b", "c"));

?>
