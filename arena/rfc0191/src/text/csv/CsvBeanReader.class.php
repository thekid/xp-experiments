<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('text.csv.CsvReader');

  /**
   * Reads values from CSV lines into Beans
   *
   * @test     xp://net.xp_framework.unittest.text.csv.CsvBeanReaderTest
   */
  class CsvBeanReader extends CsvReader {

    /**
     * Creates a new CSV reader reading data from a given TextReader
     * creating Beans for a given class.
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
      if (NULL === ($values= $this->readValues())) return NULL;
      
      $instance= $this->class->newInstance();
      foreach ($fields as $i => $name) {
        $this->class->getMethod('set'.ucfirst($name))->invoke($instance, array($values[$i]));
      }
      return $instance;
    }    
  }
?>
