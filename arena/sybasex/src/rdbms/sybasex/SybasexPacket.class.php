<?php

  uses(
    'util.log.Traceable',
    'io.streams.MemoryInputStream',
    'rdbms.sybasex.SybasexRuntimeException'
  );

  class SybasexPacket extends Object implements Traceable {
    protected
      $type   = NULL,
      $data   = NULL;

    protected
      $cat    = NULL;

    const
      TDS_ENVCHANGE   =   0xe3,   // Environmental change
      TDS_EED         =   0xe5,   // Extended error message
      TDS_LOGINACK    =   0xad,   // Login acknowledgement
      TDS_CAPABILITY  =   0xe2,   // Capabilities token
      TDS_RESULT      =   0xee,   // Result token
      TDS_CONTROL     =   0xae;   // Control token

    /**
     * Constructor
     *
     * @param   int type
     * @param   string data
     */
    public function __construct($type, $data) {
      $this->type= $type;
      $this->data= new MemoryInputStream($data);
    }

    /**
     * Set log facility
     *
     * @param   util.log.LogCategory cat
     */
    public function setTrace($cat) {
      $this->cat= $cat;
    }

    protected function read($size= 1) {
      return $this->data->read($size);
    }

    protected function hasData() {
      return (bool)$this->data->available();
    }

    public function nextToken() {
      static $tokenmap= array(
        self::TDS_ENVCHANGE   => 'EnvChange',
        self::TDS_EED         => 'Eed',
        self::TDS_LOGINACK    => 'LoginAck',
        self::TDS_CAPABILITY  => 'Capability',
        self::TDS_RESULT      => 'Result',
        self::TDS_CONTROL     => 'Ignore'
      );
      if (!$this->hasData()) return NULL;

      $token= $this->read(1);

      if (!isset($tokenmap[ord($token)])) {
        throw new SybasexRuntimeException('Unknown token: '.sprintf('0x%02x', ord($token)).' at offset '.($this->data->tell()- 1));
      }

      $handler= $this->getClass()->getPackage()->getPackage('token')
        ->loadClass(sprintf('Tds%sToken', $tokenmap[ord($token)]))
        ->newInstance()
      ;
      $handler->setTrace($this->cat);
      $handler->setStream($this->data);
      $handler->handle();

      return TRUE;
    }

    /**
     * Create string representation
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'@('.$this->hashCode().") {\n".
        'Type: '.$this->type.PHP_EOL.
      '}';
    }
  }
?>
