<?php
use lang\Type;

class FunctionType extends Type {

  public function __construct(Signature $signature, Type $return) {
    $this->signature= $signature;
    $this->return= $return;
    parent::__construct(sprintf(
      'function(%s): %s',
      $this->signature->declaration(),
      $this->return->getName()
    ));
  }

  public function isInstance($arg) {
    if ($arg instanceof \Closure) {
      $f= new \ReflectionFunction($arg);
      foreach ($f->getParameters() as $i => $param) {
        if (Primitive::$VAR->equals($this->signature->types[$i])) {
          continue;
        } else if ($this->signature->types[$i] instanceof \lang\Primitive) {
          continue;
        } else if ($this->signature->types[$i] instanceof \lang\ArrayType) {
          if (!$param->isArray()) return false;
        } else if ($this->signature->types[$i] instanceof \lang\MapType) {
          if (!$param->isArray()) return false;
        } else if ($this->signature->types[$i] instanceof \lang\XPClass) {
          if (!$param->isClass()) return false;
          if (!$this->signature->types[$i]->isAssignableFrom(new XPClass($param->getClass()))) return false;
        }
      }
      return true;
    }
    return false;
  }
}