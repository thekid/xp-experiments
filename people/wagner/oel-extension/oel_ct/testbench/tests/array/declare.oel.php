<?php

  $op_a= oel_new_op_array();

  oel_add_begin_array_init($op_a);
  oel_add_end_array_init($op_a);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_add_begin_array_init($op_a);
    oel_push_value($op_a, "value1");
    oel_add_array_init_element($op_a);
  oel_add_end_array_init($op_a);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "b");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_add_begin_array_init($op_a);
    oel_push_value($op_a, "key");
    oel_push_value($op_a, "value1");
    oel_add_array_init_key_element($op_a);
  oel_add_end_array_init($op_a);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "c");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_add_begin_array_init($op_a);
    oel_push_value($op_a, "key");
    oel_push_value($op_a, "value1");
    oel_add_array_init_key_element($op_a);
    oel_push_value($op_a, "value2");
    oel_add_array_init_element($op_a);
  oel_add_end_array_init($op_a);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "d");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_finalize($op_a);
  oel_execute($op_a);

  var_dump($a, $b, $c, $d);

?>
