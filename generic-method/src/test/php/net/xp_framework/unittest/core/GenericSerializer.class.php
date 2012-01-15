<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Fixture
   *
   */
  class GenericSerializer extends Object {
    
    /**
     * Return value of a given type
     *
     * @param   string input
     * @return  T result
     */
    #[@generic(self= array('T'), return= 'T')]
    public function valueOf«»($T, $input) {
      return 'N;' === $input 
        ? $T->default 
        : $T->newInstance(unserialize($input))
      ;
    }
  }
?>
