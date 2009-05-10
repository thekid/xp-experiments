<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.compiler.emit.Types', 
    'xp.compiler.ast.ParseTree',
    'xp.compiler.ast.ClassNode',
    'xp.compiler.ast.InterfaceNode',
    'xp.compiler.ast.EnumNode'
  );

  /**
   * Represents a declared type
   *
   * @test    xp://tests.types.TypeDeclarationTest
   */
  class TypeDeclaration extends Types {
    protected $tree= NULL;
    protected $parent= NULL;
    
    /**
     * Constructor
     *
     * @param   xp.compiler.ast.ParseTree tree
     * @param   xp.compiler.emit.Types parent
     */
    public function __construct(ParseTree $tree, Types $parent= NULL) {
      $this->tree= $tree;
      $this->parent= $parent;
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

    /**
     * Returns a method by a given name
     *
     * @param   string name
     * @return  bool
     */
    public function hasMethod($name) {
      foreach ($this->tree->declaration->body['methods'] as $member) {
        if ($member instanceof MethodNode && $member->name === $name) return TRUE;
      }
      return $this->parent ? $this->parent->hasMethod($name) : FALSE;
    }
    
    /**
     * Returns a method by a given name
     *
     * @param   string name
     * @return  xp.compiler.emit.Method
     */
    public function getMethod($name) {
      foreach ($this->tree->declaration->body['methods'] as $member) {
        if ($member instanceof MethodNode && $member->name === $name) {
          $m= new xp·compiler·emit·Method();
          $m->name= $member->name;
          $m->returns= $member->returns;
          $m->modifiers= $member->modifiers;
          foreach ($member->parameters as $p) {
            $m->parameters[]= $p->type;
          }
          $m->holder= $this;
          return $m;
        }
      }
      return $this->parent ? $this->parent->getMethod($name) : FALSE;
    }

    /**
     * Returns a field by a given name
     *
     * @param   string name
     * @return  bool
     */
    public function hasField($name) {
      foreach ($this->tree->declaration->body['fields'] as $member) {
        if ($member instanceof FieldNode && $member->name === $name) return TRUE;
      }
      return $this->parent ? $this->parent->hasField($name) : FALSE;
    }
    
    /**
     * Returns a field by a given name
     *
     * @param   string name
     * @return  xp.compiler.emit.Field
     */
    public function getField($name) {
      foreach ($this->tree->declaration->body['fields'] as $member) {
        if ($member instanceof FieldNode && $member->name === $name) {
          $f= new xp·compiler·emit·Field();
          $f->name= $member->name;
          $f->type= $member->type;
          $f->holder= $this;
          return $f;
        }
      }
      return $this->parent ? $this->parent->getField($name) : FALSE;
    }

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */    
    public function toString() {
      return $this->getClassName().'@('.$this->tree->declaration->name->toString().')';
    }
  }
?>
