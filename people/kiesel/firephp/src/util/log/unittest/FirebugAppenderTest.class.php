<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'util.log.Logger',
    'util.log.FirebugAppender',
    'util.log.layout.PatternLayout',
    'io.streams.MemoryInputStream',
    'peer.http.HttpResponse',
    'webservices.json.JsonDecoder'
  );

  /**
   * Test FirebugAppender
   *
   * @purpose  Test
   */  
  class FirebugAppenderTest extends TestCase {
    protected
      $fixture= NULL;

    /**
     * Setup
     *
     */
    public function setUp() {
      $this->appender= new FirebugAppender();
      $this->appender->setLayout(new PatternLayout('%m'));

      $this->fixture= Logger::getInstance()->getCategory();
      $this->fixture->addAppender($this->appender);
      
      $this->response= new HttpScriptletResponse(new MemoryInputStream('HTTP/1.0 200 OK'));
    }
    
    /**
     * Write log to given response
     * 
     */
    protected function finalize() {
      $this->appender->writeTo($this->response);
    }

    /**
     * Test headers are correctly set
     *
     */
    #[@test]
    public function headersSet() {
      $this->finalize();

      $this->assertEquals('http://meta.wildfirehq.org/Protocol/JsonStream/0.2', $this->response->getHeader('X-Wf-Protocol-1'));
      $this->assertEquals('http://meta.firephp.org/Wildfire/Plugin/FirePHP/Library-FirePHPCore/0.3', $this->response->getHeader('X-Wf-1-Plugin-1'));
      $this->assertEquals('http://meta.firephp.org/Wildfire/Structure/FirePHP/FirebugConsole/0.1', $this->response->getHeader('X-Wf-1-Structure-1'));
    }

    /**
     * Test log types
     *
     */
    #[@test]
    public function debugMessage() {
      $this->fixture->debug('Info Message');
      $this->finalize();
      
      $this->assertTrue(strpos($this->response->getHeader('X-Wf-1-1-1-1'), '"Type" : "LOG"') > 0);
    }

    /**
     * Test log types
     *
     */
    #[@test]
    public function infoMessage() {
      $this->fixture->info('Info Message');
      $this->finalize();

      $this->assertTrue(strpos($this->response->getHeader('X-Wf-1-1-1-1'), '"Type" : "INFO"') > 0);
    }

    /**
     * Test log types
     *
     */
    #[@test]
    public function warnMessage() {
      $this->fixture->warn('Info Message');
      $this->finalize();

      $this->assertTrue(strpos($this->response->getHeader('X-Wf-1-1-1-1'), '"Type" : "WARN"') > 0);
    }

    /**
     * Test log types
     *
     */
    #[@test]
    public function errorMessage() {
      $this->fixture->error('Info Message');
      $this->finalize();

      $this->assertTrue(strpos($this->response->getHeader('X-Wf-1-1-1-1'), '"Type" : "ERROR"') > 0);
    }

    /**
     * Test simple message
     *
     */
    #[@test]
    public function simpleMessage() {
      $this->fixture->info('Simple Message!');
      $this->finalize();

      $this->assertEquals('43|[ { "Type" : "INFO" } , "Simple Message!" ]|', $this->response->getHeader('X-Wf-1-1-1-1'));
    }

    /**
     * Test multiple messages and sequence
     *
     */
    #[@test]
    public function messageSequences() {
      $this->fixture->info('Message 1');
      $this->fixture->info('Message 2');
      $this->fixture->info('Message 3');
      $this->finalize();

      $this->assertNotEmpty($this->response->getHeader('X-Wf-1-1-1-1'));
      $this->assertNotEmpty($this->response->getHeader('X-Wf-1-1-1-2'));
      $this->assertNotEmpty($this->response->getHeader('X-Wf-1-1-1-3'));
    }

    /**
     * Test chunked message
     *
     */
    #[@test]
    public function chunkedMessage() {
      $this->fixture->info($msg= str_repeat('The large message!!!', 400));  // 8000 bytes
      $this->finalize();

      $this->assertEquals((strlen($msg)+28).'|[ { "Type" : "INFO" } , "'.substr($msg, 0, 4000-25).'|\\', $this->response->getHeader('X-Wf-1-1-1-1'));
      $this->assertEquals('|'.substr($msg, 4000-25, 4000).'|\\', $this->response->getHeader('X-Wf-1-1-1-2'));
      $this->assertEquals('|'.substr($msg, 8000-25, 4000).'" ]|', $this->response->getHeader('X-Wf-1-1-1-3'));
    }
  }
?>
