<?php

  $op_a= oel_new_op_array();
  oel_set_source_file($op_a, "Testfile.wll");

  oel_add_call_function($op_a, 0, "undefined_function");
  oel_add_free($op_a);

  oel_finalize($op_a);
  oel_execute($op_a);

?>
