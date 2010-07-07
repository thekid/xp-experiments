<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('rdbms.sybasex.TdsColumn');

  /**
   * SybasexContext
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class SybasexContext extends Object {
    protected
      $loggedIn   = FALSE,
      $columns    = NULL,
      $messages   = array();
    
    public function newColumns() {
      $this->columns= array();
    }
    
    public function addColumn(TdsColumn $column) {
      $this->columns[]= $column;
    }
    
    public function columns() {
      return $this->columns;
    }

    public function addMessage(TdsMessage $message) {
      $this->messages[]= $message;
    }

    public function setLoggedIn($l= TRUE) {
      $this->loggedIn= $l;
    }

    public function getLoggedIn() {
      return $this->loggedIn;
    }
  }
?>
