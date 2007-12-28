<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'text.diff.operation.Change',
    'text.diff.operation.Copy',
    'text.diff.operation.Insertion',
    'text.diff.operation.Deletion',
    'text.diff.source.InputSource'
  );

  /**
   * Difference
   *
   * @purpose  Algorithm
   */
  class Difference extends Object {
    protected
      $op   = array(),
      $from = NULL,
      $to   = NULL;
        
    /**
     * Constructor
     *
     */
    protected function __construct() {
    }

    /**
     * Retrieve "from" source
     *
     * @return  text.diff.source.InputSource
     */
    public function from() {
      return $this->from;
    }

    /**
     * Retrieve "to" source
     *
     * @return  text.diff.source.InputSource
     */
    public function to() {
      return $this->to;
    }
    
    /**
     * Retrieve edit operations
     *
     * @return  text.diff.AbstractOperation[]
     */
    public function operations() {
      return $this->op;
    }

    /**
     * Retrieve whether an object is equal to this
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return (
        $cmp instanceof self && 
        $this->from->equals($cmp->from) && 
        $this->to->equals($cmp->to) &&
        $this->op == $cmp->op
      );
    }
        
    /**
     * Computes the difference between to input sources
     *
     * @param   text.diff.source.InputSource from
     * @param   text.diff.source.InputSource to
     * @return  text.diff.Difference
     */
    public static function between(InputSource $from, InputSource $to) {
      // Console::$err->writeLine("\n-------------------------");

      $sf= $from->size();
      $st= $to->size();
      $op= array();
      for ($f= 0, $t= 0, $s= min($sf, $st); ($t < $st) && ($f < $sf); $t++, $f++) {
        // Console::$err->writeLinef(
        //   '%d: "%s" =? %d: "%s"',
        //   $f, addcslashes($from->item($f), "\0..\17"),
        //   $t, addcslashes($to->item($t), "\0..\17")
        // );
        if ($from->item($f) === $to->item($t)) {
          $op[]= new Copy($from->item($f));
          continue;
        }
        
        $inserted= $deleted= $changed= $offsets= $advance= array();
        do {

          // Look ahead in <to> until we find common elements again.
          // Everything inbetween has been inserted in <to>
          for ($i= $t; $i < $st; $i++) {
            if ($from->item($f) !== $to->item($i)) {
              $inserted[]= new Insertion($to->item($i));
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
            if ($to->item($t) !== $from->item($i)) {
              $deleted[]= new Deletion($from->item($i));
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
            if ($from->item($f+ $i) !== $to->item($t+ $i)) {
              $changed[]= new Change($from->item($f+ $i), $to->item($t+ $i));
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
            if ($f == $sf- 1 && $t == $st- 1 && $from->item($f) !== $to->item($t)) {
              $op[]= new Change($from->item($f), $to->item($t));
              $f++; $t++;
              break 2;
            }

            // Look ahead in both <from> and <to> 
            for ($i= $f; $i < $sf; $i++) {
              for ($j= $t; $j < $st; $j++) {
                if ($from->item($i) === $to->item($j)) {
                  // Console::$err->writeLinef(
                  //   'Next match (f= %d/%d t= %d/%d)',
                  //   $f, $sf, 
                  //   $t, $st
                  // );
                  
                  while ($f < $i) {
                    $op[]= new Deletion($from->item($f++));
                  }
                  while ($t < $j) {
                    $op[]= new Insertion($to->item($t++));
                  }
                  $f--; $t--;
                  continue 4;
                }
              }
            }

            // Console::$err->writeLinef(
            //   'No more common elements found (f= %d/%d t= %d/%d)', 
            //   $f, $sf, 
            //   $t, $st
            // );
            break 2;
          }
        } while (0);
        
        // Figure out which look-ahead produced the nearest result
        asort($offsets);
        $best= key($offsets);
        // Console::$err->writeLinef(
        //   '%s (t+= %d, f+= %d) @ %s',
        //   $best,
        //   $advance[$best]['t'], 
        //   $advance[$best]['f'], 
        //   xp::stringOf($offsets)
        // );
        $op= array_merge($op, ${$best});
        $t+= $advance[$best]['t']- 1;
        $f+= $advance[$best]['f']- 1;
      }
      
      // Check leftover elements at end in both <from> and <to>
      // ($f < $sf || $t < $st) && Console::$err->writeLinef(
      //   'Leftovers (f= %d/%d t= %d/%d)', 
      //   $f, $sf, 
      //   $t, $st
      // );
      for ($i= $f; $i < $sf; $i++) {
        $op[]= new Deletion($from->item($i));
      }
      for ($i= $t; $i < $st; $i++) {
        $op[]= new Insertion($to->item($i));
      }
      
      // Console::$err->writeLine($op);
      // Console::$err->writeLine("\n-------------------------");
      
      $diff= new self();
      $diff->op= $op;
      $diff->from= $from;
      $diff->to= $to;
      return $diff;
    }
  }
?>
