<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.source.parser';

  /**
   * lexer token
   *
   * @purpose  IDE
   */
  class xp·ide·source·parser·Token extends Object {
    private
      $value= '',
      $line= 0,
      $column= 0;

    public function setValue($value) {
      $this->value= $value;
    }

    public function getValue() {
      return $this->value;
    }

    public function setLine($line) {
      $this->line= $line;
    }

    public function getLine() {
      return $this->line;
    }

    public function setColumn($column) {
      $this->column= $column;
    }

    public function getColumn() {
      return $this->column;
    }
  }

?>
