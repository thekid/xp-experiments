<?php

  $op_a= oel_new_op_array();
  oel_push_value($op_a, "paramA");
  oel_push_value($op_a, "paramB");
  oel_add_call_function($op_a, 2, "funcA");
  oel_add_free($op_a);

  function funcA($a, $b) { var_dump($a, $b); }
  oel_finalize($op_a);
  oel_execute($op_a);

?>
