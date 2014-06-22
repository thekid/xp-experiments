<?php
use lang\Type;

class Signature extends \lang\Object {
  protected $types= [];

  public function __construct($types) {
    $this->types= $types;
  }

  protected static function newType($name) {
    if (2 === sscanf($name, 'function(%[^)]): %s', $params, $return)) {
      return new FunctionType(self::parse($params)->types, self::newType($return));
    } else {
      return Type::forName($name);
    }
  }

  public static function parse($input) {
    for ($args= $input.',', $o= 0, $brackets= 0, $i= 0, $s= strlen($args); $i < $s; $i++) {
      if (',' === $args{$i} && 0 === $brackets) {
        $types[]= self::newType(ltrim(substr($args, $o, $i - $o)));
        $o= $i+ 1;
      } else if ('<' === $args{$i}) {
        $brackets++;
      } else if ('>' === $args{$i}) {
        $brackets--;
      }
    }
    return new self($types);
  }

  public function matches($args) {
    foreach ($this->types as $i => $type) {
      // \util\cmd\Console::writeLine('Verify #', $i, ': ', $type, ' -> ', $type->isInstance($args[$i]));
      if (!$type->isInstance($args[$i])) return false;
    }
    return true;
  }
}