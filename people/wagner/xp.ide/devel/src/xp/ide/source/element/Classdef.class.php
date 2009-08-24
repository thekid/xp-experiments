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
      $methods= array(),
      $constants= array(),
      $content= '',
      $apidoc= NULL;

    public function setApidoc(xp·ide·source·element·Apidoc $apidoc= NULL) {
      $this->apidoc= $apidoc;
    }

    public function getApidoc() {
      return $this->apidoc;
    }

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

    public function setMethods(array $methods) {
      $this->methods= $methods;
    }

    public function getMethods() {
      return $this->methods;
    }

    public function getMethod($i) {
      return $this->methods[$i];
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

    public function setContent($content) {
      $this->content= $content;
    }

    public function getContent() {
      return $this->content;
    }
  }

?>
