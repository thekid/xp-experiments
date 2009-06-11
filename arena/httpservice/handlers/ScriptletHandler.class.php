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
      $webroot= '',
      $docroot= '';

    static function __static() {
      function getallheaders() { }    // HACK
    }

    /**
     * Constructor
     *
     * @param   string webroot document root
     * @param   string docroot document root
     */
    public function __construct($webroot, $docroot) {
      $this->webroot= realpath($webroot);
      $this->docroot= realpath($docroot);
      foreach (explode(PATH_SEPARATOR, scanpath(array($this->webroot), $this->webroot)) as $path) {
        ClassLoader::registerPath($path);
      }
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
      putenv('HTTP_HOST='.$headers['host']);
      putenv('REQUEST_METHOD='.$method);
      putenv('DOCUMENT_ROOT='.$this->docroot);
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

    /**
     * Returns a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<'.$this->webroot.'|'.$this->docroot.'>';
    }
  }
?>
