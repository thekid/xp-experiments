<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.lint';

  /**
   * lint error bean
   *
   * @purpose  Bean
   */
  class xp·ide·lint·Error extends Object {
    private
      $text= '',
      $line= 0,
      $column= 0;

    /**
     * constructor
     *
     *
     * @param   int line
     * @param   int column
     * @param   string text
     */
    public function __construct($line, $column, $text) {
      $this->line= $line;
      $this->column= $column;
      $this->text= $text;
    }

    /**
     * Set text
     *
     * @param   string text
     */
    public function setText($text) {
      $this->text= $text;
    }

    /**
     * Get text
     *
     * @return  string
     */
    public function getText() {
      return $this->text;
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
