<?php
  class SybasexProtocol extends Object {
    protected
      $sock = NULL,
      $cat  = NULL;

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

    public function connect(Socket $s, $user= '', $pass= '') {
      $this->sock= $s;
      if (!$this->sock->isConnected()) $this->sock->connect();

      // Details from:
      // http://freetds.org/tds.html
      // http://freetds.cvs.sourceforge.net/viewvc/freetds/freetds/src/tds/login.c?revision=1.196&view=markup

      $packet= pack('a30Ca30Ca30Ca30C',
        'lost.i.schlund.de', min(30, strlen('lost.i.schlund.de')),
        $user, min(30, strlen($user)),
        $pass, min(30, strlen($pass)),
        (string)getmypid(), min(30, strlen(getmypid()))
      );

      $packet.= pack('CCCCCCCCCx',
        0x02, 0x00, 0x06, 0x04, 0x08, 0x01,   // magic bytes (1)
        0,                                    // connection->bulk_copy ?
        0x00, 0x00                            // magic bytes (2)
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
      $packet.= pack('a10', 'Ct-Library');            // Client library name
      $packet.= pack('CCCC', 0x05, 0x00, 0x00, 0x00); // Program


      $packet.= pack('CCC', 0x00, 13, 17);            // Magic bytes (4)
      $packet.= pack('a30C', 'us-english', 0x00);     // language, "connection->suppress_language"
      $packet.= pack('xx');                           // Magic bytes (5)
      $packet.= pack('C', 0);                         // connection->encryption_level (1 / 0)
      $packet.= pack('xxxxx');                        // Magic bytes (6)

      // Char set
      $packet.= pack('a30C', 'iso1', 1);              // Set client charset

      // Network packet size (in text!)
      $packet.= pack('a6', '512');

      // TDS 5.0 specific end
      $packet.= pack('xxxx');
      $packet.= pack('C', 0xE2);                      // 0xE2 = 226 = TDS_CAPABILITY_TOKEN
      $packet.= pack('N', 22);                        // 22 = TDS_MAX_CAPABILITY
      $packet.= pack('a22', '');                      // tds->capabilities

      $this->cat && $this->cat->debug('>>>', addcslashes($packet, "\0..\37!@\177..\377"));
      $this->sock->write($packet);

      $recv= $this->sock->read();
      $this->cat && $this->cat->debug('<<<', addcslashes($recv, "\0..\37!@\177..\377"));
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