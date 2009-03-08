<?php

  class userclass {
    private function usermethod($a) {
      $a= $b;
      $foo= $baz();
      return $foo;
    }
  }

  var_dump(oel_export_op_array(array('userclass', 'usermethod')));

?>
