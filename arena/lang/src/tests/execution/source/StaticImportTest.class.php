<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'tests.execution.source';

  uses('tests.execution.source.ExecutionTest', 'io.streams.MemoryOutputStream');

  /**
   * Tests static imports
   *
   */
  class tests·execution·source·StaticImportTest extends ExecutionTest {
    protected $stream, $out= NULL;
  
    /**
     * Set up testcase and redirect console output to a memory stream
     *
     */
    public function setUp() {
      parent::setUp();
      $this->stream= new MemoryOutputStream();
      $this->out= Console::$out->getStream();
      Console::$out->setStream($this->stream);
    }
    
    /**
     * Set up testcase and restore console output
     *
     */
    public function tearDown() {
      Console::$out->setStream($this->out);
      delete($this->stream);
    }

    /**
     * Test util.cmd.Console.*
     *
     */
    #[@test]
    public function importAll() {
      $this->run(
        'writeLine("Hello");', 
        array('import static util.cmd.Console.*;')
      );
      $this->assertEquals("Hello\n", $this->stream->getBytes());
    }

    /**
     * Test util.cmd.Console.writeLine
     *
     */
    #[@test]
    public function importSpecific() {
      $this->run(
        'writeLine("Hello");', 
        array('import static util.cmd.Console.writeLine;')
      );
      $this->assertEquals("Hello\n", $this->stream->getBytes());
    }
  }
?>
