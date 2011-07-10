<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.http.HttpConnection',
    'webservices.rest.RestRequest',
    'webservices.rest.RestResponse'
  );

  /**
   * REST client
   *
   * @test    xp://net.xp_framework.unittest.webservices.rest.RestClientTest
   */
  class RestClient extends Object {
    protected $client= NULL;
    
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
      $this->client= new HttpConnection($base);
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
      return $this->client ? $this->client->getURL() : NULL;
    }
    
    /**
     * Execute a request
     *
     * @param   webservices.rest.RestRequest request
     * @return  webservices.rest.RestResponse
     */
    public function execute(RestRequest $request) {
      $send= $this->client->create(new HttpRequest());
      $send->setMethod($request->getMethod());
      $send->setTarget($request->getTarget());
      $send->setParameters($request->requestParameters());
      
      // DEBUG Console::writeLine($send->getRequestString());
      
      return new RestResponse();
    }
  }
?>
