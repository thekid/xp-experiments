<?php
  function repeat($times, $block) {
    for ($i= 0; $i < $times; $i++) $block();
  }
  
  $i= 0;
  repeat(5, function() use(&$i) { echo 'Hello['.(++$i).']'; });
?>
