<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.Socket',
    'ByteCountedString', 
    'Serializer', 
    'RemoteInvocationHandler', 
    'RemoteInterfaceMapping',
    'RemoteException'
  );


  define('DEFAULT_PROTOCOL_MAGIC_NUMBER', 0x3c872747);

  // Request messages
  define('REMOTE_MSG_INIT',      0x0000);
  define('REMOTE_MSG_LOOKUP',    0x0001);
  define('REMOTE_MSG_CALL',      0x0002);
  define('REMOTE_MSG_FINALIZE',  0x0003);
  
  // Response messages
  define('REMOTE_MSG_VALUE',     0x0004);
  define('REMOTE_MSG_EXCEPTION', 0x0005);
  define('REMOTE_MSG_ERROR',     0x0006);

  /**
   * Handles the "XP" protocol
   *
   * @see      xp://ProtocolHandler
   * @purpose  Protocol Handler
   */
  class XpProtocolHandler extends Object {
    var
      $versionMajor   = 0,
      $versionMinor   = 0;
    
    var
      $_sock= NULL;  

    /**
     * Initialize this protocol handler
     *
     * @access  public
     * @param   &peer.URL proxy
     */
    function initialize(&$proxy) {
      sscanf(
        $proxy->getParam('version', '1.0'), 
        '%d.%d', 
        $this->versionMajor, 
        $this->versionMinor
      );
      $this->_sock= &new Socket($proxy->getHost('localhost'), $proxy->getPort(6448));
      $this->_sock->connect();
      $this->sendPacket(REMOTE_MSG_INIT);
    }
    
    /**
     * Look up an object by its name
     *
     * @access  public
     * @param   string name
     * @param   &lang.Object
     */
    function &lookup($name) {
      return $this->sendPacket(REMOTE_MSG_LOOKUP, '', array(new ByteCountedString($name)));
    }

    /**
     * Invoke a method on a given object id with given method name
     * and given arguments
     *
     * @access  public
     * @param   int oid
     * @param   string method
     * @param   mixed[] args
     * @return  &mixed
     */
    function &invoke($oid, $method, $args) {
      return $this->sendPacket(
        REMOTE_MSG_CALL, 
        pack('NN', 0, $oid),
        array(
          new ByteCountedString($method),
          new ByteCountedString(Serializer::representationOf(new ArrayList($args)))
        )
      );
    }

    /**
     * Sends a packet, reads and evaluates the response
     *
     * @access  protected
     * @param   int type
     * @param   string data default ''
     * @return  &mixed
     * @throws  io.IOException in case of I/O errors
     */
    function sendPacket($type, $data= '', $bytes= array()) {
      $bsize= sizeof($bytes);
      
      // Calculate packet length
      $length= strlen($data);
      for ($i= 0; $i < $bsize; $i++) {
        $length+= $bytes[$i]->length();
      }
      
      // Write packet
      $packet= pack(
        'Nc4Na*', 
        DEFAULT_PROTOCOL_MAGIC_NUMBER, 
        $this->versionMajor,
        $this->versionMinor,
        $type,
        FALSE,                  // compressed, not used at the moment
        $length,
        $data
      );
      // DEBUG Console::writeLine('>>>', addcslashes($packet, "\0..\37!@\177..\377"));

      try(); {
        $this->_sock->write($packet);
        for ($i= 0; $i < $bsize; $i++) {
          $bytes[$i]->writeTo($this->_sock);
        }
        $header= unpack(
          'Nmagic/cvmajor/cvminor/ctype/ccompressed/Nlength', 
          $this->readBytes(12)
        );
      } if (catch('IOException', $e)) {
        return throw($e);
      }
      
      // DEBUG Console::writeLine('<<<', xp::stringOf($header));
      
      if (DEFAULT_PROTOCOL_MAGIC_NUMBER != $header['magic']) {
        $this->_sock->close();
        return throw(new Error('Magic number mismatch (have: '.$header['magic'].' expect: '.DEFAULT_PROTOCOL_MAGIC_NUMBER));
      }
      
      // DEBUG Console::writeLine('<<<', addcslashes($data, "\0..\37!@\177..\377"));

      $ctx= array('handler' => &$this);

      // Perform actions based on response type
      try(); {
        switch ($header['type']) {
          case REMOTE_MSG_VALUE:
            return Serializer::valueOf(ByteCountedString::readFrom($this->_sock), $length= 0, $ctx);

          case REMOTE_MSG_EXCEPTION:
            $e= &Serializer::valueOf(ByteCountedString::readFrom($this->_sock), $length= 0, $ctx);
            return throw(new RemoteException($e->classname, $e));

          case REMOTE_MSG_ERROR:
            $message= ByteCountedString::readFrom($this->_sock);
            $this->_sock->close();
            return throw(new Error($message, $length= 0, $ctx));

          default:
            $this->_sock->readBytes($header['length']);   // Read all left-over bytes
            $this->_sock->close();
            return throw(new Error('Unknown message type'));
        }
      } if (catch('IOException', $e)) {
        return throw($e);
      }
    }
    
    /**
     * Read a specified number of bytes
     *
     * @access  protected
     * @param   int num
     * @return  string 
     */
    function readBytes($num) {
      $return= '';
      while (strlen($return) < $num) {
        if (0 == strlen($buf= $this->_sock->readBinary($num - strlen($return)))) return;
        $return.= $buf;
      }
      return $return;
    }

  } implements(__FILE__, 'ProtocolHandler');
?>
