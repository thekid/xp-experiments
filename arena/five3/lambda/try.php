<?php
  class Errors extends Exception {
    public function __construct($message, $errors) {
      $message.= ": [\n";
      foreach ($errors as $e) {
        $message.= '  * '.get_class($e).': '.$e->getMessage()."\n";
      }
      parent::__construct($message.']');
    }
  }
  
  class Attempt {
    public static function these() {
      $errors= array();
      foreach (func_get_args() as $block) {
        try {
          return $block();
        } catch (Exception $e) {
          $errors[] = $e;
          continue;
        }
      }
      throw new Errors('None of the attempted functions worked', $errors);
    }
  }

  function tryto(Closure $c) {
    try {
      return $c();
    } catch (Exception $e) {
      return get_class($e).': '.$e->getMessage();
    }
  }
  
  var_dump(tryto(function() {
    return Attempt::these(
      function() { throw new UnderflowException('A'); },
      function() { throw new OverflowException('B'); },
      function() { return TRUE; }
    );
  }));

  var_dump(tryto(function() {
    return Attempt::these(
      function() { throw new UnderflowException('A'); },
      function() { throw new OverflowException('B'); }
    );
  }));
?>
