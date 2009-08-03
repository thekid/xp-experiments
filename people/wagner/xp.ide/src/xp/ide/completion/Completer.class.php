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

    /**
     * suggestions
     *
     * @param   xp.ide.completion.UncompletePackageClass $uncomplete
     * @return  string[]
     */
    final public function suggest(xp·ide·completion·UncompletePackageClass $uncomplete) {
      $packages= $this->elements($uncomplete->getComplete());
      if ($uncomplete->getUncomplete()) {
        foreach ($packages as $i => $package) {
          if (!$this->filter($package, $uncomplete)) unset($packages[$i]);
        }
      }
      sort($packages);
      return $packages;
    }

    /**
     * unfiltered possible elements
     *
     * @param   string $complete
     * @return  string[]
     */
    abstract protected function elements($complete);

    /**
     * test if a subpattern matches or not
     *
     * @param   xp.ide.completion.UncompletePackageClass $searchbase
     * @param   string teststring
     * @return  bool
     */
    protected function filter($teststring, xp·ide·completion·UncompletePackageClass $searchbase) {
      $pattern= ($searchbase->getComplete() ? $searchbase->getComplete().'.' : '').$searchbase->getUncomplete();
      return 0 == strncmp($teststring, $pattern, strlen($pattern));
    }
  }
?>
