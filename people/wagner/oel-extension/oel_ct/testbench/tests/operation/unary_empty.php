<?php

  $a= 3;
  var_dump(empty($a));
  $a= 0;
  var_dump(empty($a));
  $a= "value";
  var_dump(empty($a));
  $a= "";
  var_dump(empty($a));
  $a= array(1);
  var_dump(empty($a));
  $a= array();
  var_dump(empty($a));
  $a= NULL;
  var_dump(empty($a));

?>
