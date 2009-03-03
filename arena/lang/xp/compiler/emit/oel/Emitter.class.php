<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler.emit.oel';

  uses(
    'xp.compiler.emit.Emitter', 
    'xp.compiler.emit.Strings', 
    'xp.compiler.emit.TypeReference', 
    'xp.compiler.emit.TypeReflection', 
    'xp.compiler.emit.TypeDeclaration', 
    'lang.reflect.Modifiers',
    'util.collections.HashTable'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      oel
   * @see      xp://xp.compiler.ast.Node
   */
  class xp·compiler·emit·oel·Emitter extends Emitter {
    protected 
      $op           = NULL,
      $errors       = array(),
      $class        = array(NULL),
      $package      = array(NULL),
      $imports      = array(NULL),
      $statics      = array(NULL),
      $used         = array(NULL),
      $finalizers   = array(NULL),
      $metadata     = array(NULL),
      $continuation = array(NULL),
      $properties   = array(NULL),
      $declarations = array(NULL),
      $types        = NULL;

    /**
     * Emit uses statements for a given list of types
     *
     * @param   resource op
     * @param   xp.compiler.types.TypeName[] types
     */
    protected function emitUses($op, array $types) {
      if (!$types) return;
      
      $n= 0;
      // DEBUG Console::$err->writeLine('uses(', $types, ')');
      foreach ($types as $type) {
        try {
          $name= $this->resolve($type->name, FALSE)->name();
          oel_push_value($op, $name);
          $n++;
        } catch (Throwable $e) {
          $this->errors[]= $e->toString();
        }      
      }
      oel_add_call_function($op, $n, 'uses');
      oel_add_free($op);
    }
    
    /**
     * Emit invocations
     *
     * @param   resource op
     * @param   xp.compiler.ast.InvocationNode inv
     */
    protected function emitInvocation($op, InvocationNode $inv) {
      if (!isset($this->statics[0][$inv->name])) {
        $this->errors[]= 'Cannot resolve '.$inv->name;
        $inv->free || oel_push_value($op, NULL);        // Prevent fatal
        return;
      }
      $ptr= $this->statics[0][$inv->name];

      // Static method call vs. function call
      $n= $this->emitAll($op, $inv->parameters);
      if (TRUE === $ptr) {
        oel_add_call_function($op, $n, $inv->name);
      } else {
        oel_add_call_method_static($op, $n, $inv->name, $this->resolve($ptr)->literal());
      }
      $inv->free && oel_add_free($op);
    }
    
    /**
     * Emit strings
     *
     * @param   resource op
     * @param   xp.compiler.ast.StringNode str
     */
    protected function emitString($op, StringNode $str) {
      oel_push_value($op, Strings::expandEscapesIn($str->value));
    }

    /**
     * Emit an array (a sequence of elements with a zero-based index)
     *
     * @param   resource op
     * @param   xp.compiler.ast.ArrayNode arr
     */
    protected function emitArray($op, ArrayNode $arr) {
      oel_add_begin_array_init($op);
      foreach ($arr->values as $value) {
        $this->emitOne($op, $value);
        oel_add_array_init_element($op);
      }
      oel_add_end_array_init($op);
    }

    /**
     * Emit constants
     *
     * @param   resource op
     * @param   xp.compiler.ast.ConstantNode num
     */
    protected function emitConstant($op, ConstantNode $const) {
      switch ($const->value) {
        case 'true': oel_push_value($op, TRUE); break;
        case 'false': oel_push_value($op, FALSE); break;
        case 'null': oel_push_value($op, NULL); break;

        // TODO: Warnings?
        default: oel_push_constant($op, $const->value);
      }
    }

    /**
     * Emit numbers
     *
     * @param   resource op
     * @param   xp.compiler.ast.NumberNode num
     */
    protected function emitNumber($op, NumberNode $num) {
      oel_push_value($op, (int)$num->value);
    }
    
    /**
     * Emit a variable. Implements type overloading
     *
     * @param   resource op
     * @param   xp.compiler.ast.VariableNode var
     */
    protected function emitVariable($op, VariableNode $var) {
      oel_add_begin_variable_parse($op);
      oel_push_variable($op, ltrim($var->name, '$'));    // without '$'
      
      // Type overloading: 
      // * $array->length := sizeof($array)
      if ($this->types->containsKey($var)) {
        if (
          $this->types[$var]->isArray() && 
          $var->chained instanceof VariableNode &&
          'length' == $var->chained->name 
        ) {
          oel_add_end_variable_parse($op);
          oel_add_call_function($op, 1, 'sizeof');
          return;
        }
      }
      
      $this->emitChain($op, $var);
      oel_add_end_variable_parse($op);
      $var->free && oel_add_free($op);
    }

    /**
     * Emit a chain
     * 
     * Examples:
     * <code>
     *   $a->property->value;
     *   $a->method()->value;
     *   $a[0];
     *   func()->length;
     *   new Date()->toString();
     *   $class->getMethods()[0];
     * </code>
     * ...or any combination of these.
     *
     * @param   resource op
     * @param   xp.compiler.ast.Node node
     */
    protected function emitChain($op, xp·compiler·ast·Node $node) {
      $c= $node->chained;
      while (NULL !== $c) {
        if ($c instanceof VariableNode) {
          oel_push_property($op, $c->name);
        } else if ($c instanceof ArrayAccessNode) {
          oel_push_value($op, $c->offset->value);
          oel_push_dim($op);
        } else if ($c instanceof InvocationNode) {   // DOES NOT WORK!
          $n= $this->emitAll($op, (array)$c->parameters);
          oel_add_call_method($op, $n, $c->name);
          oel_add_begin_variable_parse($op);
        } else {
          $this->errors[]= 'Unknown chained element '.xp::stringOf($c);
        }
        $c= $c->chained;
      }
    }
    
    /**
     * Evaluate concatenation
     *
     * @param   xp.compiler.ast.ConstantValueNode l
     * @param   xp.compiler.ast.ConstantValueNode r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalConcat(ConstantValueNode $l, ConstantValueNode $r) {
      $l->value .= $r->value;
      return $l;
    }
    
    /**
     * Evaluate addition
     *
     * @param   xp.compiler.ast.ConstantValueNode l
     * @param   xp.compiler.ast.ConstantValueNode r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalAdd(ConstantValueNode $l, ConstantValueNode $r) {
      $l->value += $r->value;
      return $l;
    }

    /**
     * Evaluate subtraction
     *
     * @param   xp.compiler.ast.ConstantValueNode l
     * @param   xp.compiler.ast.ConstantValueNode r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalSubtract(ConstantValueNode $l, ConstantValueNode $r) {
      $l->value -= $r->value;
      return $l;
    }

    /**
     * Evaluate multiplication
     *
     * @param   xp.compiler.ast.ConstantValueNode l
     * @param   xp.compiler.ast.ConstantValueNode r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalMultiply(ConstantValueNode $l, ConstantValueNode $r) {
      $l->value *= $r->value;
      return $l;
    }

    /**
     * Evaluate division
     *
     * @param   xp.compiler.ast.ConstantValueNode l
     * @param   xp.compiler.ast.ConstantValueNode r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalDivide(ConstantValueNode $l, ConstantValueNode $r) {
      $l->value /= $r->value;
      return $l;
    }

    /**
     * Emit binary operation node
     *
     * @param   resource op
     * @param   xp.compiler.ast.BinaryOpNode bin
     */
    protected function emitBinaryOp($op, BinaryOpNode $bin) {
      static $bop= array(
        '~'   => OEL_BINARY_OP_CONCAT,
        '-'   => OEL_BINARY_OP_SUB,
        '+'   => OEL_BINARY_OP_ADD,
        '*'   => OEL_BINARY_OP_MUL,
        '/'   => OEL_BINARY_OP_DIV,
        '%'   => OEL_BINARY_OP_MOD,
      );
      static $lop= array(
        '&&'  => OEL_OP_BOOL_AND,
        '||'  => OEL_OP_BOOL_OR,
      );
      static $optimizable= array(
        '~'   => 'concat',
        '-'   => 'subtract',
        '+'   => 'add',
        '*'   => 'multiply',
        '/'   => 'divide',
      );      
      
      // Check for optimization possibilities if left- and righthand sides are constant values
      if (isset($optimizable[$bin->op]) && $bin->lhs instanceof ConstantValueNode && $bin->rhs instanceof ConstantValueNode) {
        if (NULL !== ($r= call_user_func_array(array($this, 'eval'.$optimizable[$bin->op]), array($bin->lhs, $bin->rhs)))) {
          $this->emitOne($op, $r);
          return;
        }
      }
      
      // Check for logical operations. TODO: LogicalOperationNode?
      if (isset($lop[$bin->op])) {
        $this->emitOne($op, $bin->lhs);
        oel_add_begin_logical_op($op, $lop[$bin->op]);
        $this->emitOne($op, $bin->rhs);
        oel_add_end_logical_op($op);
      } else {
        $this->emitOne($op, $bin->rhs);
        $this->emitOne($op, $bin->lhs);
        oel_add_binary_op($op, $bop[$bin->op]);
      }
      $bin->free && oel_add_free($op);
    }

    /**
     * Emit unary operation node
     *
     * @param   resource op
     * @param   xp.compiler.ast.UnaryOpNode un
     */
    protected function emitUnaryOp($op, UnaryOpNode $un) {
      static $ops= array(
        '++'   => array(TRUE => OEL_OP_POST_INC, FALSE => OEL_OP_PRE_INC),
        '--'   => array(TRUE => OEL_OP_POST_DEC, FALSE => OEL_OP_PRE_DEC),
      );
      
      if ('!' === $un->op) {      // FIXME: Use NotNode for this?
        $this->emitOne($op, $un->expression);
        oel_add_unary_op($op, OEL_UNARY_OP_BOOL_NOT);
        return;
      } else if ('-' == $un->op) {
        $this->emitOne($op, new BinaryOpNode(array(
          'lhs' => $un->expression,
          'rhs' => new NumberNode(array('value' => -1)),
          'op'  => '*'
        )));
        return;
      } else if (!$un->expression instanceof VariableNode) {
        $this->errors[]= 'Cannot perform unary '.$un->op.' on '.xp::stringOf($un->expression);
        return;
      }

      oel_add_begin_variable_parse($op);
      oel_push_variable($op, ltrim($un->expression->name, '$'));    // without '$'
      oel_add_incdec_op($op, $ops[$un->op][$un->postfix]);
      $un->free && oel_add_free($op);
    }

    /**
     * Emit ternary operator node
     *
     * Note: The following two are equivalent:
     * <code>
     *   $a= $b ?: $c;
     *   $a= $b ? $b : $c;
     * </code>
     *
     * @param   resource op
     * @param   xp.compiler.ast.TernaryNode ternary
     */
    protected function emitTernary($op, TernaryNode $ternary) {
      $this->emitOne($op, $ternary->condition);
      oel_add_begin_tenary_op($op);                   // FIXME: Name should be te*r*nary
      $this->emitOne($op, $ternary->expression ? $ternary->expression : $ternary->condition);
      oel_add_end_tenary_op_true($op);
      $this->emitOne($op, $ternary->conditional);
      oel_add_end_tenary_op_false($op);
    }

    /**
     * Emit comparison node
     *
     * @param   resource op
     * @param   xp.compiler.ast.ComparisonNode cmp
     */
    protected function emitComparison($op, ComparisonNode $cmp) {
      static $ops= array(
        '=='   => array(FALSE, OEL_BINARY_OP_IS_EQUAL),
        '!='   => array(FALSE, OEL_BINARY_OP_IS_NOT_EQUAL),
        '<='   => array(FALSE, OEL_BINARY_OP_IS_SMALLER_OR_EQUAL),
        '<'    => array(FALSE, OEL_BINARY_OP_IS_SMALLER),
        '>='   => array(TRUE, OEL_BINARY_OP_IS_SMALLER_OR_EQUAL),
        '>'    => array(TRUE, OEL_BINARY_OP_IS_SMALLER),
      );

      $operator= $ops[$cmp->op];
      if ($operator[0]) {
        $this->emitOne($op, $cmp->lhs);
        $this->emitOne($op, $cmp->rhs);
      } else {
        $this->emitOne($op, $cmp->rhs);
        $this->emitOne($op, $cmp->lhs);
      }
      oel_add_binary_op($op, $operator[1]);
    }

    /**
     * Emit continue statement
     *
     * @param   resource op
     * @param   xp.compiler.ast.ContinueNode statement
     */
    protected function emitContinue($op, ContinueNode $statement) {
      $this->continuation[0] && $this->emitAll($op, $this->continuation[0]);
      oel_add_continue($op);
    }

    /**
     * Emit break statement
     *
     * @param   resource op
     * @param   xp.compiler.ast.BreakNode statement
     */
    protected function emitBreak($op, BreakNode $statement) {
      oel_add_break($op);
    }

    /**
     * Emit foreach loop
     *
     * @param   resource op
     * @param   xp.compiler.ast.ForeachNode loop
     */
    protected function emitForeach($op, ForeachNode $loop) {

      // Special case when iterating on variables: Do not end variable parse 
      if ($loop->expression instanceof VariableNode) {
        oel_add_begin_variable_parse($op);
        oel_push_variable($op, ltrim($loop->expression->name, '$'));    // without '$'
        $this->emitChain($op, $loop->expression);
      } else {
        $this->emitOne($op, $loop->expression);
      }
      oel_add_begin_foreach($op); {
        oel_add_begin_variable_parse($op);
        oel_push_variable($op, ltrim($loop->assignment, '$'));
        oel_push_value($op, NULL);
      }
      oel_add_begin_foreach_body($op); {
        $this->emitAll($op, (array)$loop->statements);
      }
      oel_add_end_foreach($op);
    }

    /**
     * Emit while loop
     *
     * @param   resource op
     * @param   xp.compiler.ast.WhileNode loop
     */
    protected function emitWhile($op, WhileNode $loop) {
      oel_add_begin_while($op);
      $this->emitOne($op, $loop->expression);
      oel_add_begin_while_body($op); {
        $this->emitAll($op, $loop->statements);
      }
      oel_add_end_while($op);
    }

    /**
     * Emit for loop
     *
     * @param   resource op
     * @param   xp.compiler.ast.ForNode loop
     */
    protected function emitFor($op, ForNode $loop) {
      $this->emitAll($op, (array)$loop->initialization);

      array_unshift($this->continuation, $loop->loop);
      oel_add_begin_while($op);
      $this->emitAll($op, (array)$loop->condition);
      oel_add_begin_while_body($op); {
        $this->emitAll($op, (array)$loop->statements);
        $this->emitAll($op, (array)$loop->loop);
      }
      array_shift($this->continuation);
      oel_add_end_while($op);
    }
    
    /**
     * Emit if statement
     *
     * @param   resource op
     * @param   xp.compiler.ast.IfNode if
     */
    protected function emitIf($op, IfNode $if) {
      $this->emitOne($op, $if->condition);
      oel_add_begin_if($op); {
        $this->emitAll($op, (array)$if->statements);
      } oel_add_end_if($op); {
        $if->otherwise && $this->emitAll($op, (array)$if->otherwise->statements);
      }
      oel_add_end_else($op);
    }

    /**
     * Emit a switch case
     *
     * @param   resource op
     * @param   xp.compiler.ast.CaseNode case
     */
    protected function emitCase($op, CaseNode $case) {
      $this->emitOne($op, $case->expression);
      oel_add_begin_case($op);
      $this->emitAll($op, (array)$case->statements);
      oel_add_end_case($op);
    }

    /**
     * Emit the switch default case
     *
     * @param   resource op
     * @param   xp.compiler.ast.DefaultNode default
     */
    protected function emitDefault($op, DefaultNode $default) {
      oel_add_begin_default($op);
      $this->emitAll($op, (array)$default->statements);
      oel_add_end_default($op);
    }

    /**
     * Emit switch statement
     *
     * @param   resource op
     * @param   xp.compiler.ast.SwitchNode switch
     */
    protected function emitSwitch($op, SwitchNode $switch) {
      $this->emitOne($op, $switch->expression);
      oel_add_begin_switch($op);
      $this->emitAll($op, (array)$switch->cases);
      oel_add_end_switch($op);
    }
    
    /**
     * Emit class members, for example:
     * <code>
     *   XPClass::forName();    // static method call
     *   self::$class;          // special "class" member
     *   self::$instance;       // static member variable
     * </code>
     *
     * @param   resource op
     * @param   xp.compiler.ast.ClassMemberNode ref
     */
    protected function emitClassMember($op, ClassMemberNode $ref) {
      if ($ref->member instanceof InvocationNode) {

        // Static method call
        $n= $this->emitAll($op, (array)$ref->member->parameters);
        oel_add_call_method_static($op, $n, $ref->member->name, $this->resolve($ref->class->name)->literal());
      } else if ($ref->member instanceof VariableNode && '$class' === $ref->member->name) {
      
        // Magic "class" member
        oel_push_value($op, $this->resolve($ref->class->name)->literal());
        oel_add_new_object($op, 1, 'XPClass');
      } else if ($ref->member instanceof VariableNode) {
      
        // Static member
        oel_add_begin_variable_parse($op);
        oel_push_variable($op, ltrim($ref->member->name, '$'), $ref->class->name);   // without '$'
        oel_add_end_variable_parse($op);
      } else {
        $this->errors[]= 'Cannot emit class member '.xp::stringOf($ref->member);
        return;
      }

      if ($ref->member->chained) {
        oel_add_begin_variable_parse($op);
        $this->emitChain($op, $ref->member);
        oel_add_end_variable_parse($op);
      }
      $ref->free && oel_add_free($op);
    }
    
    /**
     * Emit a try / catch block
     * 
     * Simple form:
     * <code>
     *   try {
     *     // [...statements...]
     *   } catch (lang.Throwable $e) {
     *     // [...error handling...]
     *   }
     * </code>
     *
     * Multiple catches:
     * <code>
     *   try {
     *     // [...statements...]
     *   } catch (lang.IllegalArgumentException $e) {
     *     // [...error handling for IAE...]
     *   } catch (lang.FormatException $e) {
     *     // [...error handling for FE...]
     *   }
     * </code>
     *
     * Try/finally without catch:
     * <code>
     *   try {
     *     // [...statements...]
     *   } finally {
     *     // [...finalizations...]
     *   }
     * </code>
     *
     * Try/finally with catch:
     * <code>
     *   try {
     *     // [...statements...]
     *   } catch (lang.Throwable $e) {
     *     // [...error handling...]
     *   } finally {
     *     // [...finalizations...]
     *   }
     * </code>
     *
     * @param   resource op
     * @param   xp.compiler.ast.TryNode try
     */
    protected function emitTry($op, TryNode $try) {

      // Check whether a finalization handler is available. If so, because
      // the underlying runtime does not support this, add statements after
      // the try block and to all catch blocks
      $numHandlers= sizeof($try->handling);
      if ($try->handling[$numHandlers- 1] instanceof FinallyNode) {
        array_unshift($this->finalizers, array_pop($try->handling));
        $numHandlers--;
      } else {
        array_unshift($this->finalizers, NULL);
      }

      oel_add_begin_tryblock($op); {
        $this->emitAll($op, (array)$try->statements);
        $this->finalizers[0] && $this->emitOne($op, $this->finalizers[0]);
        
        // FIXME: If no exception is thrown, we hang here forever
        oel_add_new_object($op, 0, 'Exception');
        oel_add_throw($op);
      }
      oel_add_begin_catchblock($op); {
      
        // First catch. FIXME: Case with try / finally, there is not first catch, 
        // we need to create one!
        oel_add_begin_firstcatch(
          $op, 
          $this->resolve($try->handling[0]->type->name)->literal(), 
          ltrim($try->handling[0]->variable, '$')
        ); {
          $this->emitAll($op, (array)$try->handling[0]->statements);
          $this->finalizers[0] && $this->emitOne($op, $this->finalizers[0]);
        }
        oel_add_end_firstcatch($op);
        
        // Additional catches
        for ($i= 1; $i < $numHandlers; $i++) {
          oel_add_begin_catch(
            $op, 
            $this->resolve($try->handling[$i]->type->name)->literal(), 
            ltrim($try->handling[$i]->variable, '$')
          ); {
            $this->emitAll($op, (array)$try->handling[$i]->statements);
            $this->finalizers[0] && $this->emitOne($op, $this->finalizers[0]);
          }
          oel_add_end_catch($op);
        }
        
        // FIXME: Catch exception which ensures we exit the try block
        oel_add_begin_catch($op, 'Exception', '__e');
        oel_add_end_catch($op);
      }
      oel_add_end_catchblock($op);
      
      array_shift($this->finalizers);
    }

    /**
     * Emit a throw node
     *
     * @param   resource op
     * @param   xp.compiler.ast.ThrowNode throw
     */
    protected function emitThrow($op, ThrowNode $throw) {
      $this->emitOne($op, $throw->expression);
      oel_add_throw($op);
    }

    /**
     * Emit a finallyNode node
     *
     * @param   resource op
     * @param   xp.compiler.ast.FinallyNode throw
     */
    protected function emitFinally($op, FinallyNode $finally) {
      $this->emitAll($op, (array)$finally->statements);
    }

    /**
     * Emit an instance creation node
     *
     * @param   resource op
     * @param   xp.compiler.ast.InstanceCreationNode new
     */
    protected function emitInstanceCreation($op, InstanceCreationNode $new) {
      static $i= 0;

      $type= $this->resolve($new->type->name);
    
      // Anonymous instance creation:
      // - Create unique classname
      // - Extend parent class if type is a class
      // - Implement type and extend lang.Object if it's an interface 
      if (isset($new->body)) {
        if (Types::INTERFACE_KIND === $type->kind()) {
          $p= array('parent' => new TypeName('lang.Object'), 'implements' => array($new->type));
        } else if (Types::ENUM_KUND === $type->kind()) {
          $this->errors[]= 'Cannot create anonymous enums';
          return;
        } else {
          $p= array('parent' => $new->type);
        }
        
        $unique= $type->literal().'$'.++$i;
        $this->declarations[0][]= new ClassNode(array_merge($p, array(
          'name'      => new TypeName($unique),
          'anonymous' => TRUE,
          'body'      => $new->body
        )));
        $this->types[$unique]= $type= new TypeReference($unique, Types::CLASS_KIND);
      }
    
      $n= $this->emitAll($op, (array)$new->parameters);
      oel_add_new_object($op, $n, $type->literal());

      oel_add_begin_variable_parse($op);
      $this->emitChain($op, $new);
      oel_add_end_variable_parse($op);
    }
    
    /**
     * Emit an assignment
     *
     * @param   resource op
     * @param   xp.compiler.ast.AssignmentNode assign
     */
    protected function emitAssignment($op, AssignmentNode $assign) {
      static $ops= array(
        '~='   => OEL_BINARY_OP_ASSIGN_CONCAT,
        '-='   => OEL_BINARY_OP_ASSIGN_SUB,
        '+='   => OEL_BINARY_OP_ASSIGN_ADD,
        '*='   => OEL_BINARY_OP_ASSIGN_MUL,
        '/='   => OEL_BINARY_OP_ASSIGN_DIV,
        '%='   => OEL_BINARY_OP_ASSIGN_MOD,
      );

      if (!$assign->variable instanceof VariableNode) {
        $this->errors[]= 'Cannot assign to '.xp::stringOf($assign);
        return;
      }

      $this->emitOne($op, $assign->expression);
      $this->types[$assign->variable]= $this->typeOf($assign->expression);

      oel_add_begin_variable_parse($op);
      oel_push_variable($op, ltrim($assign->variable->name, '$'));    // without '$'
      $this->emitChain($op, $assign->variable);
      
      isset($ops[$assign->op]) ? oel_add_binary_op($op, $ops[$assign->op]) : oel_add_assign($op);
      $assign->free && oel_add_free($op);
    }

    /**
     * Emit an operator
     *
     * @param   resource op
     * @param   xp.compiler.ast.OperatorNode method
     */
    protected function emitOperator($op, OperatorNode $operator) {
      $this->errors[]= 'Operator overloading not supported '.xp::stringOf($operator);
    }
    
    /**
     * Emit method arguments
     *
     * @param   resource op
     * @param   array<string, *>[] arguments
     */
    protected function emitArguments($op, array $arguments) {
      foreach ($arguments as $i => $arg) {
        if (isset($arg['vararg'])) {
          oel_add_call_function($op, 0, 'func_get_args');
          if ($i > 0) {
            oel_push_value($op, 0);
            oel_push_value($op, $i);
            oel_add_call_function($op, 3, 'array_splice');
          }
          oel_add_begin_variable_parse($op);
          oel_push_variable($op, substr($arg['name'], 1));          // without '$'
          oel_add_assign($op);
          oel_add_free($op);
          break;
        }
        oel_add_receive_arg($op, $i + 1, substr($arg['name'], 1));  // without '$'
        $this->types[new VariableNode($arg['name'])]= $arg['type'];
      }
    }

    /**
     * Emit a method
     *
     * @param   resource op
     * @param   xp.compiler.ast.MethodNode method
     */
    protected function emitMethod($op, MethodNode $method) {
      $meta= array(
        DETAIL_ARGUMENTS    => array(),
        DETAIL_RETURNS      => $method->returns->name,
        DETAIL_THROWS       => array(),
        DETAIL_COMMENT      => '',
        DETAIL_ANNOTATIONS  => array()
      );

      if (Modifiers::isAbstract($method->modifiers)) {
        // FIXME segfault $mop= oel_new_abstract_method(
        $mop= oel_new_method(
          $op, 
          $method->name, 
          FALSE,          // Returns reference
          Modifiers::isStatic($method->modifiers),
          $method->modifiers
        );
      } else {
        $mop= oel_new_method(
          $op, 
          $method->name, 
          FALSE,          // Returns reference
          Modifiers::isStatic($method->modifiers),
          $method->modifiers,
          Modifiers::isFinal($method->modifiers)
        );
      }
      
      // Annotations.
      foreach ((array)$method->annotations as $annotation) {
        $params= array();
        foreach ($annotation->parameters as $name => $value) {
          if ($value instanceof ClassMemberNode) {    // class literal
            $params[$name]= $this->resolve($value->class->name)->name();
          } else if ($value instanceof StringNode) {
            $params[$name]= $value->value;
          }
        }

        if (!$annotation->parameters) {
          $meta[DETAIL_ANNOTATIONS][$annotation->type]= NULL;
        } else if (isset($annotation->parameters['default'])) {
          $meta[DETAIL_ANNOTATIONS][$annotation->type]= $params['default'];
        } else {
          $meta[DETAIL_ANNOTATIONS][$annotation->type]= $params;
        }
      }

      // Arguments
      $method->arguments && $this->emitArguments($mop, $method->arguments);
      $method->body && $this->emitAll($mop, $method->body);
      oel_finalize($mop);
      $this->metadata[0][1][$method->name]= $meta;
    }

    /**
     * Emit a constructor
     *
     * @param   resource op
     * @param   xp.compiler.ast.ConstructorNode constructor
     */
    protected function emitConstructor($op, ConstructorNode $constructor) {
      $cop= oel_new_method(
        $op, 
        '__construct', 
        FALSE,          // Returns reference
        FALSE,          // Constructor can never be static
        $constructor->modifiers,
        Modifiers::isFinal($constructor->modifiers)
      );

      // Arguments
      $constructor->arguments && $this->emitArguments($cop, $constructor->arguments);
      $constructor->body && $this->emitAll($cop, $constructor->body);
      oel_finalize($cop);
    }
    
    /**
     * Emits class registration
     *
     * <code>
     *   xp::$registry['class.'.$name]= $qualified;
     *   xp::$registry['details.'.$name]= $meta;
     * </code>
     *
     * @param   resource op
     * @param   string name
     * @param   string qualified
     */
    protected function registerClass($op, $name, $qualified) {
      // DEBUG Console::$err->writeLine('R@', $name, '= ', $qualified);

      oel_push_value($op, 'class.'.$name);
      oel_push_value($op, $qualified);
      oel_add_call_method_static($op, 2, 'registry', 'xp');
      oel_add_free($op);

      oel_push_value($op, 'details.'.$qualified);
      oel_push_value($op, $this->metadata[0]);
      oel_add_call_method_static($op, 2, 'registry', 'xp');
      oel_add_free($op);
    }

    /**
     * Emit a class property
     *
     * @param   resource op
     * @param   xp.compiler.ast.PropertyNode property
     */
    protected function emitProperty($op, PropertyNode $property) {
      if ('this' === $property->name && $property->arguments) {

        // Indexer - fixme: Maybe use IndexerPropertyNode?
        oel_add_implements_interface($op, 'ArrayAccess');
        
        foreach (array(
          'get'   => array('offsetGet', $property->arguments),
          'set'   => array('offsetSet', array_merge($property->arguments, array(array('name' => '$value', 'type' => $property->type)))),
          'isset' => array('offsetExists', $property->arguments),
          'unset' => array('offsetUnset', $property->arguments),
        ) as $handler => $def) {
          $iop= oel_new_method(
            $op, 
            $def[0], 
            FALSE,          // Returns reference
            FALSE,          // Static
            $property->modifiers
          );
          foreach ($def[1] as $i => $arg) {
            oel_add_receive_arg($iop, $i + 1, substr($arg['name'], 1));  // without '$'
            $this->types[new VariableNode($arg['name'])]= $arg['type'];
          }
          $this->emitAll($iop, $property->handlers[$handler]);
          oel_finalize($iop);
        }
      } else {
        foreach ($property->handlers as $name => $statements) {   
          $this->properties[0][$name][$property->name]= $statements;
        }
      }
    }    

    /**
     * Emit class properties.
     *
     * Creates the equivalent of the following: 
     * <code>
     *   public function __get($name) {
     *     if ('length' === $name) {
     *       return $this->_length;
     *     } else if ('chars' === $name) {
     *       return str_split($this->buffer);
     *     }
     *   }
     * </code>
     *
     * @param   resource op
     * @param   array<string, array<string, xp.compiler.ast.Node[]>> properties
     */
    protected function emitProperties($op, array $properties) {
      static $mangled= "\0name";
      
      if (isset($properties['get'])) {
        $gop= oel_new_method($op, '__get', FALSE, FALSE, MODIFIER_PUBLIC, FALSE);
        oel_add_receive_arg($gop, 1, $mangled);
        
        foreach ($properties['get'] as $name => $statements) {
          oel_push_value($gop, $name);
          oel_add_begin_variable_parse($gop);
          oel_push_variable($gop, $mangled);
          oel_add_end_variable_parse($gop);
          oel_add_binary_op($gop, OEL_BINARY_OP_IS_IDENTICAL);
          oel_add_begin_if($gop); {
            $this->emitAll($gop, (array)$statements);
          }
          oel_add_end_if($gop); 
        }
        for ($i= 0, $s= sizeof($properties['get']); $i < $s; $i++) {
          oel_add_end_else($gop);
        }
        oel_finalize($gop);
      }
      if (isset($properties['set'])) {
        $sop= oel_new_method($op, '__set', FALSE, FALSE, MODIFIER_PUBLIC, FALSE);
        oel_add_receive_arg($sop, 1, $mangled);
        oel_add_receive_arg($sop, 2, 'value');
        
        foreach ($properties['set'] as $name => $statements) {
          oel_push_value($sop, $name);
          oel_add_begin_variable_parse($sop);
          oel_push_variable($sop, $mangled);
          oel_add_end_variable_parse($sop);
          oel_add_binary_op($sop, OEL_BINARY_OP_IS_IDENTICAL);
          oel_add_begin_if($sop); {
            $this->emitAll($sop, (array)$statements);
          }
          oel_add_end_if($sop); 
        }
        for ($i= 0, $s= sizeof($properties['set']); $i < $s; $i++) {
          oel_add_end_else($sop);
        }
        oel_finalize($sop);
      }
    }
    
    /**
     * Emit a class field
     *
     * @param   resource op
     * @param   xp.compiler.ast.FieldNode field
     */
    protected function emitField($op, FieldNode $field) {
      oel_add_declare_property(
        $op, 
        ltrim($field->name, '$'),
        NULL,           // Initial value
        Modifiers::isStatic($field->modifiers),
        $field->modifiers
      );
      
      // TODO: field initialization. For statics, we can use __static(),
      // for other properties, we need to initialize them in the 
      // constructor. For constant values, we might as well initialize
      // them right here
    }

    /**
     * Emit an enum declaration
     *
     * Basic form:
     * <code>
     *   public enum Day { MON, TUE, WED, THU, FRI, SAT, SUN }
     * </code>
     *
     * With values:
     * <code>
     *   public enum Coin { penny(1), nickel(2), dime(10), quarter(25) }
     * </code>
     *
     * Abstract:
     * <code>
     *   public abstract enum Operation {
     *     plus {
     *       public int evaluate(int $x, int $y) { return $x + $y; }
     *     },
     *     minus {
     *       public int evaluate(int $x, int $y) { return $x - $y; }
     *     };
     *
     *     public abstract int evaluate(int $x, int $y);
     *   }
     * </code>
     *
     * @see     
     * @param   resource op
     * @param   xp.compiler.ast.EnumNode declaration
     */
    protected function emitEnum($op, EnumNode $declaration) {
      $parent= $declaration->parent ? $declaration->parent : new TypeName('lang.Enum');
      
      // Ensure parent class and interfaces are loaded
      $this->emitUses($op, array_merge(
        array($parent), 
        (array)$declaration->implements
      ));

      $abstract= Modifiers::isAbstract($declaration->modifiers);
      if ($abstract) {
        // FIXME segfault oel_add_begin_abstract_class_declaration($op, $declaration->name->name, $this->resolve($parent));
        oel_add_begin_class_declaration($op, $declaration->name->name, $this->resolve($parent->name)->literal());
      } else {
        oel_add_begin_class_declaration($op, $declaration->name->name, $this->resolve($parent->name)->literal());
      }
      array_unshift($this->class, $declaration->name->name);
      array_unshift($this->metadata, array(array(), array()));
      array_unshift($this->properties, array('get' => array(), 'set' => array()));

      // Interfaces
      foreach ($declaration->implements as $type) {
        oel_add_implements_interface($op, $this->resolve($type->name, FALSE)->literal());
      }
      
      // Member declaration
      $classes= array();
      foreach ($declaration->body['members'] as $member) { 
        oel_add_declare_property($op, $member->name, NULL, TRUE, MODIFIER_PUBLIC);
        $classes[]= $member->body ? $this->class[0].'$'.$member->name : $this->class[0];
      }
      
      // public static self[] values() { return parent::membersOf(__CLASS__) }
      $vop= oel_new_method($op, 'values', FALSE, TRUE, MODIFIER_PUBLIC, FALSE);
      oel_push_value($vop, $this->class[0]);
      oel_add_call_method_static($vop, 1, 'membersOf', 'parent');
      oel_add_return($vop);
      oel_finalize($vop);

      // Members
      $this->emitAll($op, (array)$declaration->body['fields']);
      $this->emitAll($op, (array)$declaration->body['methods']);
      $this->emitProperties($op, $this->properties[0]);

      // Static initializer (FIXME: Should be static function __static)
      if ($abstract) {      
        // FIXME segfault oel_add_end_abstract_class_declaration($op);
        oel_add_end_class_declaration($op);
        
        foreach ($declaration->body['members'] as $i => $member) { 
          oel_add_begin_class_declaration($op, $classes[$i], $this->class[0]);
          $this->emitAll($op, $member->body['methods']);
          oel_add_end_class_declaration($op);
        }
      } else {      
        oel_add_end_class_declaration($op);
      }
      
      foreach ($declaration->body['members'] as $i => $member) { 
        if ($member->value) {
          $this->emitOne($op, $member->value);
        } else {
          oel_push_value($op, $i);
        }
        oel_push_value($op, $member->name);
        oel_add_new_object($op, 2, $classes[$i]);
        
        oel_add_begin_variable_parse($op);
        oel_push_variable($op, $member->name, $this->class[0]);
        oel_add_assign($op);
        oel_add_free($op);
      }
      
      $this->registerClass($op, $this->class[0], ($this->package[0] ? $this->package[0].'.' : '').$declaration->name->name);
      array_shift($this->properties);
      array_shift($this->metadata);
      array_shift($this->class);
    }

    /**
     * Emit a Interface declaration
     *
     * @param   resource op
     * @param   xp.compiler.ast.InterfaceNode declaration
     */
    protected function emitInterface($op, InterfaceNode $declaration) {
      
      // Ensure parent interfaces are loaded
      $this->emitUses($op, (array)$declaration->parents);

      oel_add_begin_interface_declaration($op, $declaration->name->name);
      array_unshift($this->class, $declaration->name->name);
      array_unshift($this->metadata, array(array(), array()));

      foreach ((array)$declaration->parents as $type) {
        oel_add_parent_interface($op, $this->resolve($type->name, FALSE)->literal());
      }

      $this->emitAll($op, (array)$declaration->body['methods']);
      
      oel_add_end_interface_declaration($op);
      $this->registerClass($op, $this->class[0], ($this->package[0] ? $this->package[0].'.' : '').$declaration->name->name);
      array_shift($this->metadata);
      array_shift($this->class);
    }

    /**
     * Emit a class declaration
     *
     * @param   resource op
     * @param   xp.compiler.ast.ClassNode declaration
     */
    protected function emitClass($op, ClassNode $declaration) {
      $parent= $declaration->parent ? $declaration->parent : new TypeName('lang.Object');
    
      // Ensure parent class and interfaces are loaded
      $declaration->anonymous || $this->emitUses($op, array_merge(
        array($parent), 
        (array)$declaration->implements
      ));
    
      $abstract= Modifiers::isAbstract($declaration->modifiers);
      if ($abstract) {
        // FIXME segfault oel_add_begin_abstract_class_declaration($op, $declaration->name->name, $this->resolve($parent));
        oel_add_begin_class_declaration($op, $declaration->name->name, $this->resolve($parent->name, FALSE)->literal());
      } else {
        oel_add_begin_class_declaration($op, $declaration->name->name, $this->resolve($parent->name, FALSE)->literal());
      }
      array_unshift($this->class, $declaration->name->name);
      array_unshift($this->metadata, array(array(), array()));
      array_unshift($this->properties, array());

      // Interfaces
      foreach ($declaration->implements as $type) {
        oel_add_implements_interface($op, $this->resolve($type->name, FALSE)->literal());
      }
      
      // Members
      $this->emitAll($op, (array)$declaration->body['fields']);
      $this->emitAll($op, (array)$declaration->body['methods']);
      $this->emitProperties($op, $this->properties[0]);

      // Static initializer blocks (array<Statement[]>)
      if (isset($declaration->body['static'])) {
        $sop= oel_new_method($op, '__static', FALSE, TRUE, MODIFIER_PUBLIC, FALSE);
        foreach ($declaration->body['static'] as $statements) {
          $this->emitAll($sop, (array)$statements);
        }
        oel_finalize($sop);
      }
      
      // Finish
      if ($abstract) {
        // FIXME segfault oel_add_end_abstract_class_declaration($op);
        oel_add_end_class_declaration($op);
      } else {
        oel_add_end_class_declaration($op);
      }
      $this->registerClass($op, $this->class[0], ($this->package[0] ? $this->package[0].'.' : '').$declaration->name->name);
      array_shift($this->properties);
      array_shift($this->metadata);
      array_shift($this->class);
    }

    /**
     * Emit instanceof
     *
     * @param   resource op
     * @param   xp.compiler.ast.InstanceOfNode instanceof
     */
    protected function emitInstanceOf($op, InstanceOfNode $instanceof) {
      $this->emitOne($op, $instanceof->expression);
      oel_add_instanceof($op, $this->resolve($instanceof->type->name)->literal());
      $instanceof->free && oel_add_free($op);
    }

    /**
     * Emit import
     *
     * @param   resource op
     * @param   xp.compiler.ast.ImportNode import
     */
    protected function emitImport($op, ImportNode $import) {
      if ('.*' == substr($import->name, -2)) {
        foreach (Package::forName(substr($import->name, 0, -2))->getClassNames() as $name) {
          $this->imports[0][xp::reflect($name)]= $name;
        }
      } else {
        $this->imports[0][xp::reflect($import->name)]= $import->name;
      }
    }

    /**
     * Emit native import
     *
     * @param   resource op
     * @param   xp.compiler.ast.NativeImportNode import
     */
    protected function emitNativeImport($op, NativeImportNode $import) {
      if ('.*' == substr($import->name, -2)) {
        $r= new ReflectionExtension(substr($import->name, 0, -2));
        foreach ($r->getFunctions() as $f) {
          $this->statics[0][$f->getName()]= TRUE;
        }
      } else {
        $p= strrpos($import->name, '.');
        $f= substr($import->name, $p+ 1);
        $r= new ReflectionExtension(substr($import->name, 0, $p));
        $l= $r->getFunctions();
        if (!isset($l[$f])) {
          throw new IllegalArgumentException('Function '.$f.' does not exist in '.$r->getName());
        }
        $this->statics[0][$l[$f]->getName()]= TRUE;
      }
    }
    
    /**
     * Emit static import
     *
     * Given the following:
     * <code>
     *   import static rdbms.criterion.Restrictions.*;
     * </code>
     *
     * A call to lessThanOrEqualTo() "function" then resolves to a static
     * method call to Restrictions::lessThanOrEqualTo()
     *
     * @param   resource op
     * @param   xp.compiler.ast.StaticImportNode import
     */
    protected function emitStaticImport($op, StaticImportNode $import) {
      if ('.*' == substr($import->name, -2)) {
        $name= substr($import->name, 0, -2);
        $class= XPClass::forName($name);   // TODO: Other sources
        foreach ($class->getMethods() as $method) {
          if (!Modifiers::isStatic($method->getModifiers())) continue;
          $this->statics[0][$method->getName()]= $class->getName();
        }
      } else {
        $p= strrpos($import->name, '.');
        $class= XPClass::forName(substr($import->name, 0, $p));   // TODO: Other sources
        $method= $class->getMethod(substr($import->name, $p+ 1));
        $this->statics[0][$method->getName()]= $class->getName();
      }
    }

    /**
     * Emit a return statement
     * <code>
     *   return;                // void return
     *   return [EXPRESSION];   // returning a value
     * </code>
     *
     * @param   resource op
     * @param   xp.compiler.ast.ReturnNode new
     */
    protected function emitReturn($op, ReturnNode $return) {
      $this->finalizers[0] && $this->emitOne($op, $this->finalizers[0]);
      
      // Special case when returning variables: Do not end variable parse 
      if ($return->expression instanceof VariableNode) {
        oel_add_begin_variable_parse($op);
        oel_push_variable($op, ltrim($return->expression->name, '$'));    // without '$'
        $this->emitChain($op, $return->expression);
      } else if ($return->expression) {
        $this->emitOne($op, $return->expression);
      } else {
        oel_push_value($op, NULL);
      }
      
      oel_add_return($op);
    }
    
    /**
     * Emit a single node
     *
     * @param   resource op
     * @param   xp.compiler.ast.Node node
     * @return  int
     */
    protected function emitOne($op, xp·compiler·ast·Node $node) {
      $target= 'emit'.substr(get_class($node), 0, -strlen('Node'));
      if (method_exists($this, $target)) {
        oel_set_source_line($op, $node->position[0]);
        // DEBUG Console::$err->writeLine('@', $node->position[0], ' Emit ', $node->getClassName(), '<', $node->free, '> ', $node->hashCode());
        try {
          call_user_func_array(array($this, $target), array($op, $node));
        } catch (Throwable $e) {
          $this->errors[]= $e->toString();
          return 0;
        }
        return 1;
      } else {
        $this->errors[]= 'Cannot emit '.xp::stringOf($node);
        return 0;
      }
    }
    
    /**
     * Emit all given nodes
     *
     * @param   resource op
     * @param   xp.compiler.ast.Node[] nodes
     * @return  int
     */
    protected function emitAll($op, array $nodes) {
      $emitted= 0;
      foreach ((array)$nodes as $node) {
        $emitted+= $this->emitOne($op, $node);
      }
      return $emitted;
    }

    /**
     * Return a type for a given node
     *
     * @param   xp.compiler.ast.Node node
     * @return  xp.compiler.types.TypeName
     */
    protected function typeOf(xp·compiler·ast·Node $node) {
      if ($node instanceof ArrayNode) {
        return new TypeName('*[]');     // FIXME: Component type
      } else if ($node instanceof StringNode) {
        return new TypeName('string');
      } else if ($node instanceof NumberNode) {
        return new TypeName('int');     // FIXME: Floats
      } else if ($node instanceof VariableNode) {
        return $this->types->containsKey($node) ? $this->types[$node] : new TypeName(NULL);
      } else {
        // DEBUG Console::$err->writeLine('Warning: Cannot determine type for '.xp::stringOf($node));
        return new TypeName(NULL);
      }
    }

    /**
     * Locate class file
     *
     * @param   string qualified
     * @return  string uri
     */
    protected function locate($qualified) {
      $name= DIRECTORY_SEPARATOR.strtr($qualified, '.', DIRECTORY_SEPARATOR).'.xp';
      foreach (xp::$registry['classpath'] as $path) {
        if (file_exists($uri= $path.$name)) return $uri;
      }
      return NULL;
    }
    
    /**
     * Resolve a class name
     *
     * @param   string name
     * @param   bool register
     * @return  xp.compiler.emit.Types resolved
     */
    protected function resolve($name, $register= TRUE) {
      if ('self' === $name || $name === $this->class[0]) {
        return new TypeReference($this->class[0]);
      } else if (strpos($name, '.')) {
        $qualified= $name;
      } else if (isset($this->imports[0][$name])) {
        $qualified= $this->imports[0][$name];
      } else {
        $this->errors[]= 'Cannot resolve class '.$name;
        return new TypeReference($name, Types::UNKNOWN_KIND);
      }
      
      // Locate class. If the classloader already knows this class,
      // we can simply use this class. TODO: Use specialized 
      // JitClassLoader?
      if (!$this->types->containsKey($qualified)) {
        if (ClassLoader::getDefault()->providesClass($qualified)) {
          $this->types[$qualified]= new TypeReflection(XPClass::forName($qualified));
        } else {
          if (!($uri= $this->locate($qualified))) {
            $this->errors[]= 'Cannot find class '.$qualified;
            return new TypeReference($qualified, Types::UNKNOWN_KIND);;
          }

          try {
            $tree= create(new Parser())->parse(new xp·compiler·Lexer(
              FileUtil::getContents(new File($uri)),
              $uri
            ));
          } catch (ParseException $e) {
            $this->errors[]= $e->compoundMessage();
            return NULL;
          } catch (IOException $e) {
            $this->errors[]= $e->compoundMessage();
            return NULL;
          }

          $this->emit($tree);
          $this->types[$qualified]= new TypeDeclaration($tree);
          $register= FALSE;     // Don't register this class as it cannot be written yet
        }
        $register && $this->used[0][]= new TypeName($qualified);
        // DEBUG Console::$err->writeLine('Determined<', $register, '> @ ', $qualified, '= ', $this->types[$qualified]);
      }
      
      return $this->types[$qualified];
    }
    
    /**
     * Entry point
     *
     * @param   xp.compiler.ast.ParseTree tree
     * @return  string class name
     */
    public function emit(ParseTree $tree) {
      $this->errors= array();
      $this->types= new HashTable();
      
      // Create and initialize op array
      $op= oel_new_op_array();
      oel_set_source_file($op, $tree->origin);
      oel_set_source_line($op, 0);
      
      // Imports
      array_unshift($this->used, array());
      array_unshift($this->imports, array());
      array_unshift($this->statics, array());
      array_unshift($this->package, $tree->package ? $tree->package->name : NULL);
      array_unshift($this->declarations, array($tree->declaration));

      // Import and declarations
      $this->emitAll($op, (array)$tree->imports);
      while ($decl= array_pop($this->declarations[0])) {
        $this->emitOne($op, $decl);
      }

      // Load used classes
      $this->emitUses($op, $this->used[0]);
      
      // Check on errors
      if ($this->errors) {
        throw new FormatException(xp::stringOf($this->errors));
      }

      // Finalize
      oel_finalize($op);
      array_shift($this->imports);
      array_shift($this->statics);
      array_shift($this->declarations);
      array_shift($this->package);
      array_shift($this->used);

      // Execute and return. FIXME: Write to file! But serialization functionality
      // is missing in oel at the moment.
      oel_execute($op);
      // DEBUG Reflection::export(new ReflectionClass($tree->declaration->name->name));
      return $tree->declaration->name->name;
    }    
  }
?>
