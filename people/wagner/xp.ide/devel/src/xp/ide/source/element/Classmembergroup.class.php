<?php
/* This class is part of the XP framework
 *
 * $Id: Classmember.class.php 11343 2009-08-21 15:47:36Z ruben $ 
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
  class xp·ide·source·element·Classmembergroup extends xp·ide·source·Element {
    private
      $static= FALSE,
      $scope= NULL,
      $members= array();

    public function __construct(xp·ide·source·Scope $scope= NULL, $static= FALSE) {
      $this->scope= NULL === $scope ? xp·ide·source·Scope::$PUBLIC : $scope;
      $this->static= $static;
    }

    public function equals($o) {
      if (!$o instanceof self) return FALSE;
      return $this->scope === $o->getScope()
        && $this->static === $o->isStatic()
      ;
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

    public function setMembers(array $members) {
      $this->members= $members;
    }

    public function getMembers() {
      return $this->members;
    }

    public function getMember($i) {
      return $this->members[$i];
    }
  }

?>
