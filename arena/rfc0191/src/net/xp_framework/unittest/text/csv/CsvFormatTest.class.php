<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'text.csv.CsvFormat'
  );

  /**
   * TestCase
   *
   * @see      xp://text.csv.CsvFormat
   */
  class CsvFormatTest extends TestCase {
  
    /**
     * Test default format uses ';' as delimiter and '"' as quote
     *
     */
    #[@test]
    public function defaultFormat() {
      $format= CsvFormat::$DEFAULT;
      $this->assertEquals(';', $format->getDelimiter());
      $this->assertEquals('"', $format->getQuote());
    }

    /**
     * Test pipes format uses '|' as delimiter and '"' as quote
     *
     */
    #[@test]
    public function pipesFormat() {
      $format= CsvFormat::$PIPES;
      $this->assertEquals('|', $format->getDelimiter());
      $this->assertEquals('"', $format->getQuote());
    }

    /**
     * Test commas format uses ',' as delimiter and '"' as quote
     *
     */
    #[@test]
    public function commasFormat() {
      $format= CsvFormat::$COMMAS;
      $this->assertEquals(',', $format->getDelimiter());
      $this->assertEquals('"', $format->getQuote());
    }

    /**
     * Test tabs format uses TAB as delimiter and '"' as quote
     *
     */
    #[@test]
    public function tabsFormat() {
      $format= CsvFormat::$TABS;
      $this->assertEquals("\t", $format->getDelimiter());
      $this->assertEquals('"', $format->getQuote());
    }

    /**
     * Test withQuote() method
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function quoteCharMayNotBeLongerThanOneCharacter() {
      create(new CsvFormat())->withQuote('Hello');
    }

    /**
     * Test withQuote() method
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function quoteCharMayNotBeEmpty() {
      create(new CsvFormat())->withQuote('');
    }

    /**
     * Test withDelimiter() method
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function delimiterCharMayNotBeLongerThanOneCharacter() {
      create(new CsvFormat())->withDelimiter('Hello');
    }

    /**
     * Test withDelimiter() method
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function delimiterCharMayNotBeEmpty() {
      create(new CsvFormat())->withDelimiter('');
    }
  }
?>
