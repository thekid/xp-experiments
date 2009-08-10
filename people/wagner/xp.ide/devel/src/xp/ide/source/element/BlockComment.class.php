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
  class xp·ide·source·element·BlockComment extends xp·ide·source·Element {
    private
      $text= '';

    public function setText($text) {
      $this->text= $text;
    }

    public function getText() {
      return $this->text;
    }

  }

?>
