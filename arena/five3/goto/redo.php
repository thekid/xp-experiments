<?php
  $j= FALSE;
  redo: for ($i= 0; $i < 10; $i++) {
    if (5 == $i && !$j) {
      $j= TRUE;
      goto redo;
    }
    echo $i;
  }
?>
