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
  class xp·ide·source·element·Uses extends xp·ide·source·Element {
    private
      $classnames= array();

    public function __construct(array $classes= array()) {
      $this->classes= $classes;
    }

    public function setClassnames(array $classes) {
      $this->classes= $classes;
    }

    public function getClassnames() {
      return $this->classes;
    }

  }

?>
