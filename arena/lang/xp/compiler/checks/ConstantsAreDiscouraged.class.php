<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.checks.Check', 'xp.compiler.ast.ConstantNode');

  /**
   * Emits a warning when global constants are used
   *
   */
  class ConstantsAreDiscouraged extends Object implements Check {

    /**
     * Return node this check works on
     *
     * @return  lang.XPClass<? extends xp.compiler.ast.Node>
     */
    public function node() {
      return XPClass::forName('xp.compiler.ast.ConstantNode');
    }
    
    /**
     * Executes this check
     *
     * @param   xp.compiler.ast.Node node
     * @return  bool
     */
    public function verify(xp�compiler�ast�Node $node) {
      return array('T203', 'Global constants ('.cast($node, 'xp.compiler.ast.ConstantNode')->value.') are discouraged');
    }
  }
?>