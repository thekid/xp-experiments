<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.checks.Check', 'xp.compiler.ast.TypeDeclarationNode');

  /**
   * Check whether api documentation is available for a type, that
   * is: interfaces, classes and enums.
   *
   */
  class TypeHasDocumentation extends Object implements Check {

    /**
     * Return node this check works on
     *
     * @return  lang.XPClass<? extends xp.compiler.ast.Node>
     */
    public function node() {
      return XPClass::forName('xp.compiler.ast.TypeDeclarationNode');
    }
    
    /**
     * Executes this check
     *
     * @param   xp.compiler.ast.Node node
     * @return  bool
     */
    public function verify(xp·compiler·ast·Node $node) {
      $decl= cast($node, 'xp.compiler.ast.TypeDeclarationNode');
      if (!isset($decl->comment) && !$decl->synthetic) {
        return array('D201', 'No api doc for type '.$decl->name->compoundName());
      }
    }
  }
?>
