<?php
  function __error($code, $msg, $file= NULL, $line= -1) {
    echo '[err#', $code, ']: ', $msg, "\n";
  }
  set_error_handler('__error');

  $op_a= oel_new_op_array();
  oel_push_value($op_a, NULL);
  oel_add_exit($op_a);
  oel_finalize($op_a);

  var_dump("anfang");
  oel_execute($op_a);
  var_dump("ende");

  $op_a= oel_new_op_array();
  oel_push_value($op_a, "lalala");
  oel_add_exit($op_a);
  oel_finalize($op_a);

  var_dump("anfang");
  oel_execute($op_a);
  var_dump("ende");

?>
