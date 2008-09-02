<?php
  $op_a= oel_new_op_array();
  $op_b= oel_new_op_array();

  oel_push_value($op_a, "-op array A schreit: _HALLO!_ \n\n");
  oel_push_value($op_b, "-op array B flüstert: *hallo* \n\n");
  oel_add_echo($op_a);
  oel_add_echo($op_b);

  oel_push_value($op_b, FALSE);
  oel_add_return($op_b);

  oel_finalize($op_a);
  oel_finalize($op_b);

  var_dump(oel_execute($op_a));
  var_dump(oel_execute($op_b));

?>
