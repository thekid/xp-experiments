<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler.types';

  /**
   * Represents a method
   *
   * @see      xp://xp.compiler.types.Types
   */
  class xp·compiler·types·Method extends Object {
    public
      $name       = '',
      $returns    = NULL,
      $modifiers  = 0,
      $parameters = array(),
      $holder     = NULL;

    /**
     * Constructor
     *
     * @param   string name
     */
    public function __construct($name= '') {
      $this->name= $name;
    }

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
