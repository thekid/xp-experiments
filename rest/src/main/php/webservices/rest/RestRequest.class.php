<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.http.HttpConstants', 'webservices.rest.RestParameters');

  /**
   * A REST request
   *
   * @test    xp://net.xp_framework.unittest.webservices.rest.RestRequestTest
   */
  class RestRequest extends Object {
    protected $resource= '/';
    protected $method= '';
    protected $parameters= array(
      RestParameters::REQUEST => array(),
      RestParameters::SEGMENT => array(),
    );
    protected $headers= array();

    /**
     * Creates a new RestRequest instance
     *
     * @param   string resource default NULL
     * @param   string method default HttpConstants::GET
     */
    public function __construct($resource= NULL, $method= HttpConstants::GET) {
      if (NULL !== $resource) $this->setResource($resource);
      $this->method= $method;
    }
    
    /**
     * Sets resource
     *
     * @param   string resource
     */
    public function setResource($resource) {
      $this->resource= $resource;
    }

    /**
     * Sets resource
     *
     * @param   string resource
     * @return  webservices.rest.RestRequest
     */
    public function withResource($resource) {
      $this->resource= $resource;
      return $this;
    }

    /**
     * Gets resource
     *
     * @return  string resource
     */
    public function getResource() {
      return $this->resource;
    }

    /**
     * Sets method
     *
     * @param   string method
     */
    public function setMethod($method) {
      $this->method= $method;
    }

    /**
     * Sets method
     *
     * @param   string method
     * @return  webservices.rest.RestRequest
     */
    public function withMethod($method) {
      $this->method= $method;
      return $this;
    }

    /**
     * Gets method
     *
     * @return  string method
     */
    public function getMethod() {
      return $this->method;
    }

    /**
     * Adds a parameter
     *
     * @param   string name
     * @param   string value
     */
    public function addParameter($name, $value) {
      $this->parameters[RestParameters::REQUEST][$name]= $value;
    }

    /**
     * Adds a parameter
     *
     * @param   string name
     * @param   string value
     * @return  webservices.rest.RestRequest this
     */
    public function withParameter($name, $value) {
      $this->parameters[RestParameters::REQUEST][$name]= $value;
      return $this;
    }

    /**
     * Adds a segment
     *
     * @param   string name
     * @param   string value
     */
    public function addSegment($name, $value) {
      $this->parameters[RestParameters::SEGMENT][$name]= $value;
    }

    /**
     * Adds a segment
     *
     * @param   string name
     * @param   string value
     * @return  webservices.rest.RestRequest this
     */
    public function withSegment($name, $value) {
      $this->parameters[RestParameters::SEGMENT][$name]= $value;
      return $this;
    }

    /**
     * Adds a header
     *
     * @param   string name
     * @param   string value
     */
    public function addHeader($name, $value) {
      $this->headers[$name]= $value;
    }

    /**
     * Adds a header
     *
     * @param   string name
     * @param   string value
     * @return  webservices.rest.RestRequest this
     */
    public function withHeader($name, $value) {
      $this->headers[$name]= $value;
      return $this;
    }

    /**
     * Returns a parameter specified by its name
     *
     * @param   string name
     * @return  string value
     * @throws  lang.ElementNotFoundException
     */
    public function getParameter($name) {
      if (!isset($this->parameters[RestParameters::REQUEST][$name])) {
        raise('lang.ElementNotFoundException', 'No such parameter "'.$name.'"');
      }
      return $this->parameters[RestParameters::REQUEST][$name];
    }

    /**
     * Returns all parameters
     *
     * @param   [:string]
     */
    public function getParameters() {
      return $this->parameters[RestParameters::REQUEST];
    }

    /**
     * Returns a segment specified by its name
     *
     * @param   string name
     * @return  string value
     * @throws  lang.ElementNotFoundException
     */
    public function getSegment($name) {
      if (!isset($this->parameters[RestParameters::SEGMENT][$name])) {
        raise('lang.ElementNotFoundException', 'No such segment "'.$name.'"');
      }
      return $this->parameters[RestParameters::SEGMENT][$name];
    }

    /**
     * Returns all segments
     *
     * @param   [:string]
     */
    public function getSegments() {
      return $this->parameters[RestParameters::SEGMENT];
    }

    /**
     * Returns a header specified by its name
     *
     * @param   string name
     * @return  string value
     * @throws  lang.ElementNotFoundException
     */
    public function getHeader($name) {
      if (!isset($this->headers[$name])) {
        raise('lang.ElementNotFoundException', 'No such header "'.$name.'"');
      }
      return $this->headers[$name];
    }

    /**
     * Returns all headers
     *
     * @param   [:string]
     */
    public function getHeaders() {
      return $this->headers;
    }

    /**
     * Gets query
     *
     * @return  string query
     */
    public function getTarget() {
      $resource= $this->resource;
      $l= strlen($resource);
      $target= '';
      $offset= 0;
      do {
        $b= strcspn($resource, '{', $offset);
        $target.= substr($resource, $offset, $b);
        $offset+= $b;
        if ($offset >= $l) break;
        $e= strcspn($resource, '}', $offset);
        $target.= $this->getSegment(substr($resource, $offset+ 1, $e- 1));
        $offset+= $e+ 1;
      } while ($offset < $l);
      return $target;
    }
  }
?>
