<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('text.csv.CsvWriter');

  /**
   * Writes objects to CSV lines
   *
   * @test     xp://net.xp_framework.unittest.text.csv.CsvObjectWriterTest
   */
  class CsvObjectWriter extends CsvWriter {
    
    /**
     * Write a record
     *
     * @param   lang.Generic object
     * @param   string[] headers if omitted, all fields will be written
     */
    public function write(Generic $object, array $headers= array()) {
      $values= array();
      
      // Use the array-cast trick to access private and protected members
      $array= (array)$object;
      $map= array_flip($headers);
      foreach ($object->getClass()->getFields() as $f) {
        $name= $f->getName();
        if ($map && !isset($map[$name])) continue;
        switch ($f->getModifiers() & (MODIFIER_PUBLIC | MODIFIER_PROTECTED | MODIFIER_PRIVATE)) {
          case MODIFIER_PUBLIC: $values[]= $array[$name]; break;
          case MODIFIER_PROTECTED: $values[]= $array["\0*\0".$name]; break;
          case MODIFIER_PRIVATE: $values[]= $array["\0".$n."\0".$name]; break;
        }
      }
      return $this->writeValues($values);
    }
  }
?>
