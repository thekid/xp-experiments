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
      $trace && Console::$err->writeLine("\n-------------------------");

      $r= array();
      $sf= sizeof($from);
      $st= sizeof($to);
      for ($f= 0, $t= 0, $s= min($sf, $st); ($t < $st) && ($f < $sf); $t++, $f++) {
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
            $advance['inserted']['t']= $i- $t;
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
            $advance['deleted']['f']= $i- $f;
            break;
          }

          // Look ahead in both <from> and <to> sequentially. We might
          // miss common elements this way, but they're handled later on
          // and will not record as change anyway.
          for ($i= 0; $i < min($st- $t, $sf- $f); $i++) {
            if ($from[$f+ $i] !== $to[$t+ $i]) {
              $changed[]= new Change($from[$f+ $i], $to[$t+ $i]);
              continue;
            }
            $offsets['changed']= $i;
            $advance['changed']['t']= $i;
            $advance['changed']['f']= $i;
            break;
          }
          
          
          // Could not find common elements.
          // 1) Check if we're at the end and the last two elements differ
          //    in this case we have a change at the end of the document
          //    (and not a deletion and then an insertion)
          //
          // 2) Look ahead in both <from> and <to> by using a double loop
          //    which is slow but will definitely find common elements.
          //
          // 3) Break to leftover elements
          //    In case there are any, there are the possibilities that
          //    they were either added or deleted (no changes - there are no
          //    more common elements!)
          if (!$offsets) {
            if ($f == $sf- 1 && $t == $st- 1 && $from[$f] !== $to[$t]) {
              $r[]= new Change($from[$f], $to[$t]);
              $f++; $t++;
              break 2;
            }

            // Look ahead in both <from> and <to> 
            for ($i= $f; $i < $sf; $i++) {
              for ($j= $t; $j < $st; $j++) {
                if ($from[$i] === $to[$j]) {
                  Console::$err->writeLinef(
                    'Next match (f= %d/%d t= %d/%d)',
                    $f, $sf, 
                    $t, $st
                  );
                  
                  while ($f < $i) {
                    $r[]= new Deletion($from[$f++]);
                  }
                  while ($t < $j) {
                    $r[]= new Insertion($to[$t++]);
                  }
                  $f--; $t--;
                  continue 4;
                }
              }
            }

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
        $trace && Console::$err->writeLinef(
          '%s (t+= %d, f+= %d) @ %s',
          $best,
          $advance[$best]['t'], 
          $advance[$best]['f'], 
          xp::stringOf($offsets)
        );
        $r= array_merge($r, ${$best});
        $t+= $advance[$best]['t']- 1;
        $f+= $advance[$best]['f']- 1;
      }
      
      // Check leftover elements at end in both <from> and <to>
      $trace && ($f < $sf || $t < $st) && Console::$err->writeLinef(
        'Leftovers (f= %d/%d t= %d/%d)', 
        $f, $sf, 
        $t, $st
      );
      for ($i= $f; $i < $sf; $i++) {
        $r[]= new Deletion($from[$i]);
      }
      for ($i= $t; $i < $st; $i++) {
        $r[]= new Insertion($to[$i]);
      }
      
      $trace && Console::$err->writeLine($r);
      $trace && Console::$err->writeLine("\n-------------------------");
      return $r;
    }
  }
?>
