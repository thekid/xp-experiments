<?php

  $arr= array(
    "key1" => "value1",
    "key2" => "value2",
    "key3" => "value3",
    "key4" => "value4",
    "key5" => "value5",
  );

  var_dump($arr);

  foreach($arr as $key => $value) {
    $value= " --- ";
  }

  var_dump($arr);

?>
