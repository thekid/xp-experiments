<?php

define("constA", "contA\n\n");

$a= "Variable A!\n\n";
$c= $b= $a;
$d= constA;

var_dump($a, $b, $c, $d);


?>
