<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.http.HttpConnection',
    'com.thoughtworks.selenium.SeleniumException'
  );

  /**
   * Http command processor to 
   * communicate with selenium rc
   *
   * @ext      extension
   * @see      http://seleniumhq.org
   * @purpose  communicating with selenium rc
   */
  class HttpCommandProcessor extends Object {
    public
      $browser    = NULL,
      $browserUrl = NULL,
      $host       = NULL,
      $port       = NULL;
      
    protected
      $connection = NULL,
      $sessionId  = NULL;

    /**
     * Constructor
     *
     * @param   string browser
     * @param   string browserUrl
     * @param   string host
     * @param   int port
     */
    public function __construct($browser, $browserUrl, $host, $port) {
      $this->browser    = $browser;
      $this->browserUrl = $browserUrl;
      $this->host       = $host;
      $this->port       = $port;

      $this->connection= new HttpConnection(new URL(sprintf(
        'http://%s:%d/selenium-server/driver/',
        $this->host,
        $this->port
      )));
    }

    /**
     * Send a command to the selenium rc server
     *
     * @param   string command
     * @param   mixed* args
     * @return  string
     * @throws  lang.IllegalStateException
     */
    public function sendCommand($command, $args= array()) {
      $params= array('cmd' => $command);
      $this->sessionId && $params['sessionId']= $this->sessionId;
      foreach ($args as $i => $v) $params[$i+1]= $v;
      
      $response= $this->connection->get($params);

      if (!($l= $response->getHeader('Content-Length'))) {
        throw new SeleniumException('No content-length in '.xp::stringOf($r));
      }

      $result= $response->readData($l);
      
      if ('OK' != substr($result, 0, 2)) {
        throw new SeleniumException($result);
      }
        
      return $result;
    }

    /**
     * Start selenium rc
     *
     * @return  string
     */
    public function start() {
      $this->sessionId= $this->getString('getNewBrowserSession', array($this->browser, $this->browserUrl));
      return $this->sessionId;
    }

    /**
     * Stop selenium rc
     *
     */
    public function stop() {
      $this->sendCommand('testComplete');
      $this->sessionId= NULL;
    }

    /**
     * Retrieve a string from result
     *
     * @param   string command
     * @param   mixed* args
     * @return  string
     */
    public function getString($command, $args= array()) {
      $result= $this->sendCommand($command, $args);
      return (3 <= strlen($result) ? substr($result, 3) : '');
    }
  
  }

?>
