<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('org.gnome.gdk.Event');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  abstract class Widget extends Object {
    public $handle= NULL;

    /**
     * (Insert method's description here)
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<'.$this->handle->path().'>';
    }

    /**
     * (Insert method's description here)
     *
     * @param   org.gnome.gdk.Event event
     * @return  int signal id
     */
    public function connect(Event $event) {
      return $this->handle->connect_simple($event->name(), array($event, $event->method()), $this);
    }
  }
?>
