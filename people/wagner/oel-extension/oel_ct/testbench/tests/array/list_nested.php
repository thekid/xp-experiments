<?php

  var_dump(list($a, $b, list($c, $d))= array(
    "value1",
    "value2",
    array(
      "value3",
      "value4",
    ),
  ));

  var_dump($a, $b, $c, $d);

?>
