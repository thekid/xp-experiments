<?php

$op_a= oel_new_op_array();

$func_a= oel_new_function($op_a, "funcA");
$func_b= oel_new_function($op_a, "funcB");
$func_c= oel_new_function($op_a, "funcC");

oel_push_value($func_a, 1);
oel_add_return($func_a);
oel_push_value($func_b, "a");
oel_add_return($func_b);
oel_push_value($func_c, FALSE);
oel_add_return($func_c);

oel_finalize($op_a);
oel_execute($op_a);

var_dump(
  funcA(),
  funcB(),
  funcC()
);

?>
