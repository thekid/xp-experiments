<?php
/* This class is part of the XP framework
 *
 * $Id: ClassPathScanner.class.php 11282 2009-07-22 14:44:48Z ruben $ 
 */
  $package="xp.ide.source";

  /**
   * source tree representation
   * base object
   *
   * @purpose  IDE
   */
  abstract class xp�ide�source�Element extends Object {

    public function accept(xp�ide�source�IElementVisitor $v) {
      return $v->visit($this);
    }

  }

?>