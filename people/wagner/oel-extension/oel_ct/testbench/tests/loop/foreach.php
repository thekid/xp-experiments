<?php

  $arr= array(
    "key1" => "value1",
    "key2" => "value2",
    "key3" => "value3",
    "key4" => "value4",
    "key5" => "value5",
  );

  foreach($arr as $value) {
    echo $value; echo " --- \n";
  }

  foreach($arr as $key => $value) {
    echo $key; echo " => "; echo $value; echo " --- \n";
  }

?>
