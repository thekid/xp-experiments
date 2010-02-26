<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.compiler.ast.Visitor',
    'xp.compiler.ast.VariableNode'
  );

  /**
   * Promote all variables used inside a node to member variables except for
   * the ones passed in as excludes, returning all replacements.
   *
   * @test    xp://tests.LocalsToMemberPromoterTest
   */
  class LocalsToMemberPromoter extends Visitor {
    protected $excludes= array('this' => TRUE);
    protected $replacements= array();

    protected static $THIS;
    
    static function __static() {
      self::$THIS= new VariableNode('this');
    }

    /**
     * Visit a variable
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitVariable(VariableNode $node) {
      $n= $node->name;
      if (!isset($this->excludes[$n])) {
        $this->replacements['$'.$n]= $node= new ChainNode(array(self::$THIS, $node));
      }
      return $node;
    }

    /**
     * Visit a chain
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitChain(ChainNode $node) {
      if (self::$THIS->equals($node->elements[0]) && $node->elements[1] instanceof VariableNode) {
      
        // $this->i = Chain(Var(this), Var(i))
        $shift= array(array_shift($node->elements), array_shift($node->elements));
        $node->elements= array_merge($shift, $this->visitAll((array)$node->elements));
        return $node;
      } else {
        return parent::visitChain($node);
      }
    }

    /**
     * Add a variable to exclude from promotion
     *
     * @param   string name
     */
    public function exclude($name) {
      $this->excludes[$name]= TRUE;
    }

    /**
     * Run
     *
     * @param   xp.compiler.ast.Node nodes
     * @return  array<string, xp.compiler.ast.ChainNode> replaced
     */
    public function promote($node) {
      $this->replacements= array();
      $node= $this->visitOne($node);
      return array('replaced' => $this->replacements, 'node' => $node);
    }
  }
?>
