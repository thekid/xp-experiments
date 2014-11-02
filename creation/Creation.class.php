<?php

use lang\Type;
use lang\ClassLoader;

abstract class Creation extends Object {
  protected static $creations= [];

  protected static final function creationOf($t) {
    $setters= $args= '';

    foreach ($t->getConstructor()->getParameters() as $parameter) {
      $name= $parameter->getName();
      $setters.= 'protected $'.$name.';';
      $setters.= 'public function '.$name.'($value) { $this->'.$name.'= $value; return $this; }';
      $args.= ', $this->'.$name;
    }

    return ClassLoader::defineClass($t->getName().'Creation', 'Creation', [], '{
      public function create() { return new '.$t->literal().'('.substr($args, 1).'); }
      '.$setters.'
    }');
  }

  public static final function of($class) {
    if (!isset(self::$creations[$class])) {
      self::$creations[$class]= self::creationOf(Type::forName($class));
    }
    return self::$creations[$class]->newInstance();
  }

  public abstract function create();

  public function toString() {
    return $this->getClassName().'('.implode(', ', array_keys(get_object_vars($this))).')';
  }
}