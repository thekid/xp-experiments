<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @see      reference
   * @purpose  purpose
   */
  class Project extends Object {
    public $base= NULL;
    
    /**
     * Constructor
     *
     * @param   io.collections.IOCollection base
     */
    public function __construct(IOCollection $base) {
      $this->base= $base;
    }
  }
?>
