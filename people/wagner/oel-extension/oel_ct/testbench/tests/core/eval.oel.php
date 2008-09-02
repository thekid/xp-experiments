<?php

  $op_a= oel_new_op_array();

  oel_push_value($op_a, '
    $a= 12454;
    var_dump($a);
    return "string_value";
  ');
  oel_add_eval($op_a);
  oel_add_call_function($op_a, 1, "var_dump");
  oel_add_free($op_a);

  oel_finalize($op_a);
  oel_execute($op_a);

?>
