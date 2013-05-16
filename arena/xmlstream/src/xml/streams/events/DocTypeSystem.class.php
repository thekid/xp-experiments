<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.streams.events.DocType');

  /**
   * Represents the DOCTYPE event
   *
   */
  class DocTypeSystem extends DocType {
    
    /**
     * Returns whether another object is equal to this XML event
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return (
        $cmp instanceof self && 
        $cmp->name === $this->name
      );
    }
  }
?>
