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
      if (sizeOf($packages) < 2) return $packages;
      sort($packages);
      $base= $packages[0];
      foreach($packages as $package) {
        $new_base= '';
        for ($i= 0; $i < min(strlen($base), strlen($package)); $i++) {
          if ($base{$i} != $package{$i}) break;
          $new_base.= $base{$i};
        }
        $base= $new_base;
      }
      return strlen($base) > strlen($uncomplete->getOrigin()) ? array($base) : $packages;
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
      $pattern= $searchbase->getOrigin();
      return 0 == strncmp($teststring, $pattern, strlen($pattern));
    }
  }
?>
