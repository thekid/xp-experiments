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
  abstract class ButtonClickedEvent extends Event {
    public function name() { return 'clicked'; }
    public function method() { return 'onClicked'; }
    public abstract function onClicked($source);
  }
?>
