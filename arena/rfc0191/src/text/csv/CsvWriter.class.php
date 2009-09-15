<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('io.streams.TextWriter', 'text.csv.CsvFormat');

  /**
   * Abstract base class
   *
   * @see   xp://text.csv.CsvListWriter
   * @see   xp://text.csv.CsvObjectWriter
   * @see   xp://text.csv.CsvBeanWriter
   */
  abstract class CsvWriter extends Object {
    protected $writer= NULL;
    protected $delimiter= ';';
    protected $quote= '"';
    protected $line= 0;
    protected $processors= array();

    /**
     * Creates a new CSV writer writing data to a given TextWriter
     *
     * @param   io.streams.TextWriter writer
     * @param   text.csv.CsvFormat format
     */
    public function  __construct(TextWriter $writer, CsvFormat $format= NULL) {
      $this->writer= $writer;
      with ($f= $format ? $format : CsvFormat::$DEFAULT); {
        $this->delimiter= $f->getDelimiter();
        $this->quote= $f->getQuote();
      }
    }
    
    /**
     * Sets processors and return this writer
     *
     * @param   text.csv.CellProcessor[] processors
     * @return  text.csv.CsvWriter this writer
     */
    public function withProcessors(array $processors) {
      $this->processors= $processors;
      return $this;
    }

    /**
     * Set header line
     *
     * @return  string[]
     * @throws  lang.IllegalStateException if writing has already started
     */
    public function setHeaders($headers) {
      if ($this->line > 0) {
        throw new IllegalStateException('Cannot writer headers - already started writing data');
      }
      return $this->writeValues($headers, TRUE);
    }

    /**
     * Raise an exception
     *
     * @param   string message
     */
    protected function raise($message) {
      throw new FormatException(sprintf('Line %d: %s', $this->line, $message));
    }
    
    /**
     * Writes values
     *
     * @see     http://en.wikipedia.org/wiki/Comma-separated_values
     * @param   var[] values
     * @param   bool raw
     * @throws  lang.FormatException if a formatting error is detected
     */
    protected function writeValues($values, $raw= FALSE) {
      $escape= $this->quote.$this->quote;
      foreach ($values as $v => $value) {        
        if (!$raw && isset($this->processors[$v])) {
          $value= $this->processors[$v]->process($value);
        }
        if (strcspn($value, $this->delimiter.$this->quote) < strlen($value)) {
          $this->writer->write($this->quote.str_replace($this->quote, $escape, $value).$this->quote);
        } else {
          $this->writer->write($value);
        }
        $this->writer->write($this->delimiter);
      }
      $this->writer->writeLine();
    }
  }
?>
