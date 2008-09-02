<?php

  $op_a= oel_new_op_array();
  $op_b= oel_new_op_array();
  $op_c= oel_new_op_array();
  $op_d= oel_new_op_array();

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "cond1");
  oel_add_end_variable_parse($op_a);
  oel_add_begin_logical_op($op_a, OEL_OP_BOOL_AND);
  oel_push_value($op_a, "touched");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_assign($op_a);
  oel_add_end_logical_op($op_a);
  oel_add_free($op_a);

  oel_add_begin_variable_parse($op_b);
  oel_push_variable($op_b, "cond1");
  oel_add_end_variable_parse($op_b);
  oel_add_begin_logical_op($op_b, OEL_OP_BOOL_OR);
  oel_push_value($op_b, "touched");
  oel_add_begin_variable_parse($op_b);
  oel_push_variable($op_b, "a");
  oel_add_assign($op_b);
  oel_add_end_logical_op($op_b);
  oel_add_free($op_b);

  oel_add_begin_variable_parse($op_c);
  oel_push_variable($op_c, "a");
  oel_add_end_variable_parse($op_c);
  oel_add_begin_logical_op($op_c, OEL_OP_BOOL_AND);
  oel_add_begin_variable_parse($op_c);
  oel_push_variable($op_c, "b");
  oel_add_end_variable_parse($op_c);
  oel_add_end_logical_op($op_c);
  oel_add_begin_variable_parse($op_c);
  oel_push_variable($op_c, "c");
  oel_add_assign($op_c);
  oel_add_free($op_c);

  oel_add_begin_variable_parse($op_d);
  oel_push_variable($op_d, "a");
  oel_add_end_variable_parse($op_d);
  oel_add_begin_logical_op($op_d, OEL_OP_BOOL_OR);
  oel_add_begin_variable_parse($op_d);
  oel_push_variable($op_d, "b");
  oel_add_end_variable_parse($op_d);
  oel_add_end_logical_op($op_d);
  oel_add_begin_variable_parse($op_d);
  oel_push_variable($op_d, "c");
  oel_add_assign($op_d);
  oel_add_free($op_d);

  oel_finalize($op_a);
  oel_finalize($op_b);
  oel_finalize($op_c);
  oel_finalize($op_d);

  $a= "untouched";
  $cond1= TRUE;
  oel_execute($op_a);
  var_dump($cond1, $a);

  $a= "untouched";
  $cond1= TRUE;
  oel_execute($op_b);
  var_dump($cond1, $a);

  $a= "untouched";
  $cond1= FALSE;
  oel_execute($op_a);
  var_dump($cond1, $a);

  $a= "untouched";
  $cond1= FALSE;
  oel_execute($op_b);
  var_dump($cond1, $a);

  $a= TRUE;
  $b= FALSE;
  oel_execute($op_c);
  var_dump($c);

  $a= TRUE;
  $b= FALSE;
  oel_execute($op_d);
  var_dump($c);

  $a= TRUE;
  $b= TRUE;
  oel_execute($op_c);
  var_dump($c);

  $a= FALSE;
  $b= FALSE;
  oel_execute($op_d);
  var_dump($c);

?>
