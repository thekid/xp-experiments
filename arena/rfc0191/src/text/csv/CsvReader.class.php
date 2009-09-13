<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.TextReader', 'text.csv.CsvFormat');

  /**
   * Abstract base class
   *
   * @see   xp://text.csv.CsvListReader
   * @see   xp://text.csv.CsvObjectReader
   * @see   xp://text.csv.CsvBeanReader
   */
  abstract class CsvReader extends Object {
    protected $reader= NULL;
    protected $delimiter= ';';
    protected $quote= '"';
    protected $line= 0;
   
    /**
     * Creates a new CSV reader reading data from a given TextReader
     *
     * @param   io.streams.TextReader reader
     * @param   text.csv.CsvFormat format
     */
    public function  __construct(TextReader $reader, CsvFormat $format= NULL) {
      $this->reader= $reader;
      with ($f= $format ? $format : CsvFormat::$DEFAULT); {
        $this->delimiter= $f->getDelimiter();
        $this->quote= $f->getQuote();
      }
    }

    /**
     * Get header line
     *
     * @return  string[]
     * @throws  lang.IllegalStateException if reading has already started
     */
    public function getHeaders() {
      if ($this->line > 0) {
        throw new IllegalStateException('Cannot read headers - already started reading data');
      }
      return $this->readValues();
    }
    
    /**
     * Reads values
     *
     * @return  string[]
     * @throws  lang.FormatException if a formatting error is detected
     */
    protected function readValues() {
      if (NULL === ($line= $this->reader->readLine())) return NULL;

      $this->line++;
      $values= array();
      $o= 0; $l= strlen($line);
      while (FALSE !== ($p= strcspn($line, $this->delimiter, $o))) {
        if ($o >= $l) {
          $value= '';
        } else if ($this->quote === $line{$o}) {
          if ($o === $p- 1) {
            throw new FormatException('Unterminated quoted value in ['.$line.'] (line '.$this->line.')');
          } else if ($this->quote !== $line{$p- 1}) {
            $p= strcspn($line, $this->quote, $o+ 1)+ 2;   // leading and trailing quote
            if ($o+ $p > $l) {
              throw new FormatException('Unterminated quoted value in ['.$line.'] (line '.$this->line.')');
            }
          }
          $value= str_replace($this->quote.$this->quote, $this->quote, substr($line, $o+ 1, $p- 2));
        } else {
          $value= substr($line, $o, $p);
        }
        $values[]= $value;
        $o+= $p+ 1;
      }
      return $values;
    }
  }
?>
