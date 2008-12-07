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
  abstract class DeleteEvent extends Event {
    public function name() { return 'destroy'; }
    public function method() { return 'onDelete'; }
    public abstract function onDelete($source, $event);
  }
?>
