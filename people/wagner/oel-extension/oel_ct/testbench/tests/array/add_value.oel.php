<?php

  $op_a= oel_new_op_array();

  oel_push_value($op_a, "value1");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_push_new_dim($op_a);
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, "value2");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_push_new_dim($op_a);
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, "value3");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_push_value($op_a, "key1");
  oel_push_dim($op_a);
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, "value4");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_push_new_dim($op_a);
  oel_push_new_dim($op_a);
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_finalize($op_a);

  $a= array();
  oel_execute($op_a);

  var_dump($a);

?>
