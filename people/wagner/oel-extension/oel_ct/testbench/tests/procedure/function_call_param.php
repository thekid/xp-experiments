<?php

  function funcA($a) { var_dump($a, "called funcA"); }
  funcA("paramA");


  $b= "paramB";
  function funcB($a) { var_dump($a, "called funcB"); }
  funcB($b);


  $c= "paramC";
  function funcC(&$a) { var_dump($a, "called funcC"); $a= NULL; }
  funcC($c);
  var_dump($c);

?>
