<?php
  class Methods extends Object {

    static function __static() {
      xp::extensions(__CLASS__, $scope= __CLASS__);
    }

    protected static function methodsWith(XPClass $self, $annotation) {
      $name= substr($annotation, 1);
      foreach ($self->getMethods() as $method) {
        if ($method->hasAnnotation($name)) yield $method;
      }
    }

    public static function main(array $args) {
      foreach (XPClass::forName($args[0])->methodsWith('@test') as $method) {
        Console::writeLine($method);
      }
    }
  }
?>