<?php

  $op_a= oel_new_op_array();

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "cond");
  oel_add_end_variable_parse($op_a);
  oel_add_begin_switch($op_a);

  oel_push_value($op_a, "wert1");
  oel_add_begin_case($op_a);
  oel_push_value($op_a, "wert1\n");
  oel_add_echo($op_a);
  oel_add_end_case($op_a);

  oel_push_value($op_a, "wert2");
  oel_add_begin_case($op_a);
  oel_push_value($op_a, "wert2\n");
  oel_add_echo($op_a);
  oel_add_end_case($op_a);

  oel_push_value($op_a, "wert3");
  oel_add_begin_case($op_a);
  oel_push_value($op_a, "wert3\n");
  oel_add_echo($op_a);
  oel_add_end_case($op_a);

  oel_add_begin_default($op_a);
  oel_push_value($op_a, "default\n");
  oel_add_echo($op_a);
  oel_add_end_default($op_a);

  oel_add_end_switch($op_a);

  oel_finalize($op_a);

  $cond= "wert1";
  oel_execute($op_a);

  $cond= "wert2";
  oel_execute($op_a);

  $cond= "wert3";
  oel_execute($op_a);

?>
