<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('org.gnome.gdk.events.DeleteEvent');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class Window extends Object {
    const DeleteEvent= 'org.gnome.gdk.events.DeleteEvent';
    
    public function __construct() {
      $this->h= new GtkWindow();
    }
  
    public function setTitle($title) {
      $this->h->set_title($title);
    }  

    public function showAll() {
      $this->h->show_all();
    }
    
    public function connect(Event $event) {
      $this->h->connect_simple($event->name(), array($event, $event->method()));
    } 

    public function add(Widget $widget) {
      $this->h->add($widget->handle);
      return $widget;
    } 
    
  }
?>
