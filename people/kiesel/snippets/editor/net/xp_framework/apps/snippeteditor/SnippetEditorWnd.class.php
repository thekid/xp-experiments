<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('org.gnome.gtk.Window');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class SnippetEditorWnd extends Window {
    
    public function initialize() {
      $this-
    }
    
    #[@callback(name= 'org.gnome.gdk.events.DeleteEvent')]
    public function onDelete() {
      Gtk::main_quit();
    }
  }
?>
