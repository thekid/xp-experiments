<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * SybasexContext
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class SybasexContext extends Object {
    protected
      $columnMeta   = NULL;
    
    public function newColumns() {
      $this->columnMeta= array();
    }
    
    public function addColumn($name, $flags, $userType, TdsType $type, $size) {
      $this->columnMeta[]= array(
        'name'      => $name,
        'flags'     => $flags,
        'userType'  => $userType,
        'type'      => $type,
        'size'      => $size
      );
    }
    
    public function columns() {
      return $this->columnMeta;
    }
  }
?>
