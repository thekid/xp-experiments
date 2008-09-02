<?php

  $op_a= oel_new_op_array();

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "cond");
  oel_add_end_variable_parse($op_a);
  oel_add_begin_if($op_a);

    oel_push_value($op_a, "Zweig 1");
    oel_add_begin_variable_parse($op_a);
    oel_push_variable($op_a, "a");
    oel_add_assign($op_a);
    oel_add_free($op_a);

  oel_add_end_if($op_a);
  oel_add_end_else($op_a);

  oel_finalize($op_a);

  $a=    NULL;

  $cond= TRUE;
  oel_execute($op_a);
  var_dump($a);

  $cond= FALSE;
  oel_execute($op_a);
  var_dump($a);

?>
