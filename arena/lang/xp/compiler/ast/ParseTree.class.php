<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @purpose  Value object
   */
  class ParseTree extends Object {
    public
      $package,
      $imports,
      $declaration;

    /**
     * Creates a string representation of this node.
     *
     * @return  string
     */
    public function toString() {
      return sprintf(
        "%s(package %s)@{\n".
        "  imports     : %s\n".
        "  declaration : %s\n".
        "}",
        $this->getClassName(), 
        $this->package ? $this->package->name : '<main>',
        str_replace("\n", "\n  ", xp::stringOf($this->imports)),
        str_replace("\n", "\n  ", $this->declaration->toString())
      );
    }
  }
?>
