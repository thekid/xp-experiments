<?php

  uses(
   'rdbms.sybasex.SybasexPacket',
   'rdbms.sybasex.SybasexContext',
   'rdbms.sybasex.io.TdsBinaryInputStream',
   'rdbms.sybasex.io.TdsBinaryOutputStream'
  );

  class SybasexProtocol extends Object {
    protected
      $sock     = NULL,
      $in       = NULL,
      $out      = NULL,
      $cat      = NULL,
      $context  = NULL;

    const
      TDS_PT_QUERY      = 0x01,
      TDS_PT_LOGIN      = 0x02,
      TDS_PT_RPC        = 0x03,
      TDS_PT_RESP       = 0x04,
      TDS_PT_CANCEL     = 0x06,
      TDS_PT_BLKCPY     = 0x07,
      TDS_PT_QUERY5     = 0x0F,
      TDS_PT_LOGIN7     = 0x10,
      TDS_PT_AUTH7      = 0x11,
      TDS_PT_PRELOGIN8  = 0x12;

    const
      TDS_MORE_PACKETS  = 0x00,
      TDS_LAST_PACKET   = 0x01;

    const
      TDS_HEADERSIZE    = 8,
      TDS_PACKETSIZE    = 512;

    /**
     * Implementation of TDS 5.0 protocol
     *
     * @see   http://freetds.org/tds.html
     * @see   http://freetds.cvs.sourceforge.net/viewvc/freetds/freetds/src/tds/login.c?revision=1.196&view=markup
     */
    public function connect(Socket $s, $user= '', $pass= '') {
      $this->sock= $s;
      if (!$this->sock->isConnected()) $this->sock->connect();

      // Prepare streams for input & output
      $this->in= new TdsBinaryInputStream($this->sock->getInputStream());
      $this->out= new TdsBinaryOutputStream($this->sock->getOutputStream());

      // Create context
      $this->context= new SybasexContext();

      $packet= pack('a30Ca30Ca30Ca30C',
        'lost.i.schlund.de', min(30, strlen('lost.i.schlund.de')),
        $user, min(30, strlen($user)),
        $pass, min(30, strlen($pass)),
        (string)getmypid(), min(30, strlen(getmypid()))
      );

      $packet.= pack('CCCCCCCCCN',
        0x03, 0x01, 0x06, 0x0a, 0x09, 0x01,   // magic bytes (1)
        0,                                    // connection->bulk_copy ?
        0x00, 0x00,                           // magic bytes (2)
        0x00                                  // 4 null bytes for TDS5.0
      );

      $packet.= pack('CCCa30Ca30C',
        0x00, 0x00, 0x00,                    // magic bytes (3)
        $this->getClassName(), min(30, strlen($this->getClassName())),
        'syplayintern', min(30, strlen('syplayintern'))
      );

      // Put password2
      if (strlen($pass) > 253) throw new IllegalArgumentException('Password length must not exceed 253 bytes.');
      $packet.= pack('xCa253C', strlen($pass), $pass, strlen($pass)+ 2);

      // Protocol & program version (TDS 5.0)
      $packet.= pack('CCCC', 0x05, 0x00, 0x00, 0x00); // Protocol
      $packet.= pack('a10C', 'Ct-Library', strlen('Ct-Library')); // Client library name
      $packet.= pack('CCCC', 0x05, 0x00, 0x00, 0x00); // Program


      $packet.= pack('CCC', 0x00, 0x0d, 0x11);        // Magic bytes (4)
      $packet.= pack('a30CC',
        'us_english',                                 // language,
        strlen('us_english'),                         // length of language
        0x00                                          // "connection->suppress_language"
      );
      $packet.= pack('xx');                           // Magic bytes (5)
      $packet.= pack('C', 0);                         // connection->encryption_level (1 / 0)
      $packet.= pack('xxxxxxxxxx');                   // Magic bytes (6)

      // Char set
      $packet.= pack('a30CC', 'iso_1', strlen('iso_1'), 1);

      // Network packet size (in text!)
      $packet.= pack('a6C', '512', strlen('512'));

      // TDS 5.0 specific end
      $packet.= pack('xxxx');
      $packet.= pack('C', 0xE2);                      // 0xE2 = 226 = TDS_CAPABILITY_TOKEN
      $packet.= pack('n', 22);                        // 22 = TDS_MAX_CAPABILITY

      // TODO: Capability tokens should not be hardcoded, but meaningful;
      // anyways, this works.
      $packet.= pack('CCCCCCCCCCCCCCCCCCxxxx',
        0x01, 0x07, 0x00, 0x60, 0x81, 0xcf, 0xFF, 0xFE, 0x3e,
        0x02, 0x07, 0x00, 0x00, 0x00, 0x78, 0xc0, 0x00, 0x00
      );

      $this->sendPacket(self::TDS_PT_LOGIN, $packet);

      $recv= $this->readPacket();
      $recv->setTrace($this->cat);
      // DEBUG $this->cat && $this->cat->debug('Received', $recv);

      while ($token= $recv->nextToken()) {}
    }
    
    public function sendQuery($sql) {
      $this->sendPacket(self::TDS_PT_QUERY, $sql);
      
      $recv= $this->readPacket();
      $recv->setTrace($this->cat);
      // DEBUG $this->cat && $this->cat->debug('Received', $recv);

      while ($token= $recv->nextToken()) {}
    }

    protected function readPacket() {
      $last= FALSE;
      $data= '';
      $type= NULL;

      while (!$last) {
        // Read header
        $recv= $this->in->read(self::TDS_HEADERSIZE);
        $header= unpack('Ctype/Clast/nlength/xxxx', $recv);
        $last= $header['last'] === self::TDS_LAST_PACKET;

        // DEBUG $this->cat && $this->cat->debug('<<<', strlen($recv), '~', addcslashes($recv, "\0..\37!@\177..\377"));
        // DEBUG $this->cat && $this->cat->debug('<<<', 'Received header:', $header);

        $this->cat && $this->cat->debug('<<< Trying to read', $header['length']- self::TDS_HEADERSIZE, 'bytes.');
        $recv= $this->in->read($header['length']- self::TDS_HEADERSIZE);
        // DEBUG $this->cat && $this->cat->debug('<<<', addcslashes($recv, "\0..\37!@\177..\377"));

        $data.= $recv;
      }

      return new SybasexPacket($type, $data, $this->context);
    }

    protected function sendPacket($type, $data) {
      $this->cat && $this->cat->debug('Have', strlen($data), 'bytes to send.');

      while ($data) {
        $slice= substr($data, 0, min(strlen($data), self::TDS_PACKETSIZE- self::TDS_HEADERSIZE));
        $data= substr($data, strlen($slice));

        $this->cat && $this->cat->debug('Sending', strlen($slice), 'bytes for slice,', strlen($data), 'bytes remaining.');
        $wire= pack('CCnxxxx',
          $type,
          (strlen($data) > 0 ? self::TDS_MORE_PACKETS : self::TDS_LAST_PACKET),
          strlen($slice)+ self::TDS_HEADERSIZE
        ).$slice;

        // DEBUG $this->cat && $this->cat->debug('>>>', addcslashes($wire, "\0..\37!@\177..\377"));
        $this->out->write($wire);
      }
    }

    /**
     * Set log facility
     *
     * @param   util.log.LogCategory cat
     */
    public function setTrace($cat) {
      $this->cat= $cat;
    }
  }
?>
