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

    /**
     * Test
     *
     */
    #[@test]
    public function noParameters() {
      $fixture= new RestRequest();
      $this->assertEquals(array(), $fixture->requestParameters());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function oneParameter() {
      $fixture= new RestRequest();
      $fixture->addParameter('filter', 'assigned');
      $this->assertEquals(
        array('filter' => 'assigned'), 
        $fixture->requestParameters()
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function twoParameters() {
      $fixture= new RestRequest('/issues');
      $fixture->addParameter('filter', 'assigned');
      $fixture->addParameter('state', 'open');
      $this->assertEquals(
        array('filter' => 'assigned', 'state' => 'open'), 
        $fixture->requestParameters()
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function targetWithoutParameters() {
      $fixture= new RestRequest('/issues');
      $this->assertEquals('/issues', $fixture->getTarget());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function targetWithSegmentParameter() {
      $fixture= new RestRequest('/users/{user}');
      $fixture->addParameter('user', 'thekid', RestParameters::SEGMENT);
      $this->assertEquals('/users/thekid', $fixture->getTarget());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function targetWithTwoSegmentParameters() {
      $fixture= new RestRequest('/repos/{user}/{repo}');
      $fixture->addParameter('user', 'thekid', RestParameters::SEGMENT);
      $fixture->addParameter('repo', 'xp-framework', RestParameters::SEGMENT);
      $this->assertEquals('/repos/thekid/xp-framework', $fixture->getTarget());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function targetWithSegmentParametersAndConstantsMixed() {
      $fixture= new RestRequest('/repos/{user}/{repo}/issues/{id}');
      $fixture->addParameter('user', 'thekid', RestParameters::SEGMENT);
      $fixture->addParameter('repo', 'xp-framework', RestParameters::SEGMENT);
      $fixture->addParameter('id', 1, RestParameters::SEGMENT);
      $this->assertEquals('/repos/thekid/xp-framework/issues/1', $fixture->getTarget());
    }
  }
?>
