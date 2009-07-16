<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.completion';

  /**
   * text cursor
   *
   * @purpose  IDE
   */
  class xp·ide·completion·Cursor extends Object {
    private
      $position= 0,
      $line= 0,
      $column= 0;

    /**
     * constructor
     *
     * @param   int position
     * @param   int line
     * @param   int column
     */
    public function __construct($position, $line, $column) {
      $this->position= $position;
      $this->line= $line;
      $this->column= $column;
    }

    /**
     * Set position
     *
     * @param   int position
     */
    public function setPosition($position) {
      $this->position= $position;
    }

    /**
     * Get position
     *
     * @return  int
     */
    public function getPosition() {
      return $this->position;
    }

    /**
     * Set line
     *
     * @param   int line
     */
    public function setLine($line) {
      $this->line= $line;
    }

    /**
     * Get line
     *
     * @return  int
     */
    public function getLine() {
      return $this->line;
    }

    /**
     * Set column
     *
     * @param   int column
     */
    public function setColumn($column) {
      $this->column= $column;
    }

    /**
     * Get column
     *
     * @return  int
     */
    public function getColumn() {
      return $this->column;
    }

  }
?>
