<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('text.csv.CsvReader');

  /**
   * Reads values from CSV lines into objects
   *
   * @test     xp://net.xp_framework.unittest.text.csv.CsvObjectReaderTest
   */
  class CsvObjectReader extends CsvReader {

    /**
     * Creates a new CSV reader reading data from a given TextReader
     * creating objects for a given class.
     *
     * @param   io.streams.TextReader reader
     * @param   lang.XPClass class
     */
    public function  __construct(TextReader $reader, XPClass $class) {
      parent::__construct($reader);
      $this->class= $class;
    }
    
    /**
     * Read a record
     *
     * @param   string[] fields
     * @return  lang.Object or NULL if end of the file is reached
     */
    public function read(array $fields) {
      if (NULL === ($l= $this->reader->readLine())) return NULL;
      $instance= $this->class->newInstance();
      foreach (explode(';', $l) as $i => $value) {
        $this->class->getField($fields[$i])->set($instance, $value);
      }
      return $instance;
    }    
  }
?>
