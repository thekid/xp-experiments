<?php

  $op_a= oel_new_op_array();

  $op_b= oel_new_function($op_a, "funcA", TRUE);
  oel_add_static_variable($op_b, "a", NULL);
  oel_add_begin_variable_parse($op_b);
  oel_push_variable($op_b, "a");
  oel_add_return($op_b);

  oel_add_call_function($op_a, 0, "funcA");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "b");
  oel_add_assign($op_a, TRUE);
  oel_add_free($op_a);

  oel_finalize($op_a);
  oel_execute($op_a);
  var_dump($b);
  $b= 3.4;
  var_dump(funcA());

  $b= funcA();
  var_dump($b);
  $b= 4.9;
  var_dump(funcA());

?>
