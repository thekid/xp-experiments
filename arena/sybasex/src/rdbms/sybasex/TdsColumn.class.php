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
    
    public function name() {
      return $this->name;
    }
    
    public function getType() {
      return $this->type;
    }
    
    public function size() {
      return $this->size;
    }
    
    public function precision() {
      return $this->precision;
    }

    public function isHidden() {
      return (bool)($this->flags & 0x01);
    }

    public function isKey() {
      return (bool)($this->flags & 0x02);
    }

    public function isWriteable() {
      return (bool)($this->flags & 0x10);
    }

    public function isNullable() {
      return (bool)($this->flags & 0x20);
    }

    public function isIdentity() {
      return (bool)($this->flags & 0x40);
    }

    public function toString() {
      return $this->getClassName().'@('.$this->hashCode().") {\n".
        sprintf("  [%-15s ] %s\n", "name", $this->name).
        sprintf("  [%-15s ] %d (%s)\n", "flags",
          $this->flags, rtrim(
          ($this->isHidden() ? 'HIDDEN|' : '').
          ($this->isKey() ? 'KEY|' : '').
          ($this->isWriteable() ? 'WRITEABLE|' : '').
          ($this->isNullable() ? 'NULLABLE|' : '').
          ($this->isIdentity() ? 'IDENTITY|' : ''),
          '|'
        )).
        sprintf("  [%-15s ] %d\n", "userType", $this->userType).
        sprintf("  [%-15s ] %s\n", "type", $this->type->toString()).
        sprintf("  [%-15s ] %d\n", "size", $this->size).
        sprintf("  [%-15s ] %d\n", "precision", $this->precision).
      "}";
    }
  }
?>
