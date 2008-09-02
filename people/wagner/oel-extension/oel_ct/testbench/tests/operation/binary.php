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
  $al= 101;
  $am= 101;
  $an= 101;
  $ao= 101;
  $ap= 101;
  $aq= 101;
  $ar= TRUE;

  $ba= $aa | 0x1010;
  $bb= $ab & 0x1010;
  $bc= $ac ^ 0x1010;
  $bd= $ad."lala";
  $be= $ae + 10;
  $bf= $af - 10;
  $bg= $ag * 10;
  $bh= $ah / 10;
  $bi= $ai % 10;
  $bj= $aj << 1;
  $bk= $ak >> 1;
  $bl= $al === 10;
  $bm= $am !== 10;
  $bn= $an == 10;
  $bo= $ao != 10;
  $bp= $ap < 10;
  $bq= $aq <= 10;
  $br= ($ar xor TRUE);

  var_dump(
    $ba,
    $bb,
    $bc,
    $bd,
    $be,
    $bf,
    $bg,
    $bh,
    $bi,
    $bj,
    $bk,
    $bl,
    $bm,
    $bn,
    $bo,
    $bp,
    $bq,
    $br
  );

?>
