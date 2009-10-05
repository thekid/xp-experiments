<?php
/* This class is part of the XP framework
 *
 * $Id: ClassPathScanner.class.php 11282 2009-07-22 14:44:48Z ruben $ 
 */
  $package="xp.ide.source";

  uses(
    'xp.ide.source.Element'
  );

  /**
   * source representation
   * base object
   *
   * @purpose  IDE
   */
  abstract class xp·ide·source·Snippet extends xp·ide·source·Element {
    protected $element= NULL;

    public function accept(xp·ide·source·IElementVisitor $v) {
      return $this->element->accept($v);
    }
  }

?>
