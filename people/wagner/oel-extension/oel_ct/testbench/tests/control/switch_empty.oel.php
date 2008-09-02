<?php

  $op_a= oel_new_op_array();

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "cond");
  oel_add_end_variable_parse($op_a);
  oel_add_begin_switch($op_a);
  oel_add_end_switch($op_a);

  oel_finalize($op_a);

  $cond= "wert1";
  oel_execute($op_a);

?>
