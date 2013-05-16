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
    protected $scriptlet= NULL;

    /**
     * Constructor
     *
     * @param   string name
     * @param   string arg
     */
    public function __construct($name, $arg) {
      $this->scriptlet= XPClass::forName($name)->newInstance($arg);
      $this->scriptlet->init();
    }
    
    protected function isValidUtf8($bytes) {
      return preg_match('%(?:
        [\xC2-\xDF][\x80-\xBF]        # non-overlong 2-byte
        |\xE0[\xA0-\xBF][\x80-\xBF]               # excluding overlongs
        |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}      # straight 3-byte
        |\xED[\x80-\x9F][\x80-\xBF]               # excluding surrogates
        |\xF0[\x90-\xBF][\x80-\xBF]{2}    # planes 1-3
        |[\xF1-\xF3][\x80-\xBF]{3}                  # planes 4-15
        |\xF4[\x80-\x8F][\x80-\xBF]{2}    # plane 16
        )+%xs', $bytes);
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
      $url= new URL('http://localhost'.$query);
      
      // Create request object
      $request= new HttpScriptletRequest();
      $request->method= $method;
      $request->env['SERVER_PROTOCOL']= 'HTTP/1.1';
      $request->env['REQUEST_URI']= $query;
      $request->env['QUERY_STRING']= substr($query, strpos($query, '?')+ 1);
      $request->env['HTTP_HOST']= $url->getHost();
      if ('https' === $url->getScheme()) { 
        $request->env['HTTPS']= 'on';
      }
      $request->setHeaders($headers);
      
      // Query string:
      foreach ($url->getParams() as $name => $value) {
        if ($this->isValidUtf8($value)) {
          $request->setParam($name, new String($value, 'utf-8'));
        } else {
          $request->setParam($name, new String($value));
        }
      }
      
      // POST data
      parse_str($data, $out);
      foreach ($out as $name => $value) {
        if ($this->isValidUtf8($value)) {
          $request->setParam($name, new String($value, 'utf-8'));
        } else {
          $request->setParam($name, new String($value));
        }
      }
            
      // Create 
      $response= new HttpScriptletResponse();
      
      try {
        $this->scriptlet->service($request, $response);
      } catch (HttpScriptletException $e) {
        $e->printStackTrace();
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
      return $this->getClassName().'<'.$this->scriptlet->toString().'>';
    }
  }
?>
