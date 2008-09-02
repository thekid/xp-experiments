<?php

$op_a= oel_new_op_array();

$func_a= oel_new_function($op_a, "funcA");
  oel_add_receive_arg($func_a, 1, "a");
  oel_add_begin_variable_parse($func_a);
  oel_push_variable($func_a, "a");
  oel_add_end_variable_parse($func_a);
  oel_add_echo($func_a);

oel_finalize($op_a);
oel_execute($op_a);

var_dump(funcA("\na\n\n"));

?>
