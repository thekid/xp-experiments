<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'util.collections.HashTable', 
    'xp.compiler.types.TypeName',
    'xp.compiler.ast.ArrayNode',
    'xp.compiler.ast.MapNode',
    'xp.compiler.ast.StringNode',
    'xp.compiler.ast.IntegerNode',
    'xp.compiler.ast.HexNode',
    'xp.compiler.ast.DecimalNode',
    'xp.compiler.ast.NullNode',
    'xp.compiler.ast.BooleanNode',
    'xp.compiler.ast.ComparisonNode'
  );

  /**
   * Represents the current scope
   *
   * @test    xp://tests.types.ScopeTest
   */
  class Scope extends Object {
    protected $types= NULL;
    protected $extensions= array();
    public $enclosing= NULL;

    /**
     * Constructor
     *
     */
    public function __construct() {
      $this->types= create('new util.collections.HashTable<xp.compiler.ast.Node, xp.compiler.types.TypeName>()');
    }
    
    /**
     * Add an extension method
     *
     * @param   xp.compiler.types.TypeName type
     * @param   string method method name
     * @param   string class class name
     */
    public function addExtension(TypeName $type, $method, $class) {
      $this->extensions[$type->name.$method->name]= array(
        'method' => $method, 
        'class'  => $class
      );
    }
    
    /**
     * Return whether an extension method is available
     *
     * @param   xp.compiler.types.TypeName type
     * @param   string name method name
     * @return  bool
     */
    public function hasExtension(TypeName $type, $name) {
      if (isset($this->extensions[$type->name.$name])) return TRUE;
      return $this->enclosing ? $this->enclosing->hasExtension($type, $name) : FALSE;
    }

    /**
     * Get an extension method
     *
     * @param   xp.compiler.types.TypeName type
     * @param   string name method name
     * @return  array
     */
    public function getExtension(TypeName $type, $name) {
      if (isset($this->extensions[$type->name.$name])) return $this->extensions[$type->name.$name];
      return $this->enclosing ? $this->enclosing->getExtension($type, $name) : NULL;
    }
    
    /**
     * Set type
     *
     * @param   xp.compiler.ast.Node node
     * @param   xp.compiler.types.TypeName type
     */
    public function setType(xp·compiler·ast·Node $node, TypeName $type) {
      $this->types->put($node, $type);
    }
    
    /**
     * Return a type for a given node
     *
     * @param   xp.compiler.ast.Node node
     * @return  xp.compiler.types.TypeName
     */
    public function typeOf(xp·compiler·ast·Node $node) {
      if ($node instanceof ArrayNode) {
        return new TypeName('var[]');       // FIXME: Component type
      } else if ($node instanceof MapNode) {
        return new TypeName('[var:var]');   // FIXME: Component type
      } else if ($node instanceof StringNode) {
        return new TypeName('string');
      } else if ($node instanceof NaturalNode) {
        return new TypeName('int');
      } else if ($node instanceof DecimalNode) {
        return new TypeName('double');
      } else if ($node instanceof NullNode) {
        return new TypeName('lang.Object');
      } else if ($node instanceof BooleanNode) {
        return new TypeName('bool');
      } else if ($node instanceof ComparisonNode) {
        return new TypeName('bool');
      } else if ($this->types->containsKey($node)) {
        return $this->types[$node];
      }
      return TypeName::$VAR;
    }
  }
?>
