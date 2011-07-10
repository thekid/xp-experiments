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
      $this->assertEquals(array(), $fixture->getParameters());
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
        $fixture->getParameters()
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
        $fixture->getParameters()
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function noSegments() {
      $fixture= new RestRequest();
      $this->assertEquals(array(), $fixture->getSegments());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function oneSegment() {
      $fixture= new RestRequest();
      $fixture->addsegment('filter', 'assigned');
      $this->assertEquals(
        array('filter' => 'assigned'), 
        $fixture->getSegments()
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function twoSegments() {
      $fixture= new RestRequest('/issues');
      $fixture->addSegment('filter', 'assigned');
      $fixture->addSegment('state', 'open');
      $this->assertEquals(
        array('filter' => 'assigned', 'state' => 'open'), 
        $fixture->getSegments()
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
      $fixture->addSegment('user', 'thekid');
      $this->assertEquals('/users/thekid', $fixture->getTarget());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function targetWithTwoSegmentParameters() {
      $fixture= new RestRequest('/repos/{user}/{repo}');
      $fixture->addSegment('user', 'thekid');
      $fixture->addSegment('repo', 'xp-framework');
      $this->assertEquals('/repos/thekid/xp-framework', $fixture->getTarget());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function targetWithSegmentParametersAndConstantsMixed() {
      $fixture= new RestRequest('/repos/{user}/{repo}/issues/{id}');
      $fixture->addSegment('user', 'thekid');
      $fixture->addSegment('repo', 'xp-framework');
      $fixture->addSegment('id', 1);
      $this->assertEquals('/repos/thekid/xp-framework/issues/1', $fixture->getTarget());
    }
  }
?>
