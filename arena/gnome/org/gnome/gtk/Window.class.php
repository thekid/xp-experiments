<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('org.gnome.gtk.Widget', 'org.gnome.gdk.events.DeleteEvent');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class Window extends Widget {
    const DeleteEvent= 'org.gnome.gdk.events.DeleteEvent';
    
    public function __construct() {
      $this->handle= new GtkWindow();
    }
  
    public function setTitle($title) {
      $this->handle->set_title($title);
    }  

    public function showAll() {
      $this->handle->show_all();
    }
    
    public function add(Widget $widget) {
      $this->handle->add($widget->handleandle);
      return $widget;
    } 
    
  }
?>
