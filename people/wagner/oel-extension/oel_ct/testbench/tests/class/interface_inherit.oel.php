<?php

  $op_a= oel_new_op_array();

  oel_add_begin_interface_declaration($op_a, "A");
  oel_add_end_interface_declaration($op_a);

  oel_add_begin_interface_declaration($op_a, "B");
  oel_add_end_interface_declaration($op_a);

  oel_add_begin_interface_declaration($op_a, "C");
  oel_add_implements_interface($op_a, "A");
  oel_add_implements_interface($op_a, "B");
  oel_add_end_interface_declaration($op_a);

  oel_finalize($op_a);
  oel_execute($op_a);

?>
