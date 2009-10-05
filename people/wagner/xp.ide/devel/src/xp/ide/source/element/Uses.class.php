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
  class xp·ide·source·element·Uses extends xp·ide·source·Element {
    private
      $classnames= array();

    public function __construct(array $classnames= array()) {
      $this->classnames= $classnames;
    }

    /**
     * set member $classnames
     * 
     * @param array classnames
     */
    public function setClassnames(array $classnames) {
      $this->classnames= $classnames;
    }

    /**
     * get member $classnames
     * 
     * @return array
     */
    public function getClassnames() {
      return $this->classnames;
    }

  }

?>
