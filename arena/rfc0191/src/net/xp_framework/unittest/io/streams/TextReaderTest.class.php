<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'io.streams.TextReader',
    'io.streams.MemoryInputStream'
  );

  /**
   * TestCase
   *
   * @see      xp://io.streams.TextReader
   */
  class TextReaderTest extends TestCase {
  
    /**
     * Returns a text reader for a given input string.
     *
     * @param   string str
     * @param   string charset
     * @return  io.streams.TextReader
     */
    protected function newReader($str, $charset= NULL) {
      return new TextReader(new MemoryInputStream($str), $charset);
    }

    /**
     * Test reading
     *
     */
    #[@test]
    public function readOne() {
      $this->assertEquals('H', $this->newReader('Hello')->read(1));
    }

    /**
     * Test reading
     *
     */
    #[@test]
    public function readLength() {
      $this->assertEquals('Hello', $this->newReader('Hello')->read(5));
    }

    /**
     * Test reading
     *
     */
    #[@test]
    public function read() {
      $this->assertEquals('Hello', $this->newReader('Hello')->read());
    }

    /**
     * Test reading after EOF
     *
     */
    #[@test]
    public function readAfterEnd() {
      $r= $this->newReader('Hello');
      $this->assertEquals('Hello', $r->read(5));
      $this->assertNull($r->read());
    }

    /**
     * Test reading after EOF
     *
     */
    #[@test]
    public function readLineAfterEnd() {
      $r= $this->newReader('Hello');
      $this->assertEquals('Hello', $r->read(5));
      $this->assertNull($r->readLine());
    }

    /**
     * Test reading
     *
     */
    #[@test]
    public function readZero() {
      $this->assertEquals('', $this->newReader('Hello')->read(0));
    }
        
    /**
     * Test reading lines separated by "\n"
     *
     */
    #[@test]
    public function readLinesSeparatedByLineFeed() {
      $r= $this->newReader("Hello\nWorld");
      $this->assertEquals('Hello', $r->readLine());
      $this->assertEquals('World', $r->readLine());
      $this->assertNull($r->readLine());
    }
        
    /**
     * Test reading lines separated by "\r"
     *
     */
    #[@test]
    public function readLinesSeparatedByCarriageReturn() {
      $r= $this->newReader("Hello\rWorld");
      $this->assertEquals('Hello', $r->readLine());
      $this->assertEquals('World', $r->readLine());
      $this->assertNull($r->readLine());
    }
        
    /**
     * Test reading lines separated by "\r\n"
     *
     */
    #[@test]
    public function readLinesSeparatedByCRLF() {
      $r= $this->newReader("Hello\r\nWorld");
      $this->assertEquals('Hello', $r->readLine());
      $this->assertEquals('World', $r->readLine());
      $this->assertNull($r->readLine());
    }

    /**
     * Test reading an empty line
     *
     */
    #[@test]
    public function readEmptyLine() {
      $r= $this->newReader("Hello\n\nWorld");
      $this->assertEquals('Hello', $r->readLine());
      $this->assertEquals('', $r->readLine());
      $this->assertEquals('World', $r->readLine());
      $this->assertNull($r->readLine());
    }
  }
?>
