<?php

  $op_a= oel_new_op_array();
  $op_b= oel_new_op_array();
  $op_c= oel_new_op_array();
  $op_d= oel_new_op_array();
  $op_e= oel_new_op_array();
  $op_f= oel_new_op_array();
  $op_g= oel_new_op_array();

  oel_add_begin_variable_parse($op_a);
  oel_add_begin_variable_parse($op_b);
  oel_add_begin_variable_parse($op_c);
  oel_add_begin_variable_parse($op_d);
  oel_add_begin_variable_parse($op_e);
  oel_add_begin_variable_parse($op_f);
  oel_add_begin_variable_parse($op_g);
  oel_push_variable($op_a, "expr1");
  oel_push_variable($op_b, "expr1");
  oel_push_variable($op_c, "expr2");
  oel_push_variable($op_d, "expr1");
  oel_push_variable($op_e, "expr2");
  oel_push_variable($op_f, "expr1");
  oel_push_variable($op_g, "expr1");
  oel_add_end_variable_parse($op_a);
  oel_add_end_variable_parse($op_b);
  oel_add_end_variable_parse($op_c);
  oel_add_end_variable_parse($op_d);
  oel_add_end_variable_parse($op_e);
  oel_add_end_variable_parse($op_f);
  oel_add_end_variable_parse($op_g);
  oel_add_cast_op($op_a, OEL_OP_TO_INT);
  oel_add_cast_op($op_b, OEL_OP_TO_DOUBLE);
  oel_add_cast_op($op_c, OEL_OP_TO_STRING);
  oel_add_cast_op($op_d, OEL_OP_TO_ARRAY);
  oel_add_cast_op($op_e, OEL_OP_TO_OBJECT);
  oel_add_cast_op($op_f, OEL_OP_TO_BOOL);
  oel_add_cast_op($op_g, OEL_OP_TO_UNSET);
  oel_add_begin_variable_parse($op_a);
  oel_add_begin_variable_parse($op_b);
  oel_add_begin_variable_parse($op_c);
  oel_add_begin_variable_parse($op_d);
  oel_add_begin_variable_parse($op_e);
  oel_add_begin_variable_parse($op_f);
  oel_add_begin_variable_parse($op_g);
  oel_push_variable($op_a, "a");
  oel_push_variable($op_b, "b");
  oel_push_variable($op_c, "c");
  oel_push_variable($op_d, "d");
  oel_push_variable($op_e, "e");
  oel_push_variable($op_f, "f");
  oel_push_variable($op_g, "g");
  oel_add_assign($op_a);
  oel_add_assign($op_b);
  oel_add_assign($op_c);
  oel_add_assign($op_d);
  oel_add_assign($op_e);
  oel_add_assign($op_f);
  oel_add_assign($op_g);
  oel_add_free($op_a);
  oel_add_free($op_b);
  oel_add_free($op_c);
  oel_add_free($op_d);
  oel_add_free($op_e);
  oel_add_free($op_f);
  oel_add_free($op_g);

  oel_finalize($op_a);
  oel_finalize($op_b);
  oel_finalize($op_c);
  oel_finalize($op_d);
  oel_finalize($op_e);
  oel_finalize($op_f);
  oel_finalize($op_g);

  $expr1= "3435KKHFH";
  $expr2= 53236434;

  oel_execute($op_a);
  oel_execute($op_b);
  oel_execute($op_c);
  oel_execute($op_d);
  oel_execute($op_e);
  oel_execute($op_f);
  oel_execute($op_g);

  var_dump($a, $b, $c, $d, $e, $f, $g);

?>
