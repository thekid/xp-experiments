<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('xp.compiler.ast.Node', 'xp.compiler.types.TypeName');

  /**
   * Represents a class member:
   *
   * <code>
   *   T::foo();    // ClassMember[T, Invocation[foo, ()]]
   *   T::$foo;     // ClassMember[T, VariableNode[foo]]
   *   T::FOO;      // ClassMember[T, ConstantNode[FOO]]
   *   T::class;    // ClassMember[T, ConstantNode[class]]
   * </code>
   */
  class ClassMemberNode extends xp·compiler·ast·Node {
    public $class;
    public $member;

    /**
     * Constructor
     *
     * @param   xp.compiler.types.TypeName class
     * @param   xp.compiler.ast.Node member
     */
    public function __construct(TypeName $class, xp·compiler·ast·Node $member= NULL) {
      $this->class= $class;
      $this->member= $member;
    }
    
    /**
     * Returns a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      return $this->class->name.'::'.$this->member->hashCode();
    }
  }
?>
