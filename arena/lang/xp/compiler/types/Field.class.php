<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler.types';

  /**
   * Represents a field
   *
   * @see      xp://xp.compiler.types.Types
   */
  class xp·compiler·types·Field extends Object {
    public
      $name       = '',
      $type       = NULL,
      $modifiers  = 0;

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
