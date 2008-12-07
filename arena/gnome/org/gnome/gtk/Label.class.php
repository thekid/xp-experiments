<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('org.gnome.gtk.Widget');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class Label extends Widget {

    /**
     * Constructor
     *
     * @param   string text
     */
    public function __construct($text) {
      $this->handle= new GtkLabel($text);
    }
  }
?>
