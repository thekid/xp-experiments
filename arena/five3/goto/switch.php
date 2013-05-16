<?php
  $a= 1;
  switch ($a) {
    case 0: zero: echo '@0->'; goto two;
    case 1: echo '@1->'; goto four;
    case 2: two: echo '@2->'; 
    case 3: echo '@3!'; break;
    case 4: four: echo '@4->'; goto zero;
  }
?>
