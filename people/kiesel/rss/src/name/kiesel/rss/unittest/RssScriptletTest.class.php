<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'name.kiesel.rss.scriptlet.RssScriptlet',
    'xml.Tree',
    'xml.rdf.RDFNewsFeed'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class RssScriptletTest extends TestCase {
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      // TODO: Fill code that gets executed before every test method
      //       or remove this method
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function newRequest($url) {
      $url= new URL($url);
      
      $request= new HttpScriptletRequest();
      $request->putEnvValue('HTTP_HOST', $url->getHost());
      $request->putEnvValue('REQUEST_URI', $url->getPath());
      $request->putEnvValue('QUERY_STRING', $url->getQuery());
      $request->putEnvValue('SERVER_PROTOCOL', 'HTTP/1.1');
      $request->setParams($url->getParams());

      $response= new HttpScriptletResponse();
      create(new RssScriptlet())->service($request, $response);
    
      return $response;
    }    
    
    /**
     * Test
     *
     */
    #[@test]
    public function noActionYieldsUsage() {
      $response= $this->newRequest('http://localhost/');
      $this->assertEquals('text/html', $response->getHeader('Content-Type'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function invalidActionYieldsInternalServerError() {
      $response= $this->newRequest('http://localhost/?action=doesnotexist');
      $this->assertEquals(HttpConstants::STATUS_INTERNAL_SERVER_ERROR, $response->getStatus());    
    }
    
    
    /**
     * Test
     *
     */
    #[@test]
    public function requestRetrievesRDF() {
      $response= $this->newRequest('http://localhost/?repository=svn://svn.xp-framework.net/xp/&action=log');
      
      $this->assertEquals('text/xml', $response->getHeader('Content-type'));
      $rdf= RDFNewsFeed::fromString($response->getContent());
      echo $rdf->getSource(0);
    }
  }
?>
