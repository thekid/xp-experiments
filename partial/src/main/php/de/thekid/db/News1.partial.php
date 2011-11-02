<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Partial: Getters
   *
   */
  trait News1 {

    /**
     * Fetches an instance of this object from the underlying persistence
     * layer by a given unique identifier. Returns NULL if nothing is found.
     *
     * @param   int id
     * @return  de.thekid.db.News 
     */
    public static function getById($id) {
      return new self();
    }
  }
?>
