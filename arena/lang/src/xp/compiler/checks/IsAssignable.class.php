<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.checks.Check', 'xp.compiler.ast.AssignmentNode');

  /**
   * Check whether a node is writeable - that is: can be the left-hand
   * side of an assignment
   *
   */
  class IsAssignable extends Object implements Check {

    /**
     * Return node this check works on
     *
     * @return  lang.XPClass<? extends xp.compiler.ast.Node>
     */
    public function node() {
      return XPClass::forName('xp.compiler.ast.AssignmentNode');
    }
    
    /**
     * Check whether a node is writeable - that is: can be the left-hand
     * side of an assignment
     *
     * @param   xp.compiler.ast.Node node
     * @return  bool
     */
    protected function isWriteable($node) {
      if ($node instanceof VariableNode || $node instanceof ArrayAccessNode) {
        return TRUE;
      } else if ($node instanceof ClassMemberNode) {
        return $this->isWriteable($node->member);
      } else if ($node instanceof ChainNode) {
        return $this->isWriteable($node->elements[sizeof($node->elements)- 1]);
      } else if ($node instanceof DynamicVariableReferenceNode) {
        return TRUE;
      }
      return FALSE;
    }
    
    /**
     * Executes this check
     *
     * @param   xp.compiler.ast.Node node
     * @param   xp.compiler.types.Scope scope
     * @return  bool
     */
    public function verify(xp·compiler·ast·Node $node, Scope $scope) {
      $a= cast($node, 'xp.compiler.ast.AssignmentNode');
      if (!$this->isWriteable($a->variable)) {
        return array('A403', 'Cannot assign to '.$a->variable->getClassName().'s');
      }
    }
  }
?>
