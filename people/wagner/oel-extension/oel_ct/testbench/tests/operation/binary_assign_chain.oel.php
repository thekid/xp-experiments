<?php

  $op_a= oel_new_op_array();


  oel_push_value($op_a, 10);
  oel_push_value($op_a, 10);
  oel_push_value($op_a, 10);
  oel_push_value($op_a, 10);

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_ADD);

  oel_add_begin_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_ADD);

  oel_add_begin_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_ADD);

  oel_add_begin_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_ADD);

  oel_add_free($op_a);

  oel_finalize($op_a);

  $a= 3;

  oel_execute($op_a);

  var_dump($a);

?>
