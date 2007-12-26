<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'io.collections.iterate.IterationFilter',
    'net.xp_framework.quantum.QuantPatternMatcher'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantPatternFilter extends Object implements IterationFilter {
    public
      $pattern= '',
      $basedir= '';
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct($pattern, $basedir) {
      $this->pattern= new QuantPatternMatcher($pattern);
      $this->basedir= $basedir;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function accept($element) {
      $ds= DIRECTORY_SEPARATOR; // FIXME: Get from environment
      if (0 !== strncmp($element->getURI(), $this->basedir, strlen($this->basedir))) {
        throw new IllegalStateException('Element from wrong base: '.$element->getURI().' vs. '.$this->basedir);
      }
      
      // Strip "basedir" from path and remove trailing directory separators
      $relativeURI= $element->getURI();
      if (strlen($this->basedir)) {
        $relativeURI= rtrim(substr($relativeURI, strlen($this->basedir)+ 1), $ds);
      }
      
      // Convert URI into unix-notation
      if ('/' != $ds) {
        $relativeURI= strtr($relativeURI, $ds, '/');
      }
      $result= $this->pattern->matches($relativeURI);
      return $this->pattern->matches($relativeURI);
    }
  }
?>
