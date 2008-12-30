<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('web.ScriptletRequest');

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
     * @param   web.ScriptletRequest wrapped
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
  }
?>
