<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.checks.Check', 'xp.compiler.ast.TypeDeclarationNode');

  /**
   * Check whether api documentation is available for a type members, 
   * that is: methods and constructors.
   *
   */
  class TypeMemberHasDocumentation extends Object implements Check {

    /**
     * Return node this check works on
     *
     * @return  lang.XPClass<? extends xp.compiler.ast.Node>
     */
    public function node() {
      return XPClass::forName('xp.compiler.ast.RoutineNode');
    }
    
    /**
     * Executes this check
     *
     * @param   xp.compiler.ast.Node node
     * @return  bool
     */
    public function verify(xp�compiler�ast�Node $node) {
      $member= cast($node, 'xp.compiler.ast.RoutineNode');
      if (!isset($member->comment) && !$member->holder->synthetic) {
        return array('D201', 'No api doc for member '.$member->holder->name->compoundName().'::'.$member->name);
      }
    }
  }
?>