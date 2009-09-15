<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'text.csv.CsvListWriter',
    'io.streams.MemoryOutputStream'
  );

  /**
   * TestCase
   *
   * @see      xp://text.csv.CsvListWriter
   */
  class CsvListWriterTest extends TestCase {
    protected $out= NULL;

    /**
     * Creates a new list writer
     *
     * @param   string str
     * @param   text.csv.CsvFormat format
     * @return  text.csv.CsvListWriter
     */
    protected function newWriter(CsvFormat $format= NULL) {
      $this->out= new MemoryOutputStream();
      return new CsvListWriter(new TextWriter($this->out, 'iso-8859-1'), $format);
    }
  
    /**
     * Test writing a single line
     *
     */
    #[@test]
    public function writeLine() {
      $this->newWriter()->write(array('Timm', 'Karlsruhe', '76137'));
      $this->assertEquals("Timm;Karlsruhe;76137;\n", $this->out->getBytes());
    }

    /**
     * Test writing an empty value
     *
     */
    #[@test]
    public function writeEmptyValue() {
      $this->newWriter()->write(array('Timm', '', '76137'));
      $this->assertEquals("Timm;;76137;\n", $this->out->getBytes());
    }

    /**
     * Test delimiter is quoted
     *
     */
    #[@test]
    public function valueWithDelimiterIsQuoted() {
      $this->newWriter(create(new CsvFormat())->withQuote("'"))->write(array('Timm;Friebe', 'Karlsruhe', '76137'));
      $this->assertEquals("'Timm;Friebe';Karlsruhe;76137;\n", $this->out->getBytes());
    }

    /**
     * Test delimiter is quoted
     *
     */
    #[@test]
    public function delimiterIsQuoted() {
      $this->newWriter(create(new CsvFormat())->withQuote("'"))->write(array(';', 'Karlsruhe', '76137'));
      $this->assertEquals("';';Karlsruhe;76137;\n", $this->out->getBytes());
    }

    /**
     * Test quotes are escaped
     *
     */
    #[@test]
    public function quotesAroundValueAreEscaped() {
      $this->newWriter(create(new CsvFormat())->withQuote("'"))->write(array("'Hello'", 'Karlsruhe', '76137'));
      $this->assertEquals("'''Hello''';Karlsruhe;76137;\n", $this->out->getBytes());
    }

    /**
     * Test quotes are escaped
     *
     */
    #[@test]
    public function quotesInsideValueAreEscaped() {
      $this->newWriter(create(new CsvFormat())->withQuote("'"))->write(array("He said 'Hello' to me", 'Karlsruhe', '76137'));
      $this->assertEquals("'He said ''Hello'' to me';Karlsruhe;76137;\n", $this->out->getBytes());
    }

    /**
     * Test quotes are escaped
     *
     */
    #[@test]
    public function quotesAroundEmptyAreEscaped() {
      $this->newWriter(create(new CsvFormat())->withQuote("'"))->write(array("''", 'Karlsruhe', '76137'));
      $this->assertEquals("'''''';Karlsruhe;76137;\n", $this->out->getBytes());
    }
  }
?>
