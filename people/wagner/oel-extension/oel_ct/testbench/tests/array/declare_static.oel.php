<?php

  $op_a= oel_new_op_array();
  oel_add_begin_class_declaration($op_a, "classA");

  oel_add_declare_property($op_a, "a", array(
    "key1" => "value1",
  ));

  oel_add_end_class_declaration($op_a);
  oel_finalize($op_a);
  oel_execute($op_a);

  var_dump(new classA());

?>
