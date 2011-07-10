<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.URL',
    'webservices.rest.RestRequest',
    'webservices.rest.RestResponse'
  );

  /**
   * (Insert class' description here)
   *
   */
  class RestClient extends Object {
    protected $base= NULL;
    
    /**
     * Creates a new RestClient instance
     *
     * @param   var base default NULL
     */
    public function __construct($base= NULL) {
      if (NULL !== $base) $this->setBase($base);
    }

    /**
     * Sets base
     *
     * @param   var base either a peer.URL or a string
     */
    public function setBase($base) {
      if ($base instanceof URL) {
        $this->base= $base;
      } else {
        $this->base= new URL($base);
      }
    }

    /**
     * Sets base and returns this client
     *
     * @param   var base either a peer.URL or a string
     * @return  webservices.rest.RestClient
     */
    public function withBase($base) {
      $this->setBase($base);
      return $this;
    }
    
    /**
     * Get base
     *
     * @return  peer.URL
     */
    public function getBase() {
      return $this->base;
    }
    
    /**
     * Execute a request
     *
     * @param   webservices.rest.RestRequest
     * @return  webservices.rest.RestResponse
     */
    public function execute(RestRequest $request) {
      return new RestResponse();
    }
  }
?>
