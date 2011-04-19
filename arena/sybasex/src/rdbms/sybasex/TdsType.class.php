<?php
  uses(
    'lang.Enum',
    'rdbms.sybasex.TdsNumeric'
  );

  class TdsType extends Enum {
    public static
      $SYBCHAR        = NULL,
      $SYBVARCHAR     = NULL,
      $SYBTEXT        = NULL,
      $SYBNTEXT       = NULL,
      $SYBIMAGE       = NULL,
      $SYBVOID        = NULL,
      $SYBINT1        = NULL,
      $SYBBIT         = NULL,
      $SYBINT2        = NULL,
      $SYBINT4        = NULL,
      $SYBINT8        = NULL,
      $SYBINTN        = NULL,
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
      $SYBLONGCHAR    = NULL,
      $SYBNUMERIC     = NULL,
      $SYBDECIMAL     = NULL;
    
    protected static
      $lookup         = NULL;
    
    protected
      $size           = NULL,
      $fixedSize      = NULL,
      $nullable       = NULL;

    static function __static() {
      // TODO: Add nullable types *N (eg. SYBINTN)

      self::$SYBCHAR= new self(0x2f, 'SYBCHAR', 0, TRUE, 1);
      self::$SYBVARCHAR= newinstance(__CLASS__, array(0x27, 'SYBVARCHAR', 1, TRUE), '{
        static function __static() {}
        public function fromWire(InputStream $stream, TdsColumn $column) {
          return $stream->read($stream->readByte());
        }
      }');
      self::$SYBTEXT= new self(0x23, 'SYBTEXT', 4, TRUE);
      self::$SYBNTEXT= new self(0x63, 'SYBNTEXT', 4, TRUE);
      self::$SYBIMAGE= new self(0x22, 'SYBIMAGE', 4, TRUE);
      self::$SYBVOID= new self(0x1f, 'SYBVOID', 0, TRUE, 0);
      self::$SYBINT1= new self(0x30, 'SYBINT1', 0, FALSE, 1);
      self::$SYBBIT= new self(0x32, 'SYBBIT', 0, FALSE, 1);
      self::$SYBINT2= new self(0x34, 'SYBINT2', 0, FALSE, 2);
      self::$SYBINT4= newinstance(__CLASS__, array(0x38, 'SYBINT4', 0, FALSE, 4), '{
        static function __static() {}
        public function fromWire(InputStream $stream, TdsColumn $column) {
          return $stream->readLong();
        }
      }');
      self::$SYBINT8= new self(0x7f, 'SYBINT8', 0, FALSE, 8);
      self::$SYBINTN= new self(0x26, 'SYBINTN', 1, TRUE);
      self::$SYBDATETIME4= new self(0x3a, 'SYBDATETIME4', 0, FALSE, 4);
      self::$SYBREAL= new self(0x3b, 'SYBREAL', 0, FALSE, 4);
      self::$SYBMONEY= new self(0x6e, 'SYBMONEY', 0, FALSE, 8);
      self::$SYBFLT8= new self(0x3e, 'SYBFLT8', 0, FALSE, 8);
      self::$SYBDATETIME= newinstance(__CLASS__, array(0x3d, 'SYBDATETIME', 0, FALSE, 8), '{
        static function __static() {}
        public function fromWire(InputStream $stream, TdsColumn $column) {
          $daysSince1900= $stream->readLong();
          $time= $stream->readLong();
          
          $l= $daysSince1900 + 68569 + 2415021;
          $n= 4 * $l / 146097;
          $l= $l - (146097 * $n + 3) / 4;
          $i= 4000 * ($l + 1) / 1461001;
          $l= $l - 1461 * $i / 4 + 31;
          $j= 80 * $l / 2447;
          $k = $l - 2447 * $j / 80;
          $l = $j / 11;
          $j = $j + 2 - 12 * $l;
          $i = 100 * ($n - 49) + $i + $l;
          
          return Date::create($i, $j, $k, 0, 0, 0);
        }
      }');
      self::$SYBMONEY4= new self(0x7a, 'SYBMONEY4', 0, FALSE, 4);
      self::$SYBSINT1= new self(0x40, 'SYBSINT1', 0, FALSE);
      self::$SYBUINT2= new self(0x41, 'SYBUINT2', 0, FALSE);
      self::$SYBUINT4= new self(0x42, 'SYBUINT4', 0, FALSE);
      self::$SYBUINT8= new self(0x43, 'SYBUINT8', 0, FALSE);
      // self::$SYBUNIQUE= new self(0xXX, 'SYBUNIQUE', 0, FALSE, 16); // MSSQL?
      self::$SYBLONGBINARY= new self(0xe1, 'SYBLONGBINARY', 5, TRUE);
      self::$SYBLONGCHAR= new self(0xaf, 'SYBLONGCHAR', 5, TRUE);
      self::$SYBNUMERIC= newinstance(__CLASS__, array(0x6c, 'SYBNUMERIC', 1, TRUE), '{
        static function __static() {}
        public function fromWire(InputStream $stream, TdsColumn $column) {  // TODO: Introduce value object
          // First byte is wire-length
          return TdsNumeric::fromBytes(
            $stream->read($stream->readByte()),
            $column->precision(),
            6 // $column->getScale()
          );
          return TdsNumeric::bytesToValue($stream->read($stream->readByte()));
        }
      }');
      self::$SYBDECIMAL= newinstance(__CLASS__, array(0x6d, 'SYBDECIMAL', 1, TRUE), '{
        static function __static() {}
      }');
    }
    
    public function __construct($ordinal, $name, $size, $nullable, $fixedSize= NULL) {
      parent::__construct($ordinal, $name);
      $this->size= $size;
      $this->nullable= $nullable;
      $this->fixedSize= $fixedSize;
    }
    
    public function size() {
      return $this->size;
    }
    
    public function isNullable() {
      return $this->isNullable();
    }

    public function isFixedSize() {
      return (NULL !== $this->fixedSize);
    }

    public function fixedSize() {
      if (NULL === $this->fixedSize) {
        throw new SybasexRuntimeException('Cannot determine a fixed size for dynamic size type '.$this->name());
      }

      return $this->fixedSize;
    }

    public function fromWire(InputStream $stream, TdsColumn $column) {
      if ($this->isFixedSize() && !$column->isNullable()) {
        raise('lang.MethodNotImplementedException', 'Not implemented', __FUNCTION__);
      }

      // All non-fixed-length datatypes and fixed-length datatypes in a nullable
      // column first come with one byte representing the length of the data,
      // then that many bytes data.
      $len= $stream->readByte();

      // A length of 0 indicates a NULLed value
      if (0 === $len) return NULL;

      return $stream->read($len);
    }

    public static function byOrdinal($ord) {
      foreach (self::membersOf(__CLASS__) as $member) {
        if ($ord === $member->ordinal()) return $member;
      }

      throw new SybasexRuntimeException('No TdsType with ordinal '.sprintf('0x%02x', $ord));
    }
  }
?>