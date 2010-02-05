<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * A string
   *
   */
  class String extends Object {
    protected $buffer= '';

    /**
     * Constructor
     *
     * @param   string initial
     */
    public function __construct($initial= '') {
      $this->buffer= $initial;
    }
  }
?>
