<?php
  require('impl.php');

  class HintedPrinter {
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

  class Printer {
    public function println($s) {
      echo $s, "\n";
    }

    public function dump($a, $indent) {
      $prefix= str_repeat(' ', $indent);
      echo 'array [', "\n";
      foreach ($a as $k => $v) {
        echo $prefix, $k, ' => ', $v, "\n";
      }
      echo ']', "\n";
    }
  }

  class CheckingPrinter {
    public function println($s) {
      if (!is_string($s)) throw new InvalidArgumentException('s: Not a string');
      
      echo $s, "\n";
    }

    public function dump($a, $indent) {
      if (!is_array($a)) throw new InvalidArgumentException('a: Not an array');
      if (!is_int($indent)) throw new InvalidArgumentException('indent: Not an int');

      $prefix= str_repeat(' ', $indent);
      echo 'array [', "\n";
      foreach ($a as $k => $v) {
        echo $prefix, $k, ' => ', $v, "\n";
      }
      echo ']', "\n";
    }
  }
  
  class DelegatingPrinter {
    protected static $__signature= array(
      'println' => array('string'),
      'dump'    => array('array', 'integer')
    );

    public function ·println($s) {
      echo $s, "\n";
    }

    public function ·dump($a, $indent) {
      $prefix= str_repeat(' ', $indent);
      echo 'array [', "\n";
      foreach ($a as $k => $v) {
        echo $prefix, $k, ' => ', $v, "\n";
      }
      echo ']', "\n";
    }
    
    public function __call($name, $args) {
      foreach (self::$__signature[$name] as $i => $type) {
        if ($type !== gettype($args[$i])) {
          throw new InvalidArgumentException('Type mismatch @ '.$name.'#'.$i);
        }
      }
      return call_user_func_array(array($this, '·'.$name), $args);
    }
  }

  $times= isset($argv[1]) ? (int)$argv[1] : 10000;
  $implementations= array(
    new Printer(), 
    new HintedPrinter(),
    new CheckingPrinter(),
    new DelegatingPrinter()
  );
  
  print("== Success case ==\n");
  foreach ($implementations as $printer) {
    ob_start();
    $s= microtime(TRUE);
    for ($i= 0; $i < $times; $i++) {
      $printer->println('Hello');
      $printer->dump(array(1, 2, 3), 2);
    }
    $e= microtime(TRUE);
    ob_end_clean();
    
    printf("%-20s: %.3f seconds for %d runs\n", get_class($printer), $e- $s, $i);
  }

  print("== Fail case ==\n");
  foreach ($implementations as $printer) {
    ob_start();
    $s= microtime(TRUE);
    for ($i= 0; $i < $times; $i++) {
      try {
        $printer->println(NULL);
      } catch (InvalidArgumentException $expected) {
        // OK
      }
      try {
        $printer->dump(array(1, 2, 3), "2");
      } catch (InvalidArgumentException $expected) {
        // OK
      }
    }
    $e= microtime(TRUE);
    ob_end_clean();
    
    printf("%-20s: %.3f seconds for %d runs\n", get_class($printer), $e- $s, $i);
  }
?>
