<?php

use lang\Type;
use lang\ClassLoader;

abstract class DynamicCreation extends Object {
  protected static $creations= [];
  protected $prop= [];

  protected static final function creationOf($t) {
    $args= '';

    foreach ($t->getConstructor()->getParameters() as $parameter) {
      $args.= ', $this->prop["'.$parameter->getName().'"]';
    }

    return ClassLoader::defineClass($t->getName().'DynamicCreation', 'DynamicCreation', [], '{
      public function create() { return new '.$t->literal().'('.substr($args, 1).'); }
    }');
  }

  public static final function of($class) {
    if (!isset(self::$creations[$class])) {
      self::$creations[$class]= self::creationOf(Type::forName($class));
    }
    return self::$creations[$class]->newInstance();
  }

  public function __call($name, $args) { $this->prop[$name]= $args[0]; return $this; }

  public abstract function create();

  public function toString() {
    return $this->getClassName().'(__call)';
  }
}