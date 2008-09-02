<?php

  $op_a= oel_new_op_array();

  oel_add_begin_interface_declaration($op_a, "IClassA");
  oel_add_end_interface_declaration($op_a);

  oel_add_begin_class_declaration($op_a, "ClassA");
  oel_add_implements_interface($op_a, "IClassA");
  oel_add_end_class_declaration($op_a);

  oel_finalize($op_a);
  oel_execute($op_a);

  $i= new ReflectionClass("IClassA");
  $c= new ReflectionClass("ClassA");

  var_dump(
    $i->isInterface(),
    $c->implementsInterface("IClassA")
  );

?>
