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
   */
  abstract class CsvReader extends Object {
    protected $reader= NULL;
   
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
      return explode(';', $l);
    }
  }
?>
