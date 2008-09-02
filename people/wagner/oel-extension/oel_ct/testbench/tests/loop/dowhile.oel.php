<?php

  $op_a= oel_new_op_array();

  oel_add_begin_dowhile($op_a);
    oel_add_begin_variable_parse($op_a);
    oel_push_variable($op_a, "counter");
    oel_add_end_variable_parse($op_a);
    oel_add_echo($op_a);
  oel_add_end_dowhile_body($op_a);
    oel_add_begin_variable_parse($op_a);
    oel_push_variable($op_a, "counter");
    oel_add_incdec_op($op_a, OEL_OP_POST_DEC);
  oel_add_end_dowhile($op_a);

  oel_finalize($op_a);

  $counter= 10;
  oel_execute($op_a);

  $counter= 0;
  oel_execute($op_a);

?>
