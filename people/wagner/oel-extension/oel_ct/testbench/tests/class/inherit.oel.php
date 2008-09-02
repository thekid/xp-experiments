<?php

  $op_a= oel_new_op_array();

  oel_add_begin_abstract_class_declaration($op_a, "AClassA");
  oel_add_end_abstract_class_declaration($op_a);

  oel_add_begin_class_declaration($op_a, "ClassA", "AClassA");
  oel_add_end_class_declaration($op_a);

  oel_finalize($op_a);
  oel_execute($op_a);

  $a= new ClassA();
  $c= new ReflectionClass("ClassA");

  var_dump(
    $c->isInstance(new ReflectionClass("AClassA")),
    $a instanceof AClassA
  );

?>
