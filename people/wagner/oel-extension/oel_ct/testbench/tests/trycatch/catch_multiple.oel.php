<?php

  $op_a= oel_new_op_array();

  oel_add_begin_tryblock($op_a);

  oel_add_begin_variable_parse($op_a);
  oel_push_variable($op_a, "e");
  oel_add_end_variable_parse($op_a);
  oel_add_throw($op_a);

  oel_add_begin_catchblock($op_a);

    oel_add_begin_firstcatch($op_a, "Dog", "d");
    oel_push_value($op_a, '
      var_dump(
        "Phaat, a flying Dog! What\'s your name dog?",
        $d->getMessage()
      );
    ');
    oel_add_eval($op_a);
    oel_add_free($op_a);
    oel_add_end_firstcatch($op_a);

    oel_add_begin_catch($op_a, "Cat", "c");
    oel_push_value($op_a, '
      var_dump(
        "MMMMMMIIIIOOOUUUUU",
        $c->getMessage()
      );
    ');
    oel_add_eval($op_a);
    oel_add_free($op_a);
    oel_add_end_catch($op_a);

    oel_add_begin_catch($op_a, "Elephant", "e");
    oel_push_value($op_a, '
      var_dump(
        "Ey elephant, don\'t you know elephanths can\'t fly",
        $e->getMessage()
      );
    ');
    oel_add_eval($op_a);
    oel_add_free($op_a);
    oel_add_end_catch($op_a);

    oel_add_begin_catch($op_a, "Banana", "b");
    oel_push_value($op_a, '
      var_dump(
        "Ey, who is throwing bananas at me?",
        $b->getMessage()
      );
    ');
    oel_add_eval($op_a);
    oel_add_free($op_a);
    oel_add_end_catch($op_a);

  oel_add_end_catchblock($op_a);

  oel_finalize($op_a);

  class Dog extends Exception {}
  class Cat extends Exception {}
  class Elephant extends Exception {}
  class Banana extends Exception {}

  $e= new Dog("Flying Dog");
  oel_execute($op_a);

  $e= new Cat("LOL, I iz in ur sourz code");
  oel_execute($op_a);

  $e= new Elephant("hm?");
  oel_execute($op_a);

  $e= new Banana("*slap*");
  oel_execute($op_a);

?>
