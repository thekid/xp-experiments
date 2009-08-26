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
      $name= '';

    public function __construct($name) {
      $this->name= $name;
    }

    public function setName($name) {
      $this->name= $name;
    }

    public function getName() {
      return $this->name;
    }

  }

?>
