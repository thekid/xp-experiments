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
  class xp·ide·source·element·Classdef extends xp·ide·source·Element {
    private
      $name= '',
      $parent= '',
      $interfaces= array(),
      $members= array(),
      $constants= array();

    public function setName($name) {
      $this->name= $name;
    }

    public function getName() {
      return $this->name;
    }

    public function setParent($parent) {
      $this->parent= $parent;
    }

    public function getParent() {
      return $this->parent;
    }

    public function setInterfaces(array $interfaces) {
      $this->interfaces= $interfaces;
    }

    public function getInterfaces() {
      return $this->interfaces;
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

    public function setConstants(array $constants) {
      $this->constants= $constants;
    }

    public function getConstants() {
      return $this->constants;
    }
  }

?>
