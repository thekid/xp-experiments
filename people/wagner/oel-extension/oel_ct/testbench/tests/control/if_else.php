<?php

  $a= NULL;

  $cond= TRUE;
  if ($cond) $a= "Zweig 1";
  else       $a= "Zweig 2";
  var_dump($a);

  $cond= FALSE;
  if ($cond) $a= "Zweig 1";
  else       $a= "Zweig 2";
  var_dump($a);

?>
