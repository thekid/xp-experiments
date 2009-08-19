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
      $static= FALSE,
      $scope= NULL,
      $init=  NULL;

    public function __construct($name= '', xp·ide·source·Scope $scope= NULL, $init= NULL) {
      $this->name= $name;
      $this->scope= $scope;
      $this->init= $init;
    }

    public function equals($o) {
      return $this->name === $o->getName() 
        && $this->scope === $o->getScope()
        && $this->static === $o->isStatic()
      ;
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

    public function setStatic($static) {
      $this->static= $static;
    }

    public function isStatic() {
      return $this->static;
    }

    public function setInit($init) {
      $this->init= $init;
    }

    public function getInit() {
      return $this->init;
    }
  }

?>
