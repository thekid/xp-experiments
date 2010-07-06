<?php

  uses(
    'util.log.Traceable',
    'io.streams.MemoryInputStream',
    'rdbms.sybasex.io.TdsBinaryInputStream',
    'rdbms.sybasex.SybasexRuntimeException'
  );

  class SybasexPacket extends Object implements Traceable {
    protected
      $type     = NULL,
      $data     = NULL,
      $context  = NULL;

    protected
      $cat    = NULL;

    const
      TDS_ENVCHANGE         = 0xe3,   // Environmental change
      TDS_ERROR             = 0xaa,   // Error token
      TDS_EED               = 0xe5,   // Extended error message
      TDS_LOGINACK          = 0xad,   // Login acknowledgement
      TDS_CAPABILITY        = 0xe2,   // Capabilities token
      TDS_RESULT            = 0xee,   // Result token
      TDS_CONTROL           = 0xae,   // Control token
      TDS_ROW_RESULT        = 0xd1,   // Data row result
      TDS_COMPUTE_RESULT    = 0xd3,   // Data compute result
      TDS_RESULTSET_DONE    = 0xfd,   // Result set done (end of query)
      TDS_PROCESS_DONE      = 0xfe,   // Process done (end of stored procedure)
      TDS_DONE_IN_PROGRESS  = 0xff;   // Query internal to SP has finished, but not SP

    /**
     * Constructor
     *
     * @param   int type
     * @param   string data
     */
    public function __construct($type, $data, $context) {
      $this->type= $type;
      $this->context= $context;
      $this->data= new TdsBinaryInputStream(new MemoryInputStream($data));  // FIXME: Use SocketStream directly
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
        self::TDS_ENVCHANGE         => 'EnvChange',
        self::TDS_ERROR             => 'Eed',
        self::TDS_EED               => 'Eed',
        self::TDS_LOGINACK          => 'LoginAck',
        self::TDS_CAPABILITY        => 'Capability',
        self::TDS_RESULT            => 'Result',
        self::TDS_CONTROL           => 'Ignore',
        self::TDS_ROW_RESULT        => 'RowResult',
        self::TDS_COMPUTE_RESULT    => 'RowResult',
        self::TDS_RESULTSET_DONE    => 'ResultSetDone',
        self::TDS_PROCESS_DONE      => 'ResultSetDone',
        self::TDS_DONE_IN_PROGRESS  => 'ResultSetDone'
      );
      if (!$this->hasData()) return NULL;

      $token= $this->read(1);

      if (!isset($tokenmap[ord($token)])) {
        throw new SybasexRuntimeException('Unknown token: '.sprintf('0x%02x', ord($token)));
      }

      $handler= $this->getClass()->getPackage()->getPackage('token')
        ->loadClass(sprintf('Tds%sToken', $tokenmap[ord($token)]))
        ->newInstance()
      ;
      $handler->setTrace($this->cat);
      $handler->setStream($this->data);
      $handler->setContext($this->context);
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
