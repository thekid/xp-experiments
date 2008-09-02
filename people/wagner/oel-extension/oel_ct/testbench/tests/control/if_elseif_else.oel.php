<?php

  $op_a= oel_new_op_array();


  oel_push_value($op_a, 1);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "cond");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_IS_EQUAL);
  oel_add_begin_if($op_a);

    oel_push_value($op_a, "Zweig 1");
    oel_add_begin_variable_parse($op_a);
    oel_push_variable($op_a, "a");
    oel_add_assign($op_a);
    oel_add_free($op_a);

  oel_add_end_if($op_a);
  oel_push_value($op_a, 2);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "cond");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_IS_EQUAL);
  oel_add_begin_elseif($op_a);

    oel_push_value($op_a, "Zweig 2");
    oel_add_begin_variable_parse($op_a);
    oel_push_variable($op_a, "a");
    oel_add_assign($op_a);
    oel_add_free($op_a);

  oel_add_end_elseif($op_a);

    oel_push_value($op_a, "Zweig 3");
    oel_add_begin_variable_parse($op_a);
    oel_push_variable($op_a, "a");
    oel_add_assign($op_a);
    oel_add_free($op_a);

  oel_add_end_else($op_a);

  oel_finalize($op_a);


  $cond= 1;
  $a= NULL;
  oel_execute($op_a);
  var_dump($a);

  $cond= 2;
  $a= NULL;
  oel_execute($op_a);
  var_dump($a);

  $cond= 3;
  $a= NULL;
  oel_execute($op_a);
  var_dump($a);


?>
