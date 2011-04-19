<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
 
  /**
   * Wrapper for MethodNotImplementedException
   *
   * This exception indicates a certain class method is not
   * implemented.
   */
  class MethodNotImplementedException extends XPException {
    public
      $method= '';
      
    /**
     * Constructor
     *
     * @access  public
     * @param   string message
     * @param   string method
     * @see     xp://lang.Exception#construct
     */
    public function __construct($message, $method) {
      parent::__construct($message);
      $this->method= $method;
    }

    /**
     * Return compound message of this exception.
     *
     * @access  public
     * @return  string
     */
    public function compoundMessage() {
      return sprintf(
        'Exception %s (method %s(): %s)',
        $this->getClassName(),
        $this->method,
        $this->message
      );
    }
  }
?>