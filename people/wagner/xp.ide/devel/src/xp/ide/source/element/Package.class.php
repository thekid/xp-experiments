<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package="xp.ide.source.element";

  uses(
    'xp.ide.source.Element'
  );

  /**
   * Source tree reprensentation
   *
   * @purpose  IDE
   */
  class xp·ide·source·element·Package extends xp·ide·source·Element {
    private
      $pathname= '';

    public function setPathname($pathname) {
      $this->pathname= $pathname;
    }

    public function getPathname() {
      return $this->pathname;
    }

  }

?>
