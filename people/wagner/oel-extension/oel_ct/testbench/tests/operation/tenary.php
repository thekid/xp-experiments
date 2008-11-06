<?php

  $cond= TRUE;
  $a= "orig";
  $cond ? $a= "Zweig 1" : $a= "Zweig 2";
  var_dump($a);

  $cond= FALSE;
  $a= "orig";
  $cond ? $a= "Zweig 1" : $a= "Zweig 2";
  var_dump($a);

  $cond= TRUE;
  $a= $cond ? "Zweig 1" : "Zweig 2";
  var_dump($a);

  $cond= FALSE;
  $a= $cond ? "Zweig 1" : "Zweig 2";
  var_dump($a);

?>
