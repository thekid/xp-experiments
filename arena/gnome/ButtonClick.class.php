<?php
  uses(
    'org.gnome.gtk.Window',
    'org.gnome.gdk.Event',
    'org.gnome.gtk.Label',
    'org.gnome.gtk.Button',
    'org.gnome.gtk.VBox'
  );

  class ButtonClick extends Object {
  
    public static function main(array $args) {
      $w= new Window();
      $w->setTitle('Hello world');
      
      with ($b= $w->add(new VBox())); {
        $b->add(new Label("Just wanted to say\r\n'Hello world!'"));
        $b->add(new Button('Cl_ick'))->connect(newinstance(Button::Clicked, array(), '{
          public function onClicked($source) {
            Console::writeLine("Click! ", $source);
          }
        }'));
        $b->add(new Button('Cl_ock'))->connect(newinstance(Button::Clicked, array(), '{
          public function onClicked($source) {
            Console::writeLine("Clock! ", $source);
          }
        }'));
      }
      
      $w->showAll();
      
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
