<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('lang.types.ArrayList');

  /**
   * Extends the ArrayList class
   *
   */
  class ArraySortingExtension extends Object {
  
    static function __static() {
      xp::extensions('lang.types.ArrayList', __CLASS__);
    }

    /**
     * Returns a sorted ArrayList
     *
     * @param   lang.types.ArrayList self
     * @return  lang.types.ArrayList a sorted version
     */
    public static function sorted(ArrayList $self) {
      $a= $self->values;
      sort($a);         // Damn you pass by reference bastard
      return ArrayList::newInstance($a);
    }
  }
?>
