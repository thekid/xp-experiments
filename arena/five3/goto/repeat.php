<?php
  $i= 0;
  repeat: {
    echo $i;
  } if (++$i < 10) goto repeat;
?>
