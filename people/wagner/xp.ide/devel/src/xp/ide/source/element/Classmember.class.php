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
      $scope= NULL;

    public function __construct($name= '', xp·ide·source·Scope $scope= NULL) {
      $this->name= $name;
      $this->scope= $scope;
    }

    public function equals($o) {
      return $this->name === $o->getName() && $this->scope === $o->getScope();
    }

    public function setName($name) {
      $this->name= $name;
    }

    public function getName() {
      return $this->name;
    }

    public function setScope(xp·ide·source·Scope $scope) {
      $this->scope= $scope;
    }

    public function getScope() {
      return $this->scope;
    }

  }

?>
