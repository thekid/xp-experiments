<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.emit.Types');

  /**
   * (Insert class' description here)
   *
   */
  class TypeDeclaration extends Types {
    protected $name= '';
    
    /**
     * Constructor
     *
     * @param   string name
     */
    public function __construct(ParseTree $tree) {
      $this->tree= $tree;
    }
    
    /**
     * Returns name
     *
     * @return  string
     */
    public function name() {
      $n= $this->tree->declaration->name->name;
      if ($this->tree->package) {
        $n= $this->tree->package->name.'.'.$n;
      }
      return $n;
    }

    /**
     * Returns literal for use in code
     *
     * @return  string
     */
    public function literal() {
      return $this->tree->declaration->name->name;
    }

    /**
     * Returns literal for use in code
     *
     * @return  string
     */
    public function kind() {
      switch ($decl= $this->tree->declaration) {
        case $decl instanceof ClassNode: return parent::CLASS_KIND;
        case $decl instanceof InterfaceNode: return parent::INTERFACE_KIND;
        case $decl instanceof EnumNode: return parent::ENUM_KIND;
        default: return parent::UNKNOWN_KIND;
      }
    }
  }
?>
