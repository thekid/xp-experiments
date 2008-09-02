<?php

  var_dump(
    interface_exists("IClassA"),
    class_exists("AClassA"),
    class_exists("ClassA")
  );

  $op_a= oel_new_op_array();

  oel_add_begin_interface_declaration($op_a, "IClassA");
  oel_add_end_interface_declaration($op_a);

  oel_add_begin_abstract_class_declaration($op_a, "AClassA");
  oel_add_end_abstract_class_declaration($op_a);

  oel_add_begin_class_declaration($op_a, "ClassA");
  oel_add_end_class_declaration($op_a);

  var_dump(
    interface_exists("IClassA"),
    class_exists("AClassA"),
    class_exists("ClassA")
  );

  oel_finalize($op_a);
  oel_execute($op_a);

  var_dump(
    interface_exists("IClassA"),
    class_exists("AClassA"),
    class_exists("ClassA")
  );

  $i= new ReflectionClass("IClassA");
  $a= new ReflectionClass("AClassA");

  var_dump(
    $i->isInterface(),
    $a->isAbstract()
  );

?>
