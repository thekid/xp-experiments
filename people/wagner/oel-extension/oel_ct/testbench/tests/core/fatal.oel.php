<?php
  function __error($code, $msg, $file= NULL, $line= -1) {
    echo '[err#', $code, ']: ', $msg, "\n";
  }
  set_error_handler('__error');

  $op_a= oel_new_op_array();
  oel_add_call_function($op_a, 0, "nonExistantFunction");
  oel_add_free($op_a);

  oel_finalize($op_a);

  var_dump("anfang");
  ob_start();
  oel_execute($op_a);
  ob_end_clean();       // Swallow real fatal
  __error(E_WARNING, 'Op array execution was ended by fatal error');
  var_dump("ende");
?>
