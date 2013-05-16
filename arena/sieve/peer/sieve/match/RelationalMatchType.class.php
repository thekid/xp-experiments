<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('peer.sieve.match.MatchType');

  /**
   * Relational match type
   *
   * @see      rfc://5231
   * @see      xp://peer.sieve.match.MatchType
   * @purpose  RelationalMatchType implementation
   */
  abstract class RelationalMatchType extends MatchType {
    public 
      $op= NULL;
    
    /**
     * Constructor
     *
     * @param   string $op
     */
    public function __construct($op) {
      $this->op= $op;
    }

    /**
     * Returns whether another object is equal to this relational match type
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return $cmp instanceof self && $this->op === $cmp->op;
    }

    /**
     * Creates a string representation of this relational match type.
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.$this->op.')';
    }
  }
?>
