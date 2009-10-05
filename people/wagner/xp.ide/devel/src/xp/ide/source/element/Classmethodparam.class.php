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
  class xp·ide·source·element·Classmethodparam extends xp·ide·source·Element {
    private
      $typehint= '',
      $name= '',
      $init=  NULL;

    public function __construct($name= '', $typehint= NULL) {
      $this->name= $name;
      $this->typehint= $typehint;
    }

    public function equals($o) {
      if (!$o instanceof self) return FALSE;
      return $this->name === $o->getName();
    }

    /**
     * set member $typehint
     * 
     * @param string typehint
     */
    public function setTypehint($typehint) {
      $this->typehint= $typehint;
    }

    /**
     * get member $typehint
     * 
     * @return string
     */
    public function getTypehint() {
      return $this->typehint;
    }

    /**
     * set member $name
     * 
     * @param string name
     */
    public function setName($name) {
      $this->name= $name;
    }

    /**
     * get member $name
     * 
     * @return string
     */
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
