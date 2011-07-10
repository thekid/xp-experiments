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
    protected $resource= '';
    protected $method= '';
    protected $parameters= array(
      RestParameters::REQUEST => array(),
      RestParameters::SEGMENT => array(),
    );

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
     * @param   string type default RestParameters::REQUEST
     */
    public function addParameter($name, $value, $type= RestParameters::REQUEST) {
      $this->parameters[$type][$name]= $value;
    }

    /**
     * Returns a parameter specified by its name
     *
     * @param   string name
     * @param   string type default RestParameters::REQUEST
     * @return  string value
     * @throws  lang.ElementNotFoundException
     */
    public function getParameter($name, $type= RestParameters::REQUEST) {
      if (!isset($this->parameters[$type][$name])) {
        raise('lang.ElementNotFoundException', 'No such parameter "'.$name.'"');
      }
      return $this->parameters[$type][$name];
    }

    /**
     * Returns all request parameters
     *
     * @param   [:string]
     */
    public function requestParameters() {
      return $this->parameters[RestParameters::REQUEST];
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
        $target.= $this->getParameter(substr($resource, $offset+ 1, $e- 1), RestParameters::SEGMENT);
        $offset+= $e+ 1;
      } while ($offset < $l);
      return $target;
    }
  }
?>
