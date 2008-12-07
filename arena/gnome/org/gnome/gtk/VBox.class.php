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
  class VBox extends Widget {
    
    /**
     * Constructor
     *
     */
    public function __construct() {
      $this->handle= new GtkVBox();
    }

    public function add(Widget $widget) {
      $this->handle->pack_start($widget->handle);
      return $widget;
    } 
  }
?>
