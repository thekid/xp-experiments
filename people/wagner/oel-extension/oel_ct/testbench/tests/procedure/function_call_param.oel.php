<?php

  $op_a= oel_new_op_array();
  oel_push_value($op_a, "paramA");
  oel_add_call_function($op_a, 1, "funcA");
  oel_add_free($op_a);

  function funcA($a) { var_dump($a, "called funcA"); }
  oel_finalize($op_a);
  oel_execute($op_a);


  $op_a= oel_new_op_array();
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "b");
  oel_add_end_variable_parse($op_a);
  oel_add_call_function($op_a, 1, "funcB");
  oel_add_free($op_a);

  $b= "paramB";
  function funcB($a) { var_dump($a, "called funcB"); }
  oel_finalize($op_a);
  oel_execute($op_a);


  $op_a= oel_new_op_array();
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "c");
  oel_add_end_variable_parse($op_a);
  oel_add_call_function($op_a, 1, "funcC");
  oel_add_free($op_a);

  $c= "paramC";
  function funcC(&$a) { var_dump($a, "called funcC"); $a= NULL; }
  oel_finalize($op_a);
  oel_execute($op_a);
  var_dump($c);

?>
