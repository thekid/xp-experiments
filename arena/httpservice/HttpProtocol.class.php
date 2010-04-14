<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.server.ServerProtocol');

  /**
   * HTTP protocol implementation
   *
   * @purpose  Protocol
   */
  class HttpProtocol extends Object implements ServerProtocol {
    protected $handlers = array();
    public    $server   = NULL;

    /**
     * Initialize Protocol
     *
     * @return  bool
     */
    public function initialize() {
      // Intentionally empty
    }

    /**
     * Handle client connect
     *
     * @param   peer.Socket socket
     */
    public function handleConnect($socket) {
      // Intentionally empty
    }

    /**
     * Handle client disconnect
     *
     * @param   peer.Socket socket
     */
    public function handleDisconnect($socket) {
      $socket->close();
    }
    
    /**
     * Supply a URL handler for a given regex
     *
     * @param   string pattern regex
     * @param   handlers.AbstractUrlHandler handler
     */
    public function setUrlHandler($host, $pattern, $handler) {
      if (!isset($this->handlers[$host])) {
        $this->handlers[$host]= array();
      }
      $this->handlers[$host][$pattern]= $handler;
    }
  
    /**
     * Handle client data
     *
     * @param   peer.Socket socket
     * @return  mixed
     */
    public function handleData($socket) {
      
      // Read header
      $header= '';
      try {
        while (FALSE === ($p= strpos($header, "\r\n\r\n"))) {
          $header.= $socket->readBinary(1024);
        }
      } catch (IOException $e) {
        Console::$err->writeLine($e);
        return $socket->close();
      }
      
      // Parse first line
      if (4 != sscanf($header, '%s %[^ ] HTTP/%d.%d', $method, $query, $major, $minor)) {
        Console::$err->writeLine('Malformed request "', addcslashes($header, "\0..\17"), '" from ', $socket->host);
        return $socket->close();
      }
      $offset= strpos($header, "\r\n")+ 2;
      
      // Parse rest
      $headers= array();
      if ($t= strtok(substr($header, $offset, $p- $offset), "\r\n")) do {
        sscanf($t, "%[^:]: %[^\n]", $name, $value);
        $headers[$name]= $value;
      } while ($t= strtok("\r\n"));
      
      // Read input data (XXX: Delay until requested?)
      $body= '';
      try {
        if (isset($headers['Content-length'])) {
          $body= substr($header, $p+ 4);
          while (strlen($body) < $headers['Content-length']) {
            $body.= $socket->readBinary(1024);
          }
        }
      } catch (IOException $e) {
        Console::$err->writeLine($e);
        return $socket->close();
      }
      
      // Log request
      Console::$out->writeLinef(
        '[%.3f %s %s @ %s] %s:%s (%d bytes)',
        memory_get_usage() / 1024,
        date('Y-m-d H:i:s'), 
        @$headers['User-Agent'],
        $socket->host, 
        $method, 
        $query, 
        strlen($body)
      );

      // Check for vhost
      $host= strtolower($headers['Host']);
      $handlers= isset($this->handlers[$host]) ? $this->handlers[$host] : $this->handlers['default'];

      // Construct response 
      foreach ($handlers as $pattern => $handler) {
        if (preg_match($pattern, $query)) {
          try {
            $handler->handleRequest($method, $query, $headers, $body, $socket);
          } catch (IOException $e) {
            Console::$err->writeLine('Connection closed ~ ', $e);
            return $socket->close();
          }
          $socket->close();
          return;
        }
      }
      
      // Cannot find any handler 
      try {
        $r= '<h1>Could not handle request (Host: '.$host.')</h1><xmp>'.xp::stringOf($this->handlers).'</xmp>';
        $socket->write("HTTP/1.1 500 Internal Server Error\r\n");
        $socket->write("Content-type: text/html\r\n");
        $socket->write("Content-length: ".strlen($r)."\r\n");
        $socket->write("\r\n");
        $socket->write($r);
      } catch (IOException $e) {
        Console::$err->writeLine($e);
        return $socket->close();
      }

      // Close socket, ignoring any keep-alive headers for the moment
      $socket->close();
    }

    /**
     * Handle I/O error
     *
     * @param   peer.Socket socket
     * @param   lang.XPException e
     */
    public function handleError($socket, $e) {
      Console::$err->writeLine('* ', $socket->host, '~', $e);
      $socket->close();
    }
    
    /**
     * Returns a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      $s= $this->getClassName()."@{\n";
      foreach ($this->handlers as $host => $handlers) {
        $s.= '  [host '.$host."] {\n";
        foreach ($handlers as $pattern => $handler) {
          $s.= '    handler<'.$pattern.'> => '.$handler->toString()."\n";
        }
        $s.= "  }\n";
      }
      return $s.'}';
    }
  }
?>
