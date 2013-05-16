<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.sieve';

  uses('lang.IndexOutOfBoundsException', 'peer.sieve.Command');

  /**
   * (Insert class' description here)
   *
   * @purpose  Value object
   */
  class peer·sieve·CommandSet extends Object {
    public $list= array();
      
    /**
     * Returns whether this listet is empty
     *
     * @return  bool
     */
    public function isEmpty() {
      return 0 === sizeof($this->list);
    }

    /**
     * Returns size of this listet
     *
     * @return  int
     */
    public function size() {
      return sizeof($this->list);
    }

    /**
     * Retrieve a list at a given offset
     *
     * @param   int offset
     * @return  peer.sieve.list
     * @throws  lang.IndexOutOfBoundsException
     */
    public function commandAt($offset) {
      if (!isset($this->list[$offset])) {
        throw new IndexOutOfBoundsException('Offset '.$offset.' out of bounds');
      }
      return $this->list[$offset];
    }

    /**
     * Creates a string representation of this action.
     *
     * @return  string
     */
    public function toString() {
      $s= $this->getClassName().'('.sizeof($this->list).")@{\n";
      foreach ($this->list as $command) {
        $s.= '  '.str_replace("\n", "\n  ", $command->toString())."\n";
      }
      return $s.'}';
    }
  }
?>
