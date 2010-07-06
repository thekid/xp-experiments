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
      $columns   = NULL;
    
    public function newColumns() {
      $this->columns= array();
    }
    
    public function addColumn(TdsColumn $column) {
      $this->columns[]= $column;
    }
    
    public function columns() {
      return $this->columns;
    }
  }
?>
