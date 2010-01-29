<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('xp.scriptlet.Runner', 'handlers.AbstractUrlHandler');

  /**
   * Scriptlet handler
   *
   * @see      HttpProtocol
   * @purpose  Handler for HttpProtocol
   */
  class ProxyHandler extends AbstractUrlHandler {
    protected $endpoint= NULL;
    protected $url= NULL;

    /**
     * Constructor
     *
     * @param   string base endpoint URL
     */
    public function __construct($base) {
      $this->url= new URL($base);
      $this->endpoint= new Socket($this->url->getHost(), $this->url->getPort(80));
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @throws  
     */
    protected function write($data) {
      Console::writeLine('>>> ', addcslashes($data, "\0..\17"));
      $this->endpoint->write($data);
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     * @throws  
     */
    protected function read() {
      $data= $this->endpoint->read();
      Console::writeLine('<<< ', addcslashes($data, "\0..\17"));
      return $data;
    }
    
    /**
     * Handle a single request
     *
     * @param   string method request method
     * @param   string query query string
     * @param   array<string, string> headers request headers
     * @param   string data post data
     * @param   peer.Socket socket
     */
    public function handleRequest($method, $query, array $headers, $data, Socket $socket) {
      
      // Write
      try {
        $this->endpoint->connect();
        $this->write($method.' '.$query." HTTP/1.0\r\n");
        $headers['Host']= $this->url->getHost();
        foreach ($headers as $key => $value) {
          $this->write($key.': '.$value."\r\n");
        }
        $this->write("\r\n");
        $this->write($data);
      } catch (IOException $e) {
        Console::writeLine($method, ' ', $query, ' ~ ' ,$e);
        $this->sendErrorMessage($socket, 502, 'Proxy error', $e->getMessage());
        return;
      }

        // Hand through response
      while (!$this->endpoint->eof()) {
        $socket->write($this->read());
      }
      $this->endpoint->close();
    }

    /**
     * Returns a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<'.$this->url->toString().'>';
    }
  }
?>
