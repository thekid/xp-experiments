<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.types.ArrayList', 'util.Filter');

  /**
   * Extends the ArrayList class
   *
   */
  class ArrayFiltersExtension extends Object {
  
    static function __static() {
      xp::extensions('lang.types.ArrayList', __CLASS__);
    }

    /**
     * Returns a filtered ArrayList
     *
     * @param   lang.types.ArrayList self
     * @param   util.Filter f
     * @return  lang.types.ArrayList a filtered version
     */
    public static function filtered(ArrayList $self, Filter $f) {
      $r= array();
      foreach ($self->values as $v) {
        if ($f->accept($v)) $r[]= $v;
      }
      return ArrayList::newInstance($r);
    }
  }
?>
