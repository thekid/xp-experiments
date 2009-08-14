<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.http.HttpConnection',
    'com.thoughtworks.selenium.HttpCommandProcessor'
  );

  /**
   * Defines an interface that runs Selenium commands.
   *
   * @see      http://seleniumhq.org/
   * @purpose  run selenium tests
   */
  class Selenium extends Object {
    public
      $commandProcessor= NULL;

    protected
      $sessionId  = '';

    /**
     * Constructor
     *
     * @param   
     * @return  
     */
    public function __construct($browser, $browserUrl, $host = 'localhost', $port = 4444) {
      $this->commandProcessor= new HttpCommandProcessor($browser, $browserUrl, $host, $port);
    }

    /**
     * Start a new session and return the
     * session id
     *
     * @return  string
     */
    public function start() {
      $this->sessionId= $this->commandProcessor->start();
      return $this->sessionId;
    }

    /**
     * Stop session
     *
     */
    public function stop() {
      $this->commandProcessor->stop();
    }

    /**
     * Close test window
     *
     */
    public function close() {
      $this->commandProcessor->sendCommand('close');
    }

    /**
     * Open an url in current browser window
     *
     * @param   string url
     */
    public function open($url) {
      $this->commandProcessor->sendCommand('open', array($url));
    }
  }
?>
