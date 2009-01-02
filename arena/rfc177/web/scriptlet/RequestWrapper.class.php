<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('web.scriptlet.ScriptletRequest');

  /**
   * Wraps a request - that is, delegates all calls to the wrapped request
   * object.
   *
   * @purpose  Request implementation
   */  
  abstract class RequestWrapper extends Object implements ScriptletRequest {
    protected $wrapped= NULL;
      
    /**
     * Constructor
     *
     * @param   web.scriptlet.ScriptletRequest wrapped
     */
    public function __construct(ScriptletRequest $wrapped) {
      $this->wrapped= $wrapped;
    }

    /**
     * Gets the length of the request sent by the client.
     *
     * @return  int length
     */
    public function getContentLength() {
      return $this->wrapped->getContentLength();
    }

    /**
     * Gets the content type of the request sent by the client.
     *
     * @return  string type
     */
    public function getContentType() {
      return $this->wrapped->getContentType();
    }

    /**
     * Gets the content type of the request sent by the client.
     *
     * @return  string encoding
     */
    public function getCharacterEncoding() {
      return $this->wrapped->getCharacterEncoding();
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
      return $this->wrapped->getParam($name, $default);
    }

    /**
     * Returns whether the specified request variable is set
     *
     * @param   string name Parameter name
     * @return  bool
     */
    public function hasParam($name) {
      return $this->wrapped->hasParam($name);
    }

    /**
     * Gets all request parameters
     *
     * @return  array params
     */
    public function getParams() {
      return $this->wrapped->getParams();
    }

    /**
     * Retrieves the requests absolute URI as an URL object
     *
     * @return  peer.URL
     */
    public function getURL() {
      return $this->wrapped->getURL();
    }

    /**
     * Returns a string representation of this request wrapper
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(->'.$this->wrapped->toString().')';
    }

    /**
     * Returns input stream
     *
     * @return  io.streams.InputStream
     */
    public function getInputStream() {
      return $this->wrapped->getInputStream();
    }

    /**
     * Returns whether a session exists
     *
     * @return  bool
     */
    public function hasSession() {
      return $this->wrapped->hasSession();
    }
    
    /**
     * Retrieves the session or NULL if none exists
     *
     * @return  web.scriptlet.Session session object
     */
    public function getSession() {
      return $this->wrapped->getSession();
    }
    
    /**
     * Retrieve all cookies
     *
     * @return  web.scriptlet.Cookie[]
     */
    public function getCookies() {
      return $this->wrapped->getCookies();
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
      return $this->wrapped->hasCookie($name);
    }

    /**
     * Retrieve cookie by it's name
     *
     * @param   mixed default default NULL the default value if cookie is non-existant
     * @return  web.scriptlet.Cookie
     */
    public function getCookie($name, $default= NULL) {
      return $this->wrapped->getCookie($name, $default);
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
      return $this->wrapped->getHeader($name, $default);
    }

    /**
     * Returns the request method.
     *
     * @return  string
     */
    public function getMethod() {
      return $this->wrapped->getMethod();
    }
    
    /**
     * Returns the query string from its environment variable 
     * QUERY_STRING, decoding it if necessary.
     *
     * @return  string
     */
    public function getQueryString() {
      return $this->wrapped->getQueryString();
    }
  }
?>
