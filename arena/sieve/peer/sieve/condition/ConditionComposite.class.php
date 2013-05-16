<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'peer.sieve';

  uses('peer.sieve.condition.Condition', 'lang.IndexOutOfBoundsException');

  /**
   * For condition composites anyof and allof
   *
   * @purpose  Base class
   */
  class peer·sieve·condition·ConditionComposite extends peer·sieve·condition·Condition {
    public $conditions= array();
  
    /**
     * Returns the number of conditions this composite is composed of
     *
     * @return  int
     */
    public function numConditions() {
      return sizeof($this->conditions);
    }

    /**
     * Retrieve a condition at a given offset
     *
     * @param   int offset
     * @return  peer.sieve.Condition
     * @throws  lang.IndexOutOfBoundsException
     */
    public function conditionAt($offset) {
      if (!isset($this->conditions[$offset])) {
        throw new IndexOutOfBoundsException('Offset '.$offset.' out of bounds');
      }
      return $this->conditions[$offset];
    }

    /**
     * Creates a string representation of this condition.
     *
     * @return  string
     */
    public function toString() {
      $s= $this->getClassName().'('.sizeof($this->conditions).")@{\n";
      foreach ($this->conditions as $condition) {
        $s.= '  '.str_replace("\n", "\n  ", $condition->toString())."\n";
      }
      return $s.'}';
    }
  }
?>
