<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'webservices.rest.RestClient',
    'io.streams.MemoryInputStream'
  );

  /**
   * TestCase
   *
   * @see   xp://webservices.rest.RestClient
   */
  class RestClientExecutionTest extends TestCase {
    protected $fixture= NULL;
    protected static $conn= NULL;   

    /**
     * Creates dummy connection class
     *
     */
    #[@beforeClass]
    public static function dummyConnectionClass() {
      self::$conn= ClassLoader::defineClass('RestClientExecutionTest_Connection', 'peer.http.HttpConnection', array(), '{
        protected $result;

        public function __construct($status, $body, $headers) {
          parent::__construct("http://test");
          $this->result= "HTTP/1.1 ".$status."\r\n";
          foreach ($headers as $name => $value) {
            $this->result.= $name.": ".$value."\r\n";
          }
          $this->result.= "\r\n".$body;
        }
        
        public function send(HttpRequest $request) {
          return new HttpResponse(new MemoryInputStream($this->result));
        }
      }');
    }
    
    /**
     * Creates a new fixture
     *
     * @param   int status
     * @param   string body
     * @param   [:string] headers default [:]
     * @return  webservices.rest.RestClient
     */
    public function fixtureWithResult($status, $body, $headers= array()) {
      $fixture= new RestClient();
      $fixture->setConnection(self::$conn->newInstance($status, $body, $headers));
      return $fixture;
    }

    /**
     * Test
     *
     */
    #[@test]
    public function okStatus() {
      $fixture= $this->fixtureWithResult(HttpConstants::STATUS_OK, '');
      $response= $fixture->execute(new RestRequest());
      $this->assertEquals(HttpConstants::STATUS_OK, $response->status());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function notFoundStatus() {
      $fixture= $this->fixtureWithResult(HttpConstants::STATUS_NOT_FOUND, '');
      $response= $fixture->execute(new RestRequest());
      $this->assertEquals(HttpConstants::STATUS_NOT_FOUND, $response->status());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function jsonContent() {
      $fixture= $this->fixtureWithResult(HttpConstants::STATUS_OK, '{ "title" : "Found a bug" }', array(
        'Content-Type' => 'application/json'
      ));
      $response= $fixture->execute(new RestRequest());
      $this->assertEquals(array('title' => 'Found a bug'), $response->content());
    }
  }
?>
