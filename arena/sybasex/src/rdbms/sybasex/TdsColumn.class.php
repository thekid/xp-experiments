<?php
  class TdsColumn extends Object {
    protected
      $name       = NULL,
      $flags      = NULL,
      $userType   = NULL,
      $type       = NULL,
      $size       = NULL,
      $precision  = NULL;
      
    public function __construct($name, $flags, $userType, TdsType $type, $size= NULL, $prec= NULL) {
      $this->name= $name;
      $this->flags= $flags;
      $this->userType= $userType;
      $this->type= $type;
      $this->size= $size;
      $this->precision= $prec;
    }
    
    public function getName() {
      return $this->name;
    }
    
    public function getType() {
      return $this->type;
    }
    
    public function size() {
      return $this->size;
    }
    
    public function toString() {
      return $this->getClassName().'@('.$this->hashCode().") {\n".
        sprintf("  [%-15s ] %s\n", "name", $this->name).
        sprintf("  [%-15s ] %d\n", "flags", $this->flags).
        sprintf("  [%-15s ] %d\n", "userType", $this->userType).
        sprintf("  [%-15s ] %s\n", "type", $this->type->toString()).
        sprintf("  [%-15s ] %d\n", "size", $this->size).
        sprintf("  [%-15s ] %d\n", "precision", $this->precision).
      "}";
    }
  }
?>