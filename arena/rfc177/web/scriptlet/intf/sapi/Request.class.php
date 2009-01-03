<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'web.scriptlet.intf.sapi';
  
  uses('web.scriptlet.ScriptletRequest');

  /**
   * ScriptletRequest implementation for PHP's Server APIs ("SAPI").
   *
   * @see      xp://web.scriptlet.ScriptletRequest
   */
  class web·scriptlet·intf·sapi·Request extends Object implements ScriptletRequest {
    
    /**
     * Extract information from PHP SAPI
     *
     * @param   array<string, string> cenv usually $_ENV
     * @param   array<string, string> cookie usually $_COOKIE
     * @param   array<string, string> params usually $_GET / $_POST
     * @param   io.streams.InputStream input
     */
    public function extract($cenv, $cookie, $params, $input) {
      $this->cenv= $cenv;
      $this->cookie= $cookie;
      $this->params= $params;
      $this->input= $input;
    }
    
    /**
     * Returns input stream
     *
     * @return  io.streams.InputStream
     */
    public function getInputStream() {
      return $this->input;
    }

    /**
     * Gets the length of the request sent by the client.
     *
     * @return  int length
     */
    public function getContentLength() {
      return isset($this->cenv['CONTENT_LENGTH']) ? (int)$this->cenv['CONTENT_LENGTH'] : 0;
    }

    /**
     * Gets the content type of the request sent by the client.
     *
     * @return  string type
     */
    public function getContentType() {
      if (!isset($this->cenv['CONTENT_TYPE'])) return NULL;

      sscanf($this->cenv['CONTENT_TYPE'], '%[^;];charset=%s', $type, $charset);
      return $type;
    }

    /**
     * Gets the content type of the request sent by the client.
     *
     * @return  string encoding
     */
    public function getCharacterEncoding() {
      if (!isset($this->cenv['CONTENT_TYPE'])) return NULL;

      sscanf($this->cenv['CONTENT_TYPE'], '%[^;];charset=%s', $type, $charset);
      return $charset;
    }

    /**
     * Returns a request variable by its name or NULL if there is no such
     * request variable
     *
     * @param   string name Parameter name
     * @param   mixed default default NULL the default value if parameter is non-existant
     * @return  string Parameter value
     */
    public function getParam($name, $default= NULL) {
      return isset($this->params[$name]) ? $this->params[$name] : $default;
    }

    /**
     * Returns whether the specified request variable is set
     *
     * @param   string name Parameter name
     * @return  bool
     */
    public function hasParam($name) {
      return isset($this->params[$name]);
    }

    /**
     * Gets all request parameters
     *
     * @return  array<string, string> params
     */
    public function getParams() {
      return $this->params;
    }

    /**
     * Retrieves the requests absolute URI as an URL object
     *
     * @return  peer.URL
     */
    public function getURL() {
      return new URL($this->cenv['SCRIPT_URI']);
    }

    /**
     * Retrieve all cookies
     *
     * @return  web.scriptlet.Cookie[]
     */
    public function getCookies() {
      $r= array();
      foreach ($this->cookie as $name => $value) {
        $r[]= new Cookie($name, $value);
      }
      return $r;
    }
    
    /**
     * Check whether a cookie exists by a specified name
     *
     * <code>
     *   if ($request->hasCookie('username')) {
     *     with ($c= $request->getCookie('username')); {
     *       $response->write('Welcome back, '.$c->getValue());
     *     }
     *   }
     * </code>
     *
     * @param   string name
     * @return  bool
     */
    public function hasCookie($name) {
      return isset($this->cookie[$name]);
    }

    /**
     * Retrieve cookie by it's name
     *
     * @param   string name
     * @param   mixed default default NULL the default value if cookie is non-existant
     * @return  web.scriptlet.Cookie
     */
    public function getCookie($name, $default= NULL) {
      return isset($this->cookie[$name]) ? new Cookie($name, $this->cookie[$name]) : $default;
    }

    /**
     * Returns whether a session exists
     *
     * @return  bool
     */
    public function hasSession() {
      return FALSE; // XXX 
    }
    
    /**
     * Retrieves the session or NULL if none exists
     *
     * @return  scriptlet.Session session object
     */
    public function getSession() {
      return NULL; // XXX
    }
    
    /**
     * Get requesting client's host address
     *
     * @return  string
     */
    public function getRemoteAddr() {
      return $this->cenv['REMOTE_ADDR'];
    }
    
    /**
     * Get requesting client's hostname if available
     *
     * @return  string
     */
    public function getRemoteHost() {
      return isset($this->cenv['REMOTE_HOST']) ? $this->cenv['REMOTE_HOST'] : NULL;
    }
    
    /**
     * Get requesting client's port
     *
     * @return  int
     */
    public function getRemotePort() {
      return (int)$this->cenv['REMOTE_PORT'];
    }
    
    /**
     * Get REMOTE_USER
     *
     * @return  string
     */
    public function getRemoteUser() {
      return isset($this->cenv['REMOTE_USER']) ? $this->cenv['REMOTE_USER'] : NULL;
    }

    /**
     * Get the server name handling this request
     *
     * @return  string
     */
    public function getServerName() {
      return $this->cenv['SERVER_NAME'];
    }

    /**
     * Get the server port handling this request
     *
     * @return  int
     */
    public function getServerPort() {
      return (int)$this->cenv['SERVER_PORT'];
    }

    /**
     * Get the protocol used
     *
     * @return  int
     */
    public function getProtocol() {
      return $this->cenv['SERVER_PROTOCOL'];
    }

    /**
     * Returns a request header by its name or NULL if there is no such header
     * Typical request headers are: Accept, Accept-Charset, Accept-Encoding,
     * Accept-Language, Connection, Host, Keep-Alive, Referer, User-Agent
     *
     * @param   string name Header
     * @param   mixed default default NULL the default value if header is non-existant
     * @return  string Header value
     */
    public function getHeader($name, $default= NULL) {
      $lookup= 'HTTP_'.strtoupper(strtr($name, '-', '_'));
      return isset($this->cenv[$lookup]) ? $this->cenv[$lookup] : $default;
    }
    
    /**
     * Returns the request method.
     *
     * @return  string
     */
    public function getMethod() {
      return $this->cenv['REQUEST_METHOD'];
    }

    /**
     * Returns the query string from its environment variable 
     * QUERY_STRING, decoding it if necessary.
     *
     * @return  string
     */
    public function getQueryString() {
      return $this->cenv['QUERY_STRING'];
    }
  }
?>
