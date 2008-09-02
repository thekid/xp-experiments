<?php

  $op_a= oel_new_op_array();

  oel_add_begin_list($op_a);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_list_element($op_a);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "b");
  oel_add_list_element($op_a);
  oel_push_value($op_a, array(
    "value1",
    "value2",
  ));
  oel_add_end_list($op_a);
  oel_add_call_function($op_a, 1, "var_dump");
  oel_add_free($op_a);

  oel_finalize($op_a);
  oel_execute($op_a);

  var_dump($a, $b);

?>
