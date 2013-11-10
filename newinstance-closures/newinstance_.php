<?php
function newinstance_($intf, $args, $def) {
  static $uniq= 0;

  $uniq++;
  $src= 'class NewInstance_'.$uniq.' extends \lang\Object implements '.\lang\XPClass::forName($intf)->literal().' { static $def; ';
  foreach ($def as $name => $function) {

    // Create pass
    $r= new ReflectionFunction($function);
    $pass= '';
    foreach (array_slice($r->getParameters(), 1) as $param) {
      $pass.= ', $'.$param->getName();
    }

    // Create method
    $src.= 'function '.$name.'('.substr($pass, 2).') {
      $f= self::$def["'.$name.'"];
      return $f($this'.('' === $pass ? '' : ', '.substr($pass, 2)).');
    }';
  }
  $src.= '}';
  eval($src);

  // Instantiate
  $c= new ReflectionClass('NewInstance_'.$uniq);
  $c->setStaticPropertyValue('def', $def);
  return $c->newInstanceArgs($args);
}