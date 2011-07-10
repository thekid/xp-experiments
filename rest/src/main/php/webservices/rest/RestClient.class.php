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
   * @test    net.xp_framework.unittest.webservices.rest.RestClientExecutionTest
   */
  class RestClient extends Object {
    protected $connection= NULL;
    
    /**
     * Creates a new Restconnection instance
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
      $this->setConnection(new HttpConnection($base));
    }
    
    /**
     * Sets base and returns this connection
     *
     * @param   var base either a peer.URL or a string
     * @return  webservices.rest.Restconnection
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
      return $this->connection ? $this->connection->getURL() : NULL;
    }
    
    /**
     * Sets HTTP connection
     *
     * @param   peer.http.HttpConnection connection
     */
    public function setConnection(HttpConnection $connection) {
      $this->connection= $connection;
    }

    /**
     * Execute a request
     *
     * @param   webservices.rest.RestRequest request
     * @return  webservices.rest.RestResponse
     */
    public function execute(RestRequest $request) {
      $send= $this->connection->create(new HttpRequest());
      $send->setMethod($request->getMethod());
      $send->setTarget($request->getTarget());
      $send->setParameters($request->getParameters());
      
      try {
        $response= $this->connection->send($send);
      } catch (IOException $e) {
        throw new RestException('Cannot send request', $e);
      }
      
      return new RestResponse($response->statusCode());
    }
  }
?>
