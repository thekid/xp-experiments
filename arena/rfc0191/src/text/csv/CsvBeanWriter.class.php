<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('text.csv.CsvWriter');

  /**
   * Writes beans to CSV lines
   *
   * @test     xp://net.xp_framework.unittest.text.csv.CsvBeansWriterTest
   */
  class CsvBeanWriter extends CsvWriter {
    
    /**
     * Write a record
     *
     * @param   lang.Generic object
     * @param   string[] headers if omitted, all fields will be written
     */
    public function write(Generic $object, array $headers= array()) {
      $values= array();
      $map= array_flip($headers);
      $class= $object->getClass();
      foreach ($class->getFields() as $f) {
        $name= $f->getName();
        if ($map && !isset($map[$name])) continue;
        $values[]= $class->getMethod('get'.ucfirst($name))->invoke($object);
      }
      return $this->writeValues($values);
    }
  }
?>
