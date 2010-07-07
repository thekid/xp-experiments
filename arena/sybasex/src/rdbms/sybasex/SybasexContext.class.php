<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'rdbms.sybasex.TdsColumn',
    'rdbms.sybasex.SybasexResultSet'
  );

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
      $messages   = array(),
      $resultSet  = NULL;
    
    public function newColumns() {
      $this->columns= array();
      $this->resultSet= new SybasexResultSet(NULL); // FIXME
    }
    
    public function addColumn(TdsColumn $column) {
      $this->columns[]= $column;
    }
    
    public function sealColumns() {
      $this->resultSet->setColumns($this->columns);
    }

    public function columns() {
      return $this->columns;
    }

    public function addRowResult(array $row) {
      $this->resultSet->addRow($row);
    }

    public function sealResultSet($rows, $flags) {
      if (!$this->resultSet) return;
      $this->resultSet->seal($rows, $flags);
    }

    public function resultSet() {
      return $this->resultSet;
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
