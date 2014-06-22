<?php
use lang\Type;

class FunctionType extends Type {

  public function __construct(array $signature, Type $return) {
    $this->signature= $signature;
    $this->return= $return;
    parent::__construct(sprintf(
      'function(%s): %s',
      implode(', ', array_map(function($e) { return $e->getName(); }, $this->signature)),
      $this->return->getName()
    ));
  }

  public function isInstance($arg) {
    if ($arg instanceof \Closure) {
      $f= new \ReflectionFunction($arg);
      foreach ($f->getParameters() as $i => $param) {
        if (Primitive::$VAR->equals($this->signature[$i])) {
          continue;
        } else if ($this->signature[$i] instanceof \lang\Primitive) {
          continue;
        } else if ($this->signature[$i] instanceof \lang\ArrayType) {
          if (!$param->isArray()) return false;
        } else if ($this->signature[$i] instanceof \lang\MapType) {
          if (!$param->isArray()) return false;
        } else if ($this->signature[$i] instanceof \lang\XPClass) {
          if (!$param->isClass()) return false;
          if (!$this->signature[$i]->isAssignableFrom(new XPClass($param->getClass()))) return false;
        }
      }
      return true;
    }
    return false;
  }
}