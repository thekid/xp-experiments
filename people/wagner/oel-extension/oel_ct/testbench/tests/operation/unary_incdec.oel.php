<?php

  $op_a= oel_new_op_array();
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "a");
  oel_add_incdec_op($op_a, OEL_OP_POST_INC);
  oel_add_return($op_a);
  oel_finalize($op_a);

  $op_b= oel_new_op_array();
  oel_add_begin_variable_parse($op_b);
  oel_push_variable($op_b, "a");
  oel_add_incdec_op($op_b, OEL_OP_POST_DEC);
  oel_add_return($op_b);
  oel_finalize($op_b);

  $op_c= oel_new_op_array();
  oel_add_begin_variable_parse($op_c);
  oel_push_variable($op_c, "a");
  oel_add_incdec_op($op_c, OEL_OP_PRE_INC);
  oel_add_return($op_c);
  oel_finalize($op_c);

  $op_d= oel_new_op_array();
  oel_add_begin_variable_parse($op_d);
  oel_push_variable($op_d, "a");
  oel_add_incdec_op($op_d, OEL_OP_PRE_DEC);
  oel_add_return($op_d);
  oel_finalize($op_d);

  $a= 100;

  var_dump(oel_execute($op_a));
  var_dump(oel_execute($op_a));
  var_dump(oel_execute($op_c));
  var_dump(oel_execute($op_c));

  var_dump($a);

  var_dump(oel_execute($op_b));
  var_dump(oel_execute($op_b));
  var_dump(oel_execute($op_d));
  var_dump(oel_execute($op_d));

  var_dump($a);

?>
