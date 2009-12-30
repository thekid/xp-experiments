<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   */
  class Visitor extends Object {

    /**
     * Visit an annotation
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitAnnotation(AnnotationNode $node) {
      $this->visitAll((array)$node->parameters);
    }

    /**
     * Visit an array access
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitArrayAccess(ArrayAccessNode $node) {
      $this->visitOne($node->offset);
    }

    /**
     * Visit an array
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitArray(ArrayNode $node) {
      $this->visitAll((array)$node->values);
    }

    /**
     * Visit an assignment
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitAssignment(AssignmentNode $node) {
      $this->visitOne($node->variable);
      $this->visitOne($node->expression);
    }

    /**
     * Visit a binary op
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitBinaryOp(BinaryOpNode $node) {
      $this->visitOne($node->lhs);
      $this->visitOne($node->rhs);
    }

    /**
     * Visit an boolean
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitBoolean(BooleanNode $node) {
      // NOOP
    }

    /**
     * Visit a boolean operation
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitBooleanOp(BooleanOpNode $node) {
      $this->visitOne($node->lhs);
      $this->visitOne($node->rhs);
    }

    /**
     * Visit an break statement
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitBreak(BreakNode $node) {
      // NOOP
    }

    /**
     * Visit an case statement (inside a switch)
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitCase(CaseNode $node) {
      $this->visitOne($node->expression);
      $this->visitAll((array)$node->statements);
    }

    /**
     * Visit a cast expression
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitCast(CastNode $node) {
      $this->visitOne($node->expression);
    }

    /**
     * Visit catch
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitCatch(CatchNode $node) {
      $this->visitAll((array)$node->statements);
    }

    /**
     * Visit a chain
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitChain(ChainNode $node) {
      $this->visitAll((array)$node->elements);
    }

    /**
     * Visit a class member
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitClassMember(ClassMemberNode $node) {
      $this->visitOne($node->member);
    }

    /**
     * Visit a class declaration
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitClass(ClassNode $node) {
      $this->visitAll((array)$declaration->body);
    }

    /**
     * Visit a clone expression
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitClone(CloneNode $node) {
      $this->visitOne($node->expression);
    }

    /**
     * Visit a comparison
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitComparison(ComparisonNode $node) {
      $this->visitOne($node->lhs);
      $this->visitOne($node->rhs);
    }

    /**
     * Visit a constant literal
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitConstant(ConstantNode $node) {
      // NOOP
    }

    /**
     * Visit a constructor
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitConstructor(ConstructorNode $node) {
      $this->visitAll((array)$declaration->body);
    }

    /**
     * Visit a continue statement
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitContinue(ContinueNode $node) {
      // NOOP
    }

    /**
     * Visit a decimal literal
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitDecimal(DecimalNode $node) {
      // NOOP
    }

    /**
     * Visit default (inside switch)
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitDefault(DefaultNode $node) {
      $this->visitAll((array)$node->statements);
    }

    /**
     * Visit a do ... while loop
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitDo(DoNode $node) {
      $this->visitAll((array)$node->statements);
      $this->visitOne($node->expression);
    }

    /**
     * Visit an else block
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitElse(ElseNode $node) {
      $this->visitAll((array)$node->statements);
    }

    /**
     * Visit an enum member
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitEnumMember(EnumMemberNode $node) {
      $this->visitAll((array)$node->body);
    }

    /**
     * Visit an enum declaration
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitEnum(EnumNode $node) {
      $this->visitAll((array)$node->body);
    }

    /**
     * Visit a field declaration
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitField(FieldNode $node) {
      $node->initialization && $this->emitOne($node->initialization);
    }

    /**
     * Visit a finally block
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitFinally(FinallyNode $node) {
      $this->visitAll((array)$node->statements);
    }

    /**
     * Visit a for statement
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitFor(ForNode $node) {
      $this->visitAll((array)$node->initialization);
      $this->visitAll((array)$node->condition);
      $this->visitAll((array)$node->loop);
      $this->visitAll((array)$node->statements);
    }

    /**
     * Visit an annotation
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitForeach(ForeachNode $node) {
      isset($node->assignment['key']) && $this->visitOne(new VariableNode($node->assignment['key']));
      $this->visitOne(new VariableNode($node->assignment['value']));
      $this->visitAll((array)$node->statements);
    }

    /**
     * Visit an hex literal
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitHex(HexNode $node) {
      // NOOP
    }

    /**
     * Visit an annotation
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitIf(IfNode $node) {
      $this->visitOne($node->condition);
      $this->visitAll((array)$node->statements);
      $node->otherwise && $this->visitOne($node->otherwise);
    }

    /**
     * Visit an import
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitImport(ImportNode $node) {
      // NOOP
    }

    /**
     * Visit an indexer declaration
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitIndexer(IndexerNode $node) {
      $this->visitAll((array)$node->handlers);
    }

    /**
     * Visit an instance creation
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitInstanceCreation(InstanceCreationNode $node) {
      $this->visitAll((array)$node->parameters);
    }

    /**
     * Visit an instanceof statement
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitInstanceOf(InstanceOfNode $node) {
      $this->visitOne($node->expression);
    }

    /**
     * Visit an integer literal
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitInteger(IntegerNode $node) {
      // NOOP
    }

    /**
     * Visit an interface declaration
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitInterface(InterfaceNode $node) {
      $this->visitAll((array)$node->body);
    }

    /**
     * Visit an invocation
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitInvocation(InvocationNode $node) {
      $this->visitAll((array)$node->parameters);
    }

    /**
     * Visit a lambda
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitLambda(LambdaNode $node) {
      $this->visitAll((array)$node->parameters);
      $this->visitAll((array)$node->statements);
    }

    /**
     * Visit a map declaration
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitMap(MapNode $node) {
      $this->visitAll((array)$node->elements);
    }

    /**
     * Visit a map declaration
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitMethod(MethodNode $node) {
      $this->visitAll((array)$node->body);
    }

    /**
     * Visit a native import
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitNativeImport(NativeImportNode $node) {
      // NOOP
    }

    /**
     * Visit a NOOP
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitNoop(NoopNode $node) {
      // NOOP (d'uh)
    }

    /**
     * Visit a NULL literal
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitNull(NullNode $node) {
      // NOOP
    }

    /**
     * Visit an operator
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitOperator(OperatorNode $node) {
      $this->visitAll((array)$node->body);
    }

    /**
     * Visit a package declaration
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitPackage(PackageNode $node) {
      // NOOP
    }

    /**
     * Visit a property
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitProperty(PropertyNode $node) {
      $this->visitAll((array)$node->handlers);
    }

    /**
     * Visit a map declaration
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitReturn(ReturnNode $node) {
      $node->expression && $this->visitOne($node->expression);
    }

    /**
     * Visit a statements list
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitStatements(StatementsNode $node) {
      $this->visitAll((array)$node->list);
    }

    /**
     * Visit a static import
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitStaticImport(StaticImportNode $node) {
      // NOOP
    }

    /**
     * Visit a statements list
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitStaticInitializer(StaticInitializerNode $node) {
      $this->visitAll((array)$node->statements);
    }

    /**
     * Visit a string literal
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitString(StringNode $node) {
      // NOOP
    }

    /**
     * Visit a switch statement
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitSwitch(SwitchNode $node) {
      $this->vistOne($node->expression);
      $this->visitAll((array)$node->cases);
    }

    /**
     * Visit a ternary operator
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitTernary(TernaryNode $node) {
      $this->vistOne($node->condition);
      $this->vistOne($node->expression ? $node->expression : $node->condition);
      $this->vistOne($node->conditional);
    }

    /**
     * Visit a ternary operator
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitThrow(ThrowNode $node) {
      $this->visitOne($node->expression);
    }

    /**
     * Visit a try statement
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitTry(TryNode $node) {
      $this->visitAll((array)$node->statements);
      $this->visitAll((array)$node->handling);
    }

    /**
     * Visit a unary operator
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitUnaryOp(UnaryOpNode $node) {
      $this->visitOne($node->expression);
    }

    /**
     * Visit a variable
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitVariable(VariableNode $node) {
      // NOOP
    }

    /**
     * Visit a while loop
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitWhile(WhileNode $node) {
      $this->visitOne($op, $node->expression);
      $this->visitAll($op, (array)$node->statements);
    }

    /**
     * Visit a with statement
     *
     * @param   xp.compiler.ast.Node node
     */
    protected function visitWith(WithNode $node) {
      $this->visitAll($op, (array)$with->assignments);
      $this->visitAll($op, (array)$with->statements);
    }
    
    /**
     * Visit a node. Delegates to visit*() methods
     *
     * @param   xp.compiler.ast.Node node
     */
    public function visitOne(xp·compiler·ast·Node $node) {
      $target= 'visit'.substr(get_class($node), 0, -strlen('Node'));
      if (!method_exists($this, $target)) {
        throw new IllegalArgumentException('Don\'t know how to visit '.$node->getClassName().'s');
      }
      call_user_func_array(array($this, $target), array($node));
    }

    /**
     * Visit an array of nodes. Delegates to visit*() methods
     *
     * @param   xp.compiler.ast.Node[] nodes
     */
    public function visitAll(array $nodes) {
      foreach ($nodes as $node) {
        $this->visitOne($node);
      }
    }
  }
?>
