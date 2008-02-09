<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'peer.sieve.condition.Condition',
    'peer.sieve.condition.LargerThanCondition',
    'peer.sieve.condition.SmallerThanCondition'
  );

  /**
   * (Insert class' description here)
   *
   * @purpose  Base class for size-based tests
   */
  abstract class SizeCondition extends peer·sieve·condition·Condition {
    public $value= 0;
    
    /**
     * (Insert method's description here)
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.$this->value.')';
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   string test
     * @return  peer.sieve.SizeCondition
     * @throws  lang.IllegalArgumentException
     */
    public static function forName($test) {
      if ('over' === $test) {
        return new LargerThanCondition();
      } else if ('under' === $test) {
        return new SmallerThanCondition();
      }
      
      throw new IllegalArgumentException('Size: Unknown test "'.$test.'"'); 
    }
  }
?>
