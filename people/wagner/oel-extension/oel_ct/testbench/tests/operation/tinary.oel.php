<?php

  $op_a= oel_new_op_array();
  $op_b= oel_new_op_array();

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "cond");
  oel_add_end_variable_parse($op_a);
  oel_add_begin_tinary_op($op_a);
  oel_push_value($op_a, "Zweig 1");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_assign($op_a);
  oel_add_tinary_op_true($op_a);
  oel_push_value($op_a, "Zweig 2");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_assign($op_a);
  oel_add_tinary_op_false($op_a);
  oel_add_free($op_a);

  oel_add_begin_variable_parse($op_b);
  oel_push_variable($op_b, "cond");
  oel_add_end_variable_parse($op_b);
  oel_add_begin_tinary_op($op_b);
  oel_push_value($op_b, "Zweig 1");
  oel_add_tinary_op_true($op_b);
  oel_push_value($op_b, "Zweig 2");
  oel_add_tinary_op_false($op_b);
  oel_add_begin_variable_parse($op_b);
  oel_push_variable($op_b, "a");
  oel_add_assign($op_b);
  oel_add_free($op_b);

  oel_finalize($op_a);
  oel_finalize($op_b);

  $cond= TRUE;
  $a= "orig";
  oel_execute($op_a);
  var_dump($a);

  $cond= FALSE;
  $a= "orig";
  oel_execute($op_a);
  var_dump($a);

  $cond= TRUE;
  oel_execute($op_b);
  var_dump($a);

  $cond= FALSE;
  oel_execute($op_b);
  var_dump($a);


?>
