<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'text.csv.CsvListReader',
    'io.streams.MemoryInputStream'
  );

  /**
   * TestCase
   *
   * @see      xp://text.csv.CsvListReader
   */
  class CsvListReaderTest extends TestCase {

    /**
     * Creates a new list reader
     *
     * @param   string str
     * @return  text.csv.CsvListReader
     */
    protected function newReader($str) {
      return new CsvListReader(new TextReader(new MemoryInputStream($str)));
    }
  
    /**
     * Test reading a single line
     *
     */
    #[@test]
    public function readLine() {
      $in= $this->newReader('Timm;Karlsruhe;76137');
      $this->assertEquals(array('Timm', 'Karlsruhe', '76137'), $in->read());
    }

    /**
     * Test reading an empty input
     *
     */
    #[@test]
    public function readEmpty() {
      $in= $this->newReader('');
      $this->assertNull($in->read());
    }

    /**
     * Test reading multiple lines
     *
     */
    #[@test]
    public function readMultipleLines() {
      $in= $this->newReader('Timm;Karlsruhe;76137'."\n".'Alex;Karlsruhe;76131');
      $this->assertEquals(array('Timm', 'Karlsruhe', '76137'), $in->read());
      $this->assertEquals(array('Alex', 'Karlsruhe', '76131'), $in->read());
    }

    /**
     * Test reading a quoted value
     *
     */
    #[@test]
    public function readQuotedValue() {
      $in= $this->newReader('"Timm";Karlsruhe;76137');
      $this->assertEquals(array('Timm', 'Karlsruhe', '76137'), $in->read());
    }

    /**
     * Test reading a quoted value containing the separator character
     *
     */
    #[@test]
    public function readQuotedValueWithSeparator() {
      $in= $this->newReader('"Friebe;Timm";Karlsruhe;76137');
      $this->assertEquals(array('Friebe;Timm', 'Karlsruhe', '76137'), $in->read());
    }

    /**
     * Test reading a quoted value
     *
     */
    #[@test]
    public function readQuotedValueWithQuotes() {
      $in= $this->newReader('"""Hello""";Karlsruhe;76137');
      $this->assertEquals(array('"Hello"', 'Karlsruhe', '76137'), $in->read());
    }

    /**
     * Test reading a quoted value
     *
     */
    #[@test]
    public function quotesInsideUnquoted() {
      $in= $this->newReader('He said "Hello";Karlsruhe;76137');
      $this->assertEquals(array('He said "Hello"', 'Karlsruhe', '76137'), $in->read());
    }

    /**
     * Test reading a quoted value
     *
     */
    #[@test]
    public function quoteInsideUnquoted() {
      $in= $this->newReader('A single " is OK;Karlsruhe;76137');
      $this->assertEquals(array('A single " is OK', 'Karlsruhe', '76137'), $in->read());
    }

    /**
     * Test reading a quoted value
     *
     */
    #[@test]
    public function readEmptyQuotedValue() {
      $in= $this->newReader('"";Karlsruhe;76137');
      $this->assertEquals(array('', 'Karlsruhe', '76137'), $in->read());
    }

    /**
     * Test unterminated quoted value detection
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function unterminatedQuote() {
      $this->newReader('"Unterminated;Karlsruhe;76131')->read();
    }

    /**
     * Test unterminated quoted value detection
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function unterminatedQuoteRightBeforeSeparator() {
      $this->newReader('";Karlsruhe;76131')->read();
    }

    /**
     * Test unterminated quoted value detection
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function unterminatedQuoteAtEnd() {
      $this->newReader('"')->read();
    }

    /**
     * Test reading an empty value
     *
     */
    #[@test]
    public function readEmptyValue() {
      $in= $this->newReader('Timm;;76137');
      $this->assertEquals(array('Timm', '', '76137'), $in->read());
    }

    /**
     * Test reading an empty value
     *
     */
    #[@test]
    public function readEmptyValueAtBeginning() {
      $in= $this->newReader(';Karlsruhe;76137');
      $this->assertEquals(array('', 'Karlsruhe', '76137'), $in->read());
    }

    /**
     * Test reading an empty value
     *
     */
    #[@test]
    public function readEmptyValueAtEnd() {
      $in= $this->newReader('Timm;Karlsruhe;');
      $this->assertEquals(array('Timm', 'Karlsruhe', ''), $in->read());
    }
  }
?>
