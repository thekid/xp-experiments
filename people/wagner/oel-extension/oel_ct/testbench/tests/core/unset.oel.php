<?php

  $op_a= oel_new_op_array();

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, 'a');
  oel_add_unset($op_a);

  oel_finalize($op_a);
  
  var_dump(isset($a));
  $a= "value";
  var_dump(isset($a));
  oel_execute($op_a);
  var_dump(isset($a));

?>
