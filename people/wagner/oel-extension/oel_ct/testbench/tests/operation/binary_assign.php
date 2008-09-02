<?php

  $aa= 0x0101;
  $ab= 0x0101;
  $ac= 0x0101;
  $ad= "bla";
  $ae= 101;
  $af= 101;
  $ag= 101;
  $ah= 101;
  $ai= 101;
  $aj= 101;
  $ak= 101;

  $aa|=  0x1010;
  $ab&=  0x1010;
  $ac^=  0x1010;
  $ad.=  "lala";
  $ae+=  10;
  $af-=  10;
  $ag*=  10;
  $ah/=  10;
  $ai%=  10;
  $aj<<= 1;
  $ak>>= 1;

  var_dump(
    $aa,
    $ab,
    $ac,
    $ad,
    $ae,
    $af,
    $ag,
    $ah,
    $ai,
    $aj,
    $ak
  );

?>
