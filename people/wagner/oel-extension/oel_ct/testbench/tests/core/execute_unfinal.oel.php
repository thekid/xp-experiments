<?php

  $op_a= oel_new_op_array();

  oel_push_value($op_a, TRUE);
  oel_add_return($op_a);

  var_dump(oel_execute($op_a));

  oel_finalize($op_a);
  var_dump(oel_execute($op_a));

?>
