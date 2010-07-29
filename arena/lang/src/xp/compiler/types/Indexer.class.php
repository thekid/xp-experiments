<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'xp.compiler.types';

  /**
   * Represents an indexer
   *
   * @see      xp://xp.compiler.types.Types
   */
  class xp·compiler·types·Indexer extends Object {
    public
      $type       = NULL,
      $parameters = array(),
      $holder     = NULL;

    /**
     * Creates a string representation of this method
     *
     * @return  string
     */
    public function toString() {
      $signature= '';
      foreach ($this->parameters as $parameter) {
        $signature.= ', '.$parameter->compoundName();
      }
      return sprintf(
        '%s<%s this[%s]>',
        $this->getClassName(),
        $this->type->compoundName(),
        substr($signature, 2)
      );
    }
  }
?>
