<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('text.diff.source.InputSource');

  /**
   * Array source
   *
   * @see      xp://text.diff.Difference#between
   * @purpose  Inputsource implementation
   */
  class ArraySource extends Object implements InputSource {
    protected
      $elements= array();
      
    /**
     * Constructor
     *
     * @param   string[] elements
     */
    public function __construct(array $elements) {
      $this->elements= $elements;
    }

    /**
     * Returns a string representation of this source
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'['.sizeof($this->elements).']@{'.implode(', ', $this->elements).'}';
    }


    /**
     * Returns this source's name
     *
     * @return  string
     */
    public function name() {
      return 'array';
    }

    /**
     * Returns this source's size
     *
     * @return  int
     */
    public function size() {
      return sizeof($this->elements);
    }
    
    /**
     * Returns an item at the given offset
     *
     * @param   int offset
     * @return  string
     */
    public function item($offset) {
      return $this->elements[$offset];
    }
  }
?>
