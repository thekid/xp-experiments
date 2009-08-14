<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'com.thoughtworks.selenium.HttpCommandProcessor'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class HttpCommandProcessorTest extends TestCase {

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function setUp() {
      $this->processor= new HttpCommandProcessor('*firefox', 'http://google.de', 'localhost', 4444);
    }

    /**
     * Test
     *
     */
    #[@test]
    public function start() {
      $this->assertNotEmpty($this->processor->start());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function stop() {
      $this->assertNull($this->processor->stop());
    }

    /**
     * Test
     *
     */
    #[@test, @expect('com.thoughtworks.selenium.SeleniumException')]
    public function sendCmdBeforeStarting() {
      $this->processor->sendCommand('open', array('http://google.de'));
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function sendCommand() {
      $this->processor->start();
      $this->assertNull($this->processor->sendCommand('open', array('http://google.de')));
    }


    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getStrin() { }



  }
?>
