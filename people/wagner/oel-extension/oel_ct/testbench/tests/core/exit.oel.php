<?php

  $op_a= oel_new_op_array();
  oel_add_exit($op_a);
  oel_finalize($op_a);

  var_dump("anfang");
  oel_execute($op_a);
  var_dump("ende");

?>
