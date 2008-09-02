<?php

  $op_a= oel_new_op_array();

  oel_push_value($op_a, "Variable A!\n\n");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "b");
  oel_add_end_variable_parse($op_a);
  oel_add_assign($op_a, TRUE);
  oel_add_free($op_a);

  oel_finalize($op_a);
  oel_execute($op_a);

  var_dump($a, $b);
  $a= 4;
  var_dump($a, $b);
  $b= 7;
  var_dump($a, $b);

?>
