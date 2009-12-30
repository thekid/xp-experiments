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

    protected static $vthis;
    
    static function __static() {
      self::$vthis= new VariableNode('this');
    }

    /**
     * Visit a variable
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitVariable(VariableNode $node) {
      $n= $node->name;
      if (!isset($this->excludes[$n])) {
        $this->replacements['$'.$n]= $node= new ChainNode(array(self::$vthis, $node));
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
     * @param   xp.compiler.ast.Node node
     * @return  array<string, xp.compiler.ast.ChainNode> replaced
     */
    public function promote($node) {
      $this->replacements= array();
      $this->visitOne($node);
      return $this->replacements;
    }
  }
?>
