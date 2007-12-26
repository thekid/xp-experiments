<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Pattern matcher, used to match patterns against URIs
   * for Quantum's fileset / patternset logic
   *
   * @test      xp://net.xp_framework.quantum.unittest.QuantumPatternMatcherTest
   * @see       xp://net.xp_framework.quantum.QuantPatternFilter
   * @purpose   Match patterns
   */
  class QuantPatternMatcher extends Object {
    protected
      $pattern  = NULL,
      $subject  = NULL;

    /**
     * Constructor
     *
     * @param   string $pattern
     */
    public function __construct($pattern) {
      $this->pattern= explode('/', $pattern);
      
      // If the last pattern is the zero-length string, convert
      // it to ** - it should match anything at any depth
      if ('' == $this->pattern[sizeof($this->pattern)- 1]) {
        $this->pattern[sizeof($this->pattern)- 1]= '**'; 
      }
    }
    
    /**
     * Public facade of this class. Evaluates whether the given
     * string matches against this pattern.
     * 
     * This method _only_ takes paths in Unix path notation, that
     * is with / as directory separators
     *
     * @param   string $name
     * @return  bool
     */
    public function matches($name) {
      $this->subject= explode('/', $name);
      return $this->matchesSegments(0, 0);
    }
    
    /**
     * Match the pattern with the given index against
     * the segment of the path with the given index.
     * 
     * Calls itself recursively, if the specified pattern can
     * match on arbitrary many segments.
     *
     * @param   int $idxPat
     * @param   int $idxSub
     * @return  bool
     */
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
        
        // A ** pattern can match arbitrary many elements [0..n] - so fork off
        // another thread of tests here
        for ($i= $idxPat+ 1; $i < sizeof($this->pattern); $i++) {
          for ($j= $idxSub; $j < sizeof($this->subject); $j++) {
            if ($this->matchesSegments($i, $j)) {
              return TRUE;
            }
          }
          
          // At this point, all combinations of arbitraty-segment consuming pattern
          // have been matched against all segments, but no single combination had
          // been found which worked. So, signal failure now.
          return FALSE;
        }
        
        // Apparently, the for-loop could not have been taken, so this is the
        // last pattern, and as it matches anything, signal success now.
        return TRUE;
      }
      
      if ($pattern == $subject) {
        return $this->matchesSegments(++$idxPat, ++$idxSub); 
      }
      
      $reg= str_replace(array('.', '#', '?', '*'), array('\\.', '\\#', '.', '.*'), $pattern);
      if (!preg_match('#^'.$reg.'$#', $subject)) return FALSE;
      return $this->matchesSegments(++$idxPat, ++$idxSub);
    }
    
    /**
     * Return string representation
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'@('.$this->hashCode().') { pattern= "'.implode('/', $this->pattern).'" }';
    }
  }
?>
