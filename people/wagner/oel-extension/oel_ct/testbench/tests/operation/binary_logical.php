<?php

  $a= "untouched";
  $cond1= TRUE;
  $cond1 and ($a= "touched");
  var_dump($cond1, $a);

  $a= "untouched";
  $cond1= TRUE;
  $cond1 or ($a= "touched");
  var_dump($cond1, $a);

  $a= "untouched";
  $cond1= FALSE;
  $cond1 and ($a= "touched");
  var_dump($cond1, $a);

  $a= "untouched";
  $cond1= FALSE;
  $cond1 or ($a= "touched");
  var_dump($cond1, $a);

  $a= TRUE;
  $b= FALSE;
  $c= ($a and $b);
  var_dump($c);

  $a= TRUE;
  $b= FALSE;
  $c= ($a or $b);
  var_dump($c);

  $a= TRUE;
  $b= TRUE;
  $c= ($a and $b);
  var_dump($c);

  $a= FALSE;
  $b= FALSE;
  $c= ($a or $b);
  var_dump($c);

?>
