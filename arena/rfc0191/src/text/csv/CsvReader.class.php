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
      if (NULL === ($l= $this->reader->readLine())) return NULL;
      
      $values= array();
      $o= 0;
      while (FALSE !== ($p= strcspn($l, $this->separator, $o))) {
        if ($this->quote === $l{$o}) {
          $value= substr($l, $o+ 1, $p- 2);
        } else {
          $value= substr($l, $o, $p);
        }
        $values[]= $value;
        $o+= $p+ 1;
      }
      return $values;
    }
  }
?>
