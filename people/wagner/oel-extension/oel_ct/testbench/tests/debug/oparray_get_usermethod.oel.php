<?php

  class userclass {
    private function usermethod($a) {
      $a= $b;
      $foo= $baz();
      return $foo;
    }
  }

  var_dump(oel_get_op_array(array('userclass', 'usermethod')));

?>
