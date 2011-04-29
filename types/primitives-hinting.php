<?php
  require('impl.php');

  class Printer {
    public function println(string $s) {
      echo $s, "\n";
    }

    public function dump(array $a, int $indent) {
      $prefix= str_repeat(' ', $indent);
      echo 'array [', "\n";
      foreach ($a as $k => $v) {
        echo $prefix, $k, ' => ', $v, "\n";
      }
      echo ']', "\n";
    }
  }
  
  // {{{ main
  $p= new Printer();
  $p->println('Hello');
  $p->dump(array(1, 2, 3), 2);
  
  try {
    $p->println(array());
  } catch (InvalidArgumentException $expected) {
    echo 'Caught expected ', $expected->getMessage(), "\n";
  }

  try {
    $p->dump(array(1, 2, 3), '2');
  } catch (InvalidArgumentException $expected) {
    echo 'Caught expected ', $expected->getMessage(), "\n";
  }
  // }}}
?>
