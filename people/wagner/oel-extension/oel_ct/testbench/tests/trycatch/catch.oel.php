<?php

  $op_a= oel_new_op_array();

  oel_add_begin_tryblock($op_a);

  oel_push_value($op_a, "exeptA");
  oel_add_new_object($op_a, 1, "Exception");
  oel_add_throw($op_a);

  oel_add_begin_catchblock($op_a);
    oel_add_begin_firstcatch($op_a, "Exception", "e");

    oel_push_value($op_a, '
      $trace= $e->getTrace();
      var_dump(
        dirname($trace[0]["file"]),
        $e->getMessage()
      );
    ');
    oel_add_eval($op_a);
    oel_add_free($op_a);

    oel_add_end_firstcatch($op_a);
  oel_add_end_catchblock($op_a);

  oel_finalize($op_a);

  try {
    oel_execute($op_a);
  } catch (Exception $e) {
    $trace= $e->getTrace();
    var_dump(
      dirname($trace[0]["file"]),
      $e->getMessage()
    );
  }

?>
