<?php

  $op_a= oel_new_op_array();

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_isset($op_a);
  oel_add_call_function($op_a, 1, "var_dump");
  oel_add_free($op_a);

  oel_finalize($op_a);

  oel_execute($op_a);
  $a= "";
  oel_execute($op_a);

?>
