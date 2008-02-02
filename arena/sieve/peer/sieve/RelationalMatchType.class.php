<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('peer.sieve.MatchType');

  /**
   * Relational match type
   *
   * @see      rfc://5231
   * @see      xp://peer.sieve.MatchType
   * @purpose  RelationalMatchType implementation
   */
  abstract class RelationalMatchType extends MatchType {
    public 
      $relational= NULL;
    
    /**
     * Constructor
     *
     * @param   string relational
     */
    public function __construct($relational) {
      $this->relational= $relational;
    }

    /**
     * Returns whether another object is equal to this relational match type
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return $cmp instanceof self && $this->relational === $cmp->relational;
    }
  }
?>
