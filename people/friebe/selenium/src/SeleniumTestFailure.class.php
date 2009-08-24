<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('SeleniumTestResult');

  /**
   * (Insert class' description here)
   *
   */
  class SeleniumTestFailure extends SeleniumTestResult {
    protected $cause= NULL;
    
    /**
     * Constructor
     *
     * @param   string name
     * @param   lang.Throwable cause
     */
    public function __construct($name, Throwable $cause) {
      parent::__construct($name);
      $this->cause= $cause;
    }
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<'.$this->name.'>@'.xp::stringOf($this->cause);
    }
  }
?>
