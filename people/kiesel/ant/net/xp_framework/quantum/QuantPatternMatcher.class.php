<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantPatternMatcher extends Object {
    protected
      $pattern  = NULL,
      $subject  = NULL;
      
    public function __construct($pattern) {
      $this->pattern= explode('/', $pattern);
    }
    
    public function matches($name) {
      $this->subject= explode('/', $name);
      return $this->matchesSegments(0, 0);
    }
    
    protected function matchesSegments($idxPat, $idxSub) {
//      Console::writeLinef('===> Checking i= %d ("%s"), j= %d ("%s")', 
//        $idxPat, 
//        @$this->pattern[$idxPat], 
//        $idxSub, 
//        @$this->subject[$idxSub]
//      );
      
      if ($idxPat == sizeof($this->pattern) && $idxSub == sizeof($this->subject)) return TRUE;
      if (!isset($this->pattern[$idxPat]) || !isset($this->subject[$idxSub])) return FALSE;
      $pattern= $this->pattern[$idxPat];
      $subject= $this->subject[$idxSub];
      
      if ('**' == $pattern) {
        
        // If ** is the last pattern, it would match all following segments
        // but cannot run into the first for-loop, so shortcut here and
        // signal success
        if ($idxPat+ 1 == sizeof($this->pattern)) return TRUE;
        
        // A ** pattern can match arbitrary many elements [0..n] - so fork off
        // another thread of tests here
        for ($i= $idxPat+ 1; $i < sizeof($this->pattern); $i++) {
          for ($j= $idxSub; $j < sizeof($this->subject); $j++) {
            if ($this->matchesSegments($i, $j)) {
              return TRUE;
            }
          }
        }
        
        return 0;
      }
      
      if ($pattern == $subject) {
        return $this->matchesSegments(++$idxPat, ++$idxSub); 
      }
      
      $reg= str_replace(array('.', '#', '?', '*'), array('\\.', '\\#', '.', '.*'), $pattern);
      if (!preg_match('#^'.$reg.'$#', $subject)) return FALSE;
      return $this->matchesSegments(++$idxPat, ++$idxSub);
    }
  }
?>
