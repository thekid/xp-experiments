<?php
/* This class is part of the XP framework
 *
 * $Id$ 
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
  class xp·ide·source·element·Classmember extends xp·ide·source·Element {
    private
      $name= '',
      $init=  NULL;

    public function __construct($name= '', $init= NULL) {
      $this->name= $name;
      $this->init= $init;
    }

    public function equals($o) {
      if (!$o instanceof self) return FALSE;
      return $this->name === $o->getName();
    }

    public function setName($name) {
      $this->name= $name;
    }

    public function getName() {
      return $this->name;
    }

    public function setInit($init) {
      $this->init= $init;
    }

    public function getInit() {
      return $this->init;
    }
  }

?>
