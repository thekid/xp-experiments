<?php

  $op_a= oel_new_op_array();
  oel_add_call_function($op_a, 0, "funcA");
  oel_add_free($op_a);

  function funcA() { var_dump("called funcA"); }

  oel_finalize($op_a);
  oel_execute($op_a);

?>
