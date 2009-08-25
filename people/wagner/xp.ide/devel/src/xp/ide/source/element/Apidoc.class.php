<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package="xp.ide.source.element";

  uses(
    'xp.ide.source.element.BlockComment'
  );

  /**
   * Source tree reprensentation
   *
   * @purpose  IDE
   */
  class xp·ide·source·element·Apidoc extends xp·ide·source·element·BlockComment {
    private
      $directives= array();

    public function setDirectives(array $directives) {
      $this->directives= $directives;
    }

    public function getDirectives() {
      return $this->directives;
    }

  }

?>
