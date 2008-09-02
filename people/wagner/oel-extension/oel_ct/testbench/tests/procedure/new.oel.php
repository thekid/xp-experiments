<?php

  $op_a= oel_new_op_array();
  oel_add_begin_variable_parse($op_a);
  oel_add_new_object($op_a, 0, "classA");
  oel_push_variable($op_a, "oA1");
  oel_add_assign($op_a);
  oel_add_free($op_a);
  oel_finalize($op_a);

  class classA {}

  oel_execute($op_a);
  var_dump($oA1);

?>
