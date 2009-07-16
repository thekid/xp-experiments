<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.completion';
  
  /**
   * Autocomleter
   *
   * @purpose  IDE
   */
  abstract class xp·ide·completion·Completer extends Object {
    protected 
      $uncomplete= NULL;

    /**
     * Constructor
     *
     * @param   xp.ide.completion.UncompletePackageClass $uncomplete
     */
    public function __construct(xp·ide·completion·UncompletePackageClass $uncomplete) {
      $this->uncomplete= $uncomplete;
    }

    /**
     * suggestions
     *
     * @return  string[]
     */
    final public function suggest() {
      $packages= $this->elements();
      if ($this->uncomplete->getUncomplete()) $packages= array_filter($packages, array(self, 'filter'));
      sort($packages);
      return $packages;
    }

    /**
     * unfiltered possible elements
     *
     * @return  string[]
     */
    abstract protected function elements();

    /**
     * test if a subpattern matches or not
     *
     * @param   string teststring
     * @return  
     */
    protected function filter($teststring) {
      $pattern= ($this->uncomplete->getComplete() ? $this->uncomplete->getComplete().'.' : '').$this->uncomplete->getUncomplete();
      return 0 == strncmp($teststring, $pattern, strlen($pattern));
    }
      
    /**
     * Set uncomplete
     *
     * @param   lang.Object uncomplete
     */
    public function setUncomplete($uncomplete) {
      $this->uncomplete= $uncomplete;
    }

    /**
     * Get uncomplete
     *
     * @return  lang.Object
     */
    public function getUncomplete() {
      return $this->uncomplete;
    }
  }
?>
