<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * A REST response
   *
   */
  class RestResponse extends Object {
    protected $status= -1;

    /**
     * Creates a new response
     *
     * @param   int status
     */
    public function __construct($status) {
      $this->status= $status;
    }

    /**
     * (Insert method's description here)
     *
     * @return  int
     */
    public function status() {
      return $this->status;
    }
  }
?>
