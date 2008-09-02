<?php

  $a= "Variable A!\n\n";
  $b= &$a;

  var_dump($a, $b);
  $a= 4;
  var_dump($a, $b);
  $b= 7;
  var_dump($a, $b);

?>
