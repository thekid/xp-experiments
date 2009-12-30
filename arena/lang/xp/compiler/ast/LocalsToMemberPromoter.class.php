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
     * Promote all variables used inside a node to member variables except for
     * the ones passed in as excludes, returning all replacements.
     *
     * @param   xp.compiler.ast.Node node
     * @return  array<string, bool> excludes
     * @return  array<string, xp.compiler.ast.ChainNode> replaced
     */
    protected function promoteVariablesToMembers($node, $exclude= array()) {
      $replaced= array();
      foreach ((array)$node as $member => $type) {
        if ($type instanceof VariableNode) {
          if (!isset($exclude[$type->name])) {
            $replaced['$'.$type->name]= $node->{$member}= new ChainNode(array(self::$vthis, $type));
          }
        } else if ($type instanceof xp·compiler·ast·Node) {
          $replaced= array_merge($replaced, $this->promoteVariablesToMembers($node->{$member}, $exclude));
        } else if (is_array($type) && !empty($type) && $type[0] instanceof xp·compiler·ast·Node) {
          foreach ($type as $value) {
            $replaced= array_merge($replaced, $this->promoteVariablesToMembers($value, $exclude));
          }
        }
      }
      return $replaced;
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
      return $this->promoteVariablesToMembers($node, $this->excludes);    // FIXME: Use visitor
    }
  }
?>
