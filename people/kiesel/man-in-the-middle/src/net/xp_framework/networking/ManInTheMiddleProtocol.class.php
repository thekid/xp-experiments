<?php
  uses('peer.server.ServerProtocol');
  
  class ManInTheMiddleProtocol extends Object implements ServerProtocol {
    public
      $server       = NULL;
      
    protected
      $remoteServer = NULL,
      $remotePort   = NULL,
      $out          = NULL;
      
    protected
      $right  = NULL;
    
    /**
     * Constructor
     *
     * @param   string server
     * @param   int port
     * @param   io.streams.StringWriter
     */
    public function __construct($server, $port, $out) {
      $this->remoteServer= $server;
      $this->remotePort= $port;
      $this->out= $out;
    }
    
    /**
     * Initialize Protocol
     *
     * @return  bool
     */
    public function initialize() {
      return TRUE;
    }

    /**
     * Handle client connect
     *
     * @param   peer.Socket socket
     */
    public function handleConnect($socket) {
      $this->out->writeLine('---> New incoming connection');

      $this->right= new BSDSocket($this->remoteServer, $this->remotePort);
      $this->right->connect();

      // Set both sockets to non-blocking
      $this->right->setBlocking(FALSE);
      $socket->setBlocking(FALSE);
    }

    /**
     * Handle client disconnect
     *
     * @param   peer.Socket socket
     */
    public function handleDisconnect($socket) {
      $this->out->writeLine('---> Hanging up.');
    }
  
    /**
     * Handle client data
     *
     * @param   peer.Socket socket
     * @return  var
     */
    public function handleData($left) {
      while ($left->isConnected() && $this->right->isConnected()) {
        if ($left->canRead(0.1)) {
          $data= $left->readBinary();
          if (strlen($data) > 0) {
            $this->dumpHexTo($this->out, '>>>', $data);
            $this->right->write($data);
          } else {
            // Remote side hung up
            break;
          }
        }

        if ($this->right->canRead(0.1)) {
          $data= $this->right->readBinary();
          if (strlen($data) > 0) {
            $this->dumpHexTo($this->out, '<<<', $data);
            $left->write($data);
          } else {
            // Remote side hung up
            break;
          }
        }

        usleep(100000);
      }

      $left->close();
      $this->right->close();
      $this->right= NULL;
    }

    /**
     * Handle I/O error
     *
     * @param   peer.Socket socket
     * @param   lang.XPException e
     */
    public function handleError($socket, $e) {
    
    }
    
    protected function dumpHexTo($out, $prefix, $data) {
      $i= 0;
      while ($i < strlen($data)) {
        $out->writef('%s %08d  ', $prefix, $i);

        $real= '';
        for ($j= 0; $j + $i < strlen($data) && $j < 16; $j++) {
          $out->writef('%02x ', ord($data{$i + $j}));

          $real.= (ord($data{$i + $j}) > 37) ? $data{$i + $j} : '.';
        }

        // Jump to the end of line
        $out->write(str_repeat('   ', 16- $j));

        $out->writeLine(' |', $real, '|');
        $i+= $j;
      }
    }
  }  
?>