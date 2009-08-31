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
      $annotations= array(),
      $interfaces= array(),
      $membergroups= array(),
      $methods= array(),
      $constants= array(),
      $content= '',
      $apidoc= NULL,
      $abstract= FALSE;

    public function __construct($name, $parent= 'Object') {
      $this->name= $name;
      $this->parent= $parent;
    }

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

    public function setAnnotations(array $annotations) {
      $this->annotations= $annotations;
    }

    public function getAnnotations() {
      return $this->annotations;
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

    public function setMembergroups(array $membergroups) {
      $this->membergroups= $membergroups;
    }

    public function getMembergroups() {
      return $this->membergroups;
    }

    public function getMembergroup($i) {
      return $this->membergroups[$i];
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

    public function setAbstract($abstract) {
      $this->abstract= $abstract;
    }

    public function isAbstract() {
      return $this->abstract;
    }
  }

?>
