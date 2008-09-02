<?php

  $expr1= "3435KKHFH";
  $expr2= 53236434;

  $a= (int)$expr1;
  $b= (float)$expr1;
  $c= (string)$expr2;
  $d= (array)$expr1;
  $e= (object)$expr2;
  $f= (bool)$expr1;
  $g= (unset)$expr1;

  var_dump($a, $b, $c, $d, $e, $f, $g);

?>
