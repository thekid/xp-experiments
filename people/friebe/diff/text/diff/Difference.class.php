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
   * Difference
   *
   * @purpose  Algorithm
   */
  class Difference extends Object {
    
    /**
     * Computes the difference between to string arrays
     *
     * @param   string[] from
     * @param   string[] to
     * @return  text.diff.AbstractOperation[]
     */
    public static function between(array $from, array $to, $trace= FALSE) {
      $r= array();
      $sf= sizeof($from);
      $st= sizeof($to);
      for ($f= 0, $t= 0, $s= min($sf, $st); $t < $s && $f < $s; $f++, $t++) {
        $trace && Console::$err->writeLinef(
          '%d: "%s" =? %d: "%s"',
          $f, addcslashes($from[$f], "\0..\17"),
          $t, addcslashes($to[$t], "\0..\17")
        );
        if ($from[$f] === $to[$t]) {
          $r[]= new Copy($from[$f]);
          continue;
        }
        
        $inserted= $deleted= $changed= $offsets= $advance= array();
        do {
          // Look ahead in <to> until we find common elements again.
          // Everything inbetween has been inserted in <to>
          for ($i= $t; $i < $st; $i++) {
            if ($from[$f] !== $to[$i]) {
              $inserted[]= new Insertion($to[$i]);
              continue;
            }
            $offsets['inserted']= $i- $t;
            $advance['inserted']['t']= $i- $t- 1;
            $advance['inserted']['f']= 0;
            break;
          }

          // Look ahead in <from> until we find common elements again.
          // Everything inbetween has been deleted in <to>
          for ($i= $f; $i < $sf; $i++) {
            if ($to[$t] !== $from[$i]) {
              $deleted[]= new Deletion($from[$i]);
              continue;
            }
            $offsets['deleted']= $i- $f;
            $advance['deleted']['t']= 0;
            $advance['deleted']['f']= $i- $f- 1;
            break;
          }

          // Look ahead in both <from> and <to>.
          for ($i= 0; $i < min($st- $t, $sf- $f); $i++) {
            if ($from[$f+ $i] !== $to[$t+ $i]) {
              $changed[]= new Change($from[$f+ $i], $to[$t+ $i]);
              continue;
            }
            $offsets['changed']= $i;
            $advance['changed']['t']= $i- 1;
            $advance['changed']['f']= $i- 1;
            break;
          }
          
          // Could not find common elements, record last element as change
          // and break to leftover elements
          if (!$offsets) {
            $r[]= new Change($from[$f], $to[$t]);
            $t++; $f++;
            $trace && Console::$err->writeLinef(
              'No more common elements found (f= %d/%d t= %d/%d)', 
              $f, $sf, 
              $t, $st
            );
            break 2;
          }
        } while (0);
        
        // Figure out which look-ahead produced the nearest result
        asort($offsets);
        $best= key($offsets);
        $trace && Console::$err->writeLine($best, '@', $offsets);
        $r= array_merge($r, ${$best});
        $t+= $advance[$best]['t'];
        $f+= $advance[$best]['f'];
      }
      
      // Check leftover elements at end in both <from> and <to>
      if ($st > $s) {
        for ($i= $t; $i < $st; $i++) {
          $r[]= new Insertion($to[$i]);
        }
      } 
      if ($sf > $s) {
        for ($i= $f; $i < $sf; $i++) {
          $r[]= new Deletion($from[$i]);
        }
      }
      
      return $r;
    }
  }
?>
