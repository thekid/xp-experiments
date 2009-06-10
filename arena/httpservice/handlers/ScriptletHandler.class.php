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
  class ScriptletHandler extends AbstractUrlHandler {
    protected 
      $webroot= '';

    static function __static() {
      function getallheaders() { }
    }

    /**
     * Constructor
     *
     * @param   string webroot document root
     */
    public function __construct($webroot) {
      $this->webroot= rtrim($webroot, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
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
      $url= parse_url($query);

      putenv('SCRIPT_URL='.$url['path']);
      putenv('REQUEST_URI='.$url['path']);
      putenv('QUERY_STRING='.$url['query']);
      putenv('HTTP_HOST=172.17.29.15');
      putenv('REQUEST_METHOD='.$method);
      putenv('SERVER_PROTOCOL=HTTP/1.0');
      $runner= xp·scriptlet·Runner::setup(array($this->webroot));
      try {
        $runner->scriptlet->init();
        $response= $runner->scriptlet->process();
      } catch (HttpScriptletException $e) {
        $response= $e->getResponse();
      }

      $h= array();
      foreach ($response->headers as $header) {
        list($name, $value)= explode(': ', $header, 2);
        $h[$name]= $value;
      }
      $this->sendHeader($socket, $response->statusCode, '', $h);
      $socket->write($response->getContent());
    }
  }
?>
