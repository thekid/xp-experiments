<?php

  $op_a= oel_new_op_array();
  $op_b= oel_new_op_array();

  oel_add_begin_variable_parse($op_a);
  oel_add_begin_variable_parse($op_b);
  oel_push_variable($op_a, "cond");
  oel_push_variable($op_b, "cond");
  oel_add_end_variable_parse($op_a);
  oel_add_end_variable_parse($op_b);
  oel_add_unary_op($op_a, OEL_UNARY_OP_BOOL_NOT);
  oel_add_unary_op($op_b, OEL_UNARY_OP_BW_NOT);
  oel_add_begin_variable_parse($op_a);
  oel_add_begin_variable_parse($op_b);
  oel_push_variable($op_a, "a");
  oel_push_variable($op_b, "a");
  oel_add_assign($op_a);
  oel_add_assign($op_b);
  oel_add_free($op_a);
  oel_add_free($op_b);

  oel_finalize($op_a);
  oel_finalize($op_b);

  $cond= TRUE;
  oel_execute($op_a);
  var_dump($a);

  $cond= 0xFFFF;
  oel_execute($op_b);
  var_dump(0x0F0F | $a);

?>
