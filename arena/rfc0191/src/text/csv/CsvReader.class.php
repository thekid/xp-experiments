<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.TextReader');

  /**
   * Abstract base class
   *
   * @see   xp://text.csv.CsvListReader
   * @see   xp://text.csv.CsvObjectReader
   * @see   xp://text.csv.CsvBeanReader
   */
  abstract class CsvReader extends Object {
    protected $reader= NULL;
    protected $separator= ';';
    protected $quote= '"';
   
    /**
     * Creates a new CSV reader reading data from a given TextReader
     *
     * @param   io.streams.TextReader reader
     */
    public function  __construct(TextReader $reader) {
      $this->reader= $reader;
    }
    
    /**
     * Reads values
     *
     * @return  string[]
     */
    protected function readValues() {
      if (NULL === ($line= $this->reader->readLine())) return NULL;
      
      $values= array();
      $o= 0; $l= strlen($line);
      while (FALSE !== ($p= strcspn($line, $this->separator, $o))) {
        if ($o >= $l) {
          $value= '';
        } else if ($this->quote === $line{$o}) {
          if ($this->quote !== $line{$p- 1}) {
            $p= strcspn($line, $this->quote, $o+ 1)+ 2;   // leading and trailing quote
            if ($p > $l) {
              throw new FormatException('Unterminated quoted value in ['.$line.']');
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
