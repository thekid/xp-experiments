<?php
  uses('lang.Enum');

  class TdsType extends Enum {
    public static
      $SYBTEXT        = NULL,
      $SYBNTEXT       = NULL,
      $SYBIMAGE       = NULL,
      $SYBVOID        = NULL,
      $SYBINT1        = NULL,
      $SYBBIT         = NULL,
      $SYBINT2        = NULL,
      $SYBINT4        = NULL,
      $SYBINT8        = NULL,
      $SYBDATETIME4   = NULL,
      $SYBREAL        = NULL,
      $SYBMONEY       = NULL,
      $SYBDATETIME    = NULL,
      $SYBFLT8        = NULL,
      $SYBMONEY4      = NULL,
      $SYBSINT1       = NULL,
      $SYBUINT2       = NULL,
      $SYBUINT4       = NULL,
      $SYBUINT8       = NULL,
      $SYBLONGBINARY  = NULL,
      $SYBLONGCHAR    = NULL;
    
    protected static
      $lookup         = NULL;
    
    static function __static() {
      self::$SYBTEXT= new self(0x23, 'SYBTEXT', 4, TRUE);
      self::$SYBNTEXT= new self(0x63, 'SYBNTEXT', 4, TRUE);
      self::$SYBIMAGE= new self(0x22, 'SYBIMAGE', 4, TRUE);
      self::$SYBVOID= new self(0x1f, 'SYBVOID', 0, TRUE);
      self::$SYBINT1= new self(0x30, 'SYBINT1', 0, FALSE);
      self::$SYBBIT= new self(0x32, 'SYBBIT', 0, FALSE);
      self::$SYBINT2= new self(0x34, 'SYBINT2', 0, FALSE);
      self::$SYBINT4= new self(0x38, 'SYBINT4', 0, FALSE);
      self::$SYBINT8= new self(0x7f, 'SYBINT8', 0, FALSE);
      self::$SYBDATETIME4= new self(0x3a, 'SYBDATETIME4', 0, FALSE);
      self::$SYBREAL= new self(0x3b, 'SYBREAL', 0, FALSE);
      self::$SYBMONEY= new self(0x6e, 'SYBMONEY', 0, FALSE);
      self::$SYBFLT8= new self(0x3e, 'SYBFLT8', 0, FALSE);
      self::$SYBDATETIME= new self(0x3d, 'SYBDATETIME', 0, FALSE
      self::$SYBMONEY4= new self(0x7a, 'SYBMONEY4', 0, FALSE);
      self::$SYBSINT1= new self(0x40, 'SYBSINT1', 0, FALSE);
      self::$SYBUINT2= new self(0x41, 'SYBUINT2', 0, FALSE);
      self::$SYBUINT4= new self(0x42, 'SYBUINT4', 0, FALSE);
      self::$SYBUINT8= new self(0x43, 'SYBUINT8', 0, FALSE);
      self::$SYBLONGBINARY= new self(0xe1, 'SYBLONGBINARY', 5, TRUE);
      self::$SYBLONGCHAR= new self(0x, 'SYBLONGCHAR', 5, TRUE);
    }
    
    public function __construct($ordinal, $name, $size, $nullable) {
      parent::__construct($ordinal, $name);
      $this->size= $size;
      $this->nullable= $nullable;
    }
    
    public function size() {
      return $this->size;
    }
    
    public function isNullable() {
      return $this->isNullable();
    }
  }
?>