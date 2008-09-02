<?php

$op_a= oel_new_op_array();

oel_add_begin_class_declaration($op_a, "classA");
$meth_a= oel_new_method($op_a, "funcA");
$meth_b= oel_new_method($op_a, "funcB");
$meth_c= oel_new_method($op_a, "funcC");
oel_add_end_class_declaration($op_a);

oel_push_value($meth_a, 1);
oel_add_return($meth_a);
oel_push_value($meth_b, "a");
oel_add_return($meth_b);
oel_push_value($meth_c, FALSE);
oel_add_return($meth_c);

oel_finalize($op_a);
oel_execute($op_a);

$oA= new classA();
var_dump(
  $oA->funcA(),
  $oA->funcB(),
  $oA->funcC()
);


?>
