<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler.ast';

  /**
   * (Insert class' description here)
   *
   * @purpose  purpose
   */
  abstract class xp·compiler·ast·Node extends Object {
    public
      $position= array();

    /**
     * (Insert method's description here)
     *
     * @param   array<string, *> members default array()
     */
    public function __construct($members= array()) {
      foreach ($members as $name => $value) {
        $this->{$name}= $value;
      }
    }
    
    /**
     * Helper method to compare two objects (as arrays) recursively
     *
     * @param   array a1
     * @param   array a2
     * @return  bool
     */
    protected function memberWiseCompare($a1, $a2) {
      if (sizeof($a1) != sizeof($a2)) return FALSE;

      foreach (array_keys((array)$a1) as $k) {
        switch (TRUE) {
          case !array_key_exists($k, $a2): 
            return FALSE;

          case is_array($a1[$k]):
            if (!$this->memberWiseCompare($a1[$k], $a2[$k])) return FALSE;
            break;

          case $a1[$k] instanceof Generic:
            if (!$a1[$k]->equals($a2[$k])) return FALSE;
            break;

          case $a1[$k] !== $a2[$k]:
            return '__id' === $k;
        }
      }
      return TRUE;
    }
        
    /**
     * (Insert method's description here)
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      if (!$cmp instanceof self) return FALSE;
      
      return $this->memberWiseCompare((array)$this, (array)$cmp);
    }

    /**
     * Creates a string representation of this node.
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function toString() {
      $s= $this->getClassName().'(line '.$this->position[0].', offset '.$this->position[1].")@{\n";
      foreach (get_object_vars($this) as $name => $value) {
        '__id' !== $name && 'position' !== $name && $s.= sprintf(
          "  [%-20s] %s\n", 
          $name, 
          xp::stringOf($value)
        );
      }
      return $s.'}';
    }
  }
?>
