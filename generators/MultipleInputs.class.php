<?php
  /**
   * Processes multiple inputs in parallel
   */
  class MultipleInputs extends Object {

    protected static function numbers($start, $max) {
      for ($i= $start; $i < $max; $i+= 2) {
        yield $i;
      }
    }

    protected static function odd($max) {
      return self::numbers(1, $max);
    }

    protected static function even($max) {
      return self::numbers(0, $max);
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