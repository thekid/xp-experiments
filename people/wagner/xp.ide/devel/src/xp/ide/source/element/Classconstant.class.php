<?php
/* This class is part of the XP framework
 *
 * $Id: Classmember.class.php 11324 2009-08-13 17:58:23Z ruben $ 
 */
  $package="xp.ide.source.element";

  uses(
    'xp.ide.source.Element',
    'xp.ide.source.Scope'
  );

  /**
   * Source tree reprensentation
   *
   * @purpose  IDE
   */
  class xp·ide·source·element·Classconstant extends xp·ide·source·Element {
    private
      $name= '';

    public function __construct($name= '') {
      $this->name= $name;
    }

    public function equals($o) {
      return $this->name === $o->getName();
    }

    public function setName($name) {
      $this->name= $name;
    }

    public function getName() {
      return $this->name;
    }
  }

?>
