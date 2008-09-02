<?php

  $op_a= oel_new_op_array();

  oel_add_begin_while($op_a);
    oel_add_begin_variable_parse($op_a);
    oel_push_variable($op_a, "counter");
    oel_add_incdec_op($op_a, OEL_OP_POST_DEC);
  oel_add_begin_while_body($op_a);
    oel_push_value($op_a, 4);
    oel_add_begin_variable_parse($op_a);
    oel_push_variable($op_a, "counter");
    oel_add_end_variable_parse($op_a);
    oel_add_binary_op($op_a, OEL_BINARY_OP_IS_EQUAL);
    oel_add_begin_if($op_a);
    oel_add_continue($op_a);
    oel_add_end_if($op_a);
    oel_add_end_else($op_a);

    oel_add_begin_variable_parse($op_a);
    oel_push_variable($op_a, "counter");
    oel_add_end_variable_parse($op_a);
    oel_add_echo($op_a);
  oel_add_end_while($op_a);

  oel_finalize($op_a);

  $counter= 10;
  oel_execute($op_a);

?>
