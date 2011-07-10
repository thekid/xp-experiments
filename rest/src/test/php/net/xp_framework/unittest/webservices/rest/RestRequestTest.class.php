<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'webservices.rest.RestRequest'
  );

  /**
   * TestCase
   *
   * @see   xp://webservices.rest.RestRequest
   */
  class RestRequestTest extends TestCase {
    
    /**
     * Test
     *
     */
    #[@test]
    public function getResource() {
      $fixture= new RestRequest('/issues');
      $this->assertEquals('/issues', $fixture->getResource());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function setResource() {
      $fixture= new RestRequest();
      $fixture->setResource('/issues');
      $this->assertEquals('/issues', $fixture->getResource());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function withResource() {
      $fixture= new RestRequest();
      $this->assertEquals($fixture, $fixture->withResource('/issues'));
      $this->assertEquals('/issues', $fixture->getResource());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function getMethod() {
      $fixture= new RestRequest(NULL, HttpConstants::GET);
      $this->assertEquals(HttpConstants::GET, $fixture->getMethod());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function setMethod() {
      $fixture= new RestRequest();
      $fixture->setMethod(HttpConstants::GET);
      $this->assertEquals(HttpConstants::GET, $fixture->getMethod());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function withMethod() {
      $fixture= new RestRequest();
      $this->assertEquals($fixture, $fixture->withMethod(HttpConstants::GET));
      $this->assertEquals(HttpConstants::GET, $fixture->getMethod());
    }
  }
?>
