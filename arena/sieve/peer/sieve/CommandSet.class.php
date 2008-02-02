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
  }
?>
