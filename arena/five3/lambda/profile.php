<?php
  function profile($block) {
    $s= microtime(TRUE);
    $block();
    printf("%.3f seconds\n", microtime(TRUE) - $s);
  }
  
  
  profile(function() {
    usleep(rand(0, 500) * 1000);
  });
?>
