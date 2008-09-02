<?php

define("constA", "contA\n\n");

  $op_a= oel_new_op_array();

  // $a= "Variable A!\n\n"
  oel_push_value($op_a, "Variable A!\n\n");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  // $c= $b= $a
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "b");

  oel_add_end_variable_parse($op_a);
  oel_add_assign($op_a);

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "c");

  oel_add_assign($op_a);
  oel_add_free($op_a);

  // $d= constA;
  oel_push_constant($op_a, "constA");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "d");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_finalize($op_a);
  oel_execute($op_a);

  var_dump($a, $b, $c, $d);

?>
