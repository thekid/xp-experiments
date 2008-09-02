<?php

  $op_a= oel_new_op_array();

  oel_push_value($op_a, 0x1010);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "aa");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_BW_OR);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ba");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 0x1010);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ab");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_BW_AND);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bb");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 0x1010);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ac");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_BW_XOR);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bc");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, "lala");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ad");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_CONCAT);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bd");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ae");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_ADD);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "be");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "af");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_SUB);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bf");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ag");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_MUL);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bg");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ah");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_DIV);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bh");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ai");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_MOD);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bi");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 1);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "aj");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_SHIFTL);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bj");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 1);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ak");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_SHIFTR);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bk");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "al");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_IS_IDENTICAL);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bl");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "am");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_IS_NOT_IDENTICAL);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bm");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "an");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_IS_EQUAL);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bn");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ao");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_IS_NOT_EQUAL);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bo");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ap");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_IS_SMALLER);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bp");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, 10);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "aq");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_IS_SMALLER_OR_EQUAL);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "bq");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_push_value($op_a, TRUE);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "ar");
  oel_add_end_variable_parse($op_a);
  oel_add_binary_op($op_a, OEL_BINARY_OP_BOOL_XOR);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "br");
  oel_add_assign($op_a);
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
  $al= 101;
  $am= 101;
  $an= 101;
  $ao= 101;
  $ap= 101;
  $aq= 101;
  $ar= TRUE;

  oel_execute($op_a);

  var_dump(
    $ba,
    $bb,
    $bc,
    $bd,
    $be,
    $bf,
    $bg,
    $bh,
    $bi,
    $bj,
    $bk,
    $bl,
    $bm,
    $bn,
    $bo,
    $bp,
    $bq,
    $br
  );

?>
