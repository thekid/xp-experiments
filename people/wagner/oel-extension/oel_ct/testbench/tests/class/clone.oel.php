<?php

  $op_a= oel_new_op_array();
  oel_add_new_object($op_a, 0, "classA");
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "oA1");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "oA1");
  oel_add_end_variable_parse($op_a);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "oA2");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "oA1");
  oel_add_end_variable_parse($op_a);
  oel_add_clone($op_a);
  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "oA3");
  oel_add_assign($op_a);
  oel_add_free($op_a);

  oel_finalize($op_a);

  class classA {
    public $propA= NULL;
  }

  oel_execute($op_a);

  var_dump(
    $oA1,
    $oA2,
    $oA3
  );

  $oA1->propA= 1;
  $oA2->propA= 2;
  $oA3->propA= 3;

  var_dump(
    $oA1,
    $oA2,
    $oA3
  );


?>
