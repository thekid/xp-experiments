<?php
  // TODO: Move invoke() to lang.base.php
  function invoke($spec) {
    $args= func_get_args();
    $p= strpos($spec, '<');
    $args[0]= Type::forName(substr($spec, $p+ 1, -1));
    return call_user_func_array(substr($spec, 0, $p).'··T', $args);
  }

  class Invoke extends Object {

    // Syntax: <NAME>··T(Type $T[, <ARGS**>])
    public static function execute··T(Type $T, $payload) {
      if ($T instanceof XPClass) {
        $t= NULL === $payload ? NULL : $T->newInstance(unserialize($payload));
      } else if ($T instanceof MapType) {
        $t= NULL === $payload ? array() : (array)unserialize($payload);
      } else if ($T instanceof ArrayType) {
        $t= NULL === $payload ? array() : (array)unserialize($payload);
      } else if ($T instanceof Primitive::$INT) {
        $t= NULL === $payload ? 0 : (int)unserialize($payload);
      } else if ($T instanceof Primitive::$STRING) {
        $t= NULL === $payload ? '' : (string)unserialize($payload);
      } else if ($T instanceof Primitive::$BOOL) {
        $t= NULL === $payload ? FALSE : (bool)unserialize($payload);
      } else if ($T instanceof Primitive::$DOUBLE) {
        $t= NULL === $payload ? 0.0 : (double)unserialize($payload);
      } else {
        throw new IllegalArgumentException('Cannot deserialize to '.xp::stringOf($T));
      }
      return $t;
    }
  
    public static function main(array $args) {
      Console::writeLine(invoke('Invoke::execute<int>', 'i:1;'));
      Console::writeLine(invoke('Invoke::execute<int>', NULL));

      Console::writeLine(invoke('Invoke::execute<lang.types.Integer>', 'i:1;'));
      Console::writeLine(invoke('Invoke::execute<lang.types.Integer>', NULL));
    }
  }
?>
