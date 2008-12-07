<?php
  uses(
    'org.gnome.glade.GladeSource',
    'org.gnome.gtk.Button',
    'org.gnome.gtk.Window'
  );

  class GladeApp extends Object {
  
    public static function main(array $args) {
      $p= GladeSource::parse(XPClass::forName('GladeApp')->getPackage()->getResource('hello.glade'));
      $w= cast($p->getWidget('main'), 'org.gnome.gtk.Window');
      $w->showAll();
      
      $p->getWidget('btnClose')->connect(newinstance(Button::Clicked, array(), '{
        public function onClicked($source) {
          Console::writeLine("Quitting because ", $source, " was clicked");
          Gtk::main_quit();
        }
      }'));
      
      // Closing a window doesn't stop the application!
      $w->connect(newinstance(Window::DeleteEvent, array(), '{
        public function onDelete($source, $event) {
          Gtk::main_quit();
        }
      }'));
      Gtk::main();
    }
  }
?>
