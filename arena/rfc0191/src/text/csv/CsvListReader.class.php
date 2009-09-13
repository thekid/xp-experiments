<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('text.csv.CsvReader');

  /**
   * Reads values from CSV lines into a list
   *
   * @test     xp://net.xp_framework.unittest.text.csv.CsvListReaderTest
   */
  class CsvListReader extends CsvReader {
    
    /**
     * Read a record
     *
     * @return  string[] or NULL if end of the file is reached
     */
    public function read() {
      $l= $this->reader->readLine();
      return NULL === $l ? NULL : explode(';', $l);
    }    
  }
?>
