<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class TdsMessage extends Object {
    protected
      $number     = NULL,
      $state      = NULL,
      $severity   = NULL,
      $sqlstate   = NULL,
      $message    = NULL,
      $servername = NULL,
      $procname   = NULL,
      $line       = NULL;
    
    public function setNumber($n) {
      $this->number= $n;
    }
    
    public function setState($s) {
      $this->state= $s;
    }
    
    public function setSeverity($s) {
      $this->severity= $s;
    }
    
    public function setSqlState($s) {
      $this->sqlstate= $s;
    }
    
    public function setMessage($m) {
      $this->message= $m;
    }
    
    public function setServername($s) {
      $this->servername= $s;
    }
    
    public function setProcname($p) {
      $this->procname= $p;
    }
    
    public function setLine($l) {
      $this->line= $l;
    }
    
    public function toString() {
      return $s= $this->getClassName().'@('.$this->hashCode().") { \n".
        sprintf("  [%-15s] %s\n", 'number', $this->number).
        sprintf("  [%-15s] %s\n", 'state', $this->state).
        sprintf("  [%-15s] %s\n", 'severity', $this->severity).
        sprintf("  [%-15s] %s\n", 'sqlstate', $this->sqlstate).
        sprintf("  [%-15s] %s\n", 'message', $this->message).
        sprintf("  [%-15s] %s\n", 'servername', $this->servername).
        sprintf("  [%-15s] %s\n", 'procname', $this->procname).
        sprintf("  [%-15s] %s\n", 'line', $this->line).
      '}';
    }

  }
?>
