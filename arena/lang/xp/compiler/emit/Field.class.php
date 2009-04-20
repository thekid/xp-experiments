<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler.emit';

  /**
   * Represents a method
   *
   * @see      xp://xp.compiler.emit.Types
   */
  class xp·compiler·emit·Field extends Object {
    public
      $name       = '',
      $returns    = NULL,
      $modifiers  = 0,
      $parameters = array();

    /**
     * Returns name
     *
     * @return  string
     */
    public function name() {
      return $this->name;
    }
  }
?>
