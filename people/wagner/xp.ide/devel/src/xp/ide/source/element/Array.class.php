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
  class xp·ide·source·element·Array extends xp·ide·source·Element {
    private
      $values= array();

    public function __construct(array $values= array()) {
      $this->values= $values;
    }

    public function setValues(array $values) {
      $this->values= $values;
    }

    public function getValues() {
      return $this->values;
    }
  }

?>
