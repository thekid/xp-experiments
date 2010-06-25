<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler.types';

  /**
   * Represents a constant
   *
   * @see      xp://xp.compiler.types.Types
   */
  class xp·compiler·types·Constant extends Object {
    public
      $name       = '',
      $type       = NULL,
      $value      = NULL;

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
