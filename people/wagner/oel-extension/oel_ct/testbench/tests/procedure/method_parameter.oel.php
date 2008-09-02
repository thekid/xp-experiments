<?php

  $op_a= oel_new_op_array();

  oel_add_begin_class_declaration($op_a, "classA");
  $meth_a= oel_new_method($op_a, "funcA");
  oel_add_end_class_declaration($op_a);

  oel_add_receive_arg($meth_a, 1, "a");
  oel_add_begin_variable_parse($meth_a);
  oel_push_variable($meth_a, "a");
  oel_add_end_variable_parse($meth_a);
  oel_add_echo($meth_a);

  oel_finalize($op_a);
  oel_execute($op_a);

  $oA= new classA();
  var_dump($oA->funcA("\na\n\n"));

?>
