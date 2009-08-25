<?php
/* This class is part of the XP framework
 *
 * $Id: ClassPathScanner.class.php 11282 2009-07-22 14:44:48Z ruben $ 
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
  class xp·ide·source·element·ClassFile extends xp·ide·source·Element {
    private
      $package= NULL,
      $header= NULL,
      $uses= NUll,
      $classdef= NUll;

    public function setPackage(xp·ide·source·element·Package $package) {
      $this->package= $package;
    }

    public function getPackage() {
      return $this->package;
    }

    public function setHeader(xp·ide·source·element·BlockComment $header) {
      $this->header= $header;
    }

    public function getHeader() {
      return $this->header;
    }

    public function setUses(xp·ide·source·element·Uses $uses) {
      $this->uses= $uses;
    }

    public function getUses() {
      return $this->uses;
    }

    public function setClassdef(xp·ide·source·element·Classdef $classdef) {
      $this->classdef= $classdef;
    }

    public function getClassdef() {
      return $this->classdef;
    }
  }

?>
