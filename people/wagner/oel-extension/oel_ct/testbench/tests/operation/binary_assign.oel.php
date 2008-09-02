<?php

  $op_a= oel_new_op_array();

  oel_push_value($op_a, 0x1010);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "aa");
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_BW_OR);
  oel_add_free($op_a);

  oel_push_value($op_a, 0x1010);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ab");
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_BW_AND);
  oel_add_free($op_a);

  oel_push_value($op_a, 0x1010);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ac");
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_BW_XOR);
  oel_add_free($op_a);

  oel_push_value($op_a, "lala");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ad");
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_CONCAT);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ae");
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_ADD);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "af");
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_SUB);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ag");
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_MUL);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ah");
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_DIV);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ai");
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_MOD);
  oel_add_free($op_a);

  oel_push_value($op_a, 1);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "aj");
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_SHIFTL);
  oel_add_free($op_a);

  oel_push_value($op_a, 1);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ak");
  oel_add_binary_op($op_a, OEL_BINARY_OP_ASSIGN_SHIFTR);
  oel_add_free($op_a);

  oel_finalize($op_a);

  $aa= 0x0101;
  $ab= 0x0101;
  $ac= 0x0101;
  $ad= "bla";
  $ae= 101;
  $af= 101;
  $ag= 101;
  $ah= 101;
  $ai= 101;
  $aj= 101;
  $ak= 101;

  oel_execute($op_a);

  var_dump(
    $aa,
    $ab,
    $ac,
    $ad,
    $ae,
    $af,
    $ag,
    $ah,
    $ai,
    $aj,
    $ak
  );

?>
