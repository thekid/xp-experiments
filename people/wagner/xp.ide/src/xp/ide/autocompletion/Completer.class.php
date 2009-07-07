<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.autocompletion';
  
  /**
   * Autocomleter
   *
   * @purpose  IDE
   */
  abstract class xp·ide·autocompletion·Completer extends Object {
    protected 
      $package= '',
      $subpattern= '';

    /**
     * Constructor
     *
     * @param   string package
     * @param   string subpattern
     */
    public function __construct($package= '', $subpattern='') {
      $this->package= $package;
      $this->subpattern= $subpattern;
    }

    /**
     * suggestions
     *
     * @return  string[]
     */
    final public function suggest() {
      $packages= $this->elements();
      if ($this->subpattern) $packages= array_filter($packages, array(self, 'filter'));
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
      $pattern= ($this->package ? $this->package.'.' : '').$this->subpattern;
      return 0 == strncmp($teststring, $pattern, strlen($pattern));
    }
      
    /**
     * Set package
     *
     * @param   string package
     */
    public function setPackage($package) {
      $this->package= $package;
    }

    /**
     * Get package
     *
     * @return  string
     */
    public function getPackage() {
      return $this->package;
    }

    /**
     * Set subpattern
     *
     * @param   string subpattern
     */
    public function setSubpattern($subpattern) {
      $this->subpattern= $subpattern;
    }

    /**
     * Get subpattern
     *
     * @return  string
     */
    public function getSubpattern() {
      return $this->subpattern;
    }
  }
?>
