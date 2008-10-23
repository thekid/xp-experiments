<?php

  $op_a= oel_new_op_array();
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "func_name");
  oel_add_end_variable_parse($op_a);
  oel_add_call_function_name($op_a, 0);
  oel_add_free($op_a);
  oel_finalize($op_a);

  function funcA() { var_dump("called funcA"); }
  $func_name= "funcA";
  oel_execute($op_a);

?>
