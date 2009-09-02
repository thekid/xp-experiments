<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
  $package="xp.ide.source";

  /**
   * source tree visitor
   *
   * @purpose  IDE
   */
  interface xp·ide·source·IElementVisitor {

    public function visit(xp·ide·source·Element $e);

  }
?>
