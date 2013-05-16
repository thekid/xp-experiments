<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
 
  uses('org.gnome.glade.WidgetNotFoundException');
 
  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class GladeSource extends Object {
    protected $handle= NULL;
    protected static $wrappers= array(
      'GtkWindow' => 'org.gnome.gtk.Window',
      'GtkButton' => 'org.gnome.gtk.Button'
    );
  
    protected function __construct($handle) {
      $this->handle= $handle;
    }
    
    public static function parse($buffer) {
      return new self(GladeXML::new_from_buffer($buffer));
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   string name
     * @return  org.gnome.gtk.Widget
     * @throws  org.gnome.glade.WidgetNotFoundException
     */
    public function getWidget($name) {
      if (NULL === ($w= $this->handle->get_widget($name))) {
        throw new WidgetNotFoundException('Widget "'.$name.'" does not exist');
      }
      if (!isset(self::$wrappers[$c= get_class($w)])) {
        throw new WidgetNotFoundException('Widget "'.$c.'" not supported');
      }

      $i= XPClass::forName(self::$wrappers[$c])->newInstance();
      $i->handle= $w;
      return $i;
    }
  }
?>
