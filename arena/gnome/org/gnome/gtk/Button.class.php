<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('org.gnome.gtk.Widget', 'org.gnome.gdk.events.ButtonClickedEvent');


  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class Button extends Widget {
    const Clicked= 'org.gnome.gdk.events.ButtonClickedEvent';
    
    /**
     * Constructor
     *
     * @param   string text
     */
    public function __construct($text) {
      $this->handle= new GtkButton($text);
      $this->handle->set_name('Button:'.ucfirst($text));
    }
  }
?>
