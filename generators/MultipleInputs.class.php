<?php
  /**
   * Processes multiple inputs in parallel
   */
  class MultipleInputs extends Object {

    protected static function range($start, $end, $step= 1) {
      for ($i= $start; $i < $end; $i+= $step) {
        yield $i;
      }
    }

    protected static function odd($max) {
      return self::range(1, $max, 2);
    }

    protected static function even($max) {
      return self::range(0, $max, 2);
    }

    protected static function all() {
      $generators= func_get_args();
      do {
        foreach ($generators as $i => $generator) {
          yield $generator->current();
          $generator->next();
          if (!$generator->valid()) unset($generators[$i]);
        }
      } while ($generators);
    }

    public static function main(array $args) {
      foreach (self::all(self::even(10), self::odd(10)) as $number) {
        Console::writeLine($number); 
      }
    }
  }
?>