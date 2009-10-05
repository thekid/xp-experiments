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
  class xp·ide·source·element·Annotation extends xp·ide·source·Element {
    private
      $name= '',
      $params= array();

    public function __construct($name, array $params= array()) {
      $this->name= $name;
      $this->params= $params;
    }

    public function equals($o) {
      if (!$o instanceof self)  return FALSE;
      return $this->name= $o->getName() && $this->params == $o->getParams();
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

    /**
     * set member $params
     * 
     * @param array params
     */
    public function setParams(array $params) {
      $this->params= $params;
    }

    /**
     * get member $params
     * 
     * @return array
     */
    public function getParams() {
      return $this->params;
    }

  }

?>
