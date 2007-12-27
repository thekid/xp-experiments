<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'text.diff.operation.Change',
    'text.diff.operation.Copy',
    'text.diff.operation.Insertion',
    'text.diff.operation.Deletion'
  );

  /**
   * (Insert class' description here)
   *
   * @purpose  purpose
   */
  class Difference extends Object {
    
    /**
     * (Insert method's description here)
     *
     * @param   string[] from
     * @param   string[] to
     * @return  
     */
    public static function between(array $from, array $to) {
      $r= array();
      for ($f= 0, $t= 0, $s= min(sizeof($from), sizeof($to)); $t < $s && $f < $s; $f++, $t++) {
        if ($from[$f] === $to[$t]) {
          $r[]= new Copy($from[$f]);
          continue;
        }
        
        $changes= array();
        
        // Look ahead in <to> until we find common elements again.
        // Everything inbetween has been inserted in <to>
        for ($i= $t; $i < sizeof($to); $i++) {
          if ($from[$f] !== $to[$i]) {
            $changes[]= new Insertion($to[$i]);
            continue;
          }
          $r= array_merge($r, $changes);
          $t= $i- 1;       // Advance offset in <to>
          continue 2;
        }
          
        // Look ahead in <from> until we find common elements again.
        // Everything inbetween has been deleted in <to>
        for ($i= $f; $i < sizeof($from); $i++) {
          if ($to[$t] !== $from[$i]) {
            $changes[]= new Deletion($from[$i]);
            continue;
          }
          $r= array_merge($r, $changes);
          $f= $i- 1;       // Advance offset in <from>
          continue 2;
        }
        
        // Look ahead in both <from> and <to>.
        for ($common= FALSE, $i= 0; $i < min($s- $t, $s- $f) && !$common; $i++) {
          if ($from[$f+ $i] !== $to[$t+ $i]) {
            $r[]= new Change($from[$f+ $i], $to[$t+ $i]);
            continue;
          }
          $f+= $i- 1;       // Advance offset in <from>
          $t+= $i- 1;       // Advance offset in <to>
          continue 2;
        }
      }
      
      // Check leftover elements at end in both <from> and <to>
      if (sizeof($to) > $s) {
        for ($i= $t; $i < sizeof($to); $i++) {
          $r[]= new Insertion($to[$i]);
        }
      } else if (sizeof($from) > $s) {
        for ($i= $f; $i < sizeof($from); $i++) {
          $r[]= new Deletion($from[$i]);
        }
      }
      
      return $r;
    }
  }
?>
