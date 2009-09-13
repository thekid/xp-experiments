<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * CSV format
   *
   * @test     xp://net.xp_framework.unittest.text.csv.CsvFormatTest
   * @see      xp://text.csv.CsvReader
   */
  class CsvFormat extends Object {
    protected $delimiter= '';
    protected $quote= '';
    
    public static $DEFAULT= NULL;
    
    static function __static() {
      self::$DEFAULT= new self();
    }
    
    /**
     * Constructor
     *
     * @param   string delimiter
     * @param   string quote
     */
    public function __construct($delimiter= ';', $quote= '"') {
      $this->withDelimiter($delimiter);
      $this->withQuote($quote);
    }

    /**
     * Set delimiter character and return this format object
     *
     * @param   string delimiter
     * @return  text.csv.CsvFormat self
     */
    public function withDelimiter($delimiter) {
      if (strlen($delimiter) != 1) {
        throw new IllegalArgumentException('Delimiter '.xp::stringOf($delimiter).' must be 1 character long');
      }
      $this->delimiter= $delimiter;
      return $this;
    }    

    /**
     * Returns delimiter character used in this format object
     *
     * @return  string
     */
    public function getDelimiter() {
      return $this->delimiter;
    }    

    /**
     * Set quoting character and return this format object
     *
     * @param   string quote
     * @return  text.csv.CsvFormat self
     */
    public function withQuote($quote) {
      if (strlen($quote) != 1) {
        throw new IllegalArgumentException('Quote '.xp::stringOf($quote).' must be 1 character long');
      }
      $this->quote= $quote;
      return $this;
    }    

    /**
     * Returns quoting character used in this format object
     *
     * @return  string
     */
    public function getQuote() {
      return $this->quote;
    }    
  }
?>
