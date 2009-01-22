<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'org.gnome.glade.GladeSource',
    'org.gnome.gtk.Button',
    'org.gnome.gtk.Window',
    'io.File'
  );

  class SnippetEditor extends Object {
  
    public static function main(array $args) {
      $p= GladeSource::parse(ClassLoader::getDefault()->getResource('main.glade'));
      $w= cast($p->getWidget('main'), 'org.gnome.gtk.Window');
      
      $w->showAll();
      
      Gtk::main();
    }
  }
?>
