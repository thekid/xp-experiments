<?php

  $cond= TRUE;
  $a= !$cond;
  var_dump($a);

  $cond= 0xFFFF;
  $a= ~$cond;
  var_dump(0x0F0F | $a);


?>
