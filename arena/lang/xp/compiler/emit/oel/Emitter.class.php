<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler.emit.oel';

  uses(
    'xp.compiler.emit.Emitter', 
    'xp.compiler.emit.Strings', 
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
      $class        = array(),
      $finalizers   = array(NULL),
      $continuation = array(NULL),
      $types        = NULL;
    
    protected function emitInvocation($op, $inv) {
      $n= $this->emitAll($op, $inv->parameters);
      oel_add_call_function($op, $n, $inv->name);
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
      static $ops= array(
        '~'   => OEL_BINARY_OP_CONCAT,
        '-'   => OEL_BINARY_OP_SUB,
        '+'   => OEL_BINARY_OP_ADD,
        '*'   => OEL_BINARY_OP_MUL,
        '/'   => OEL_BINARY_OP_DIV,
        '%'   => OEL_BINARY_OP_MOD,
      );
      static $opt= array(
        '~'   => 'concat',
        '-'   => 'subtract',
        '+'   => 'add',
        '*'   => 'multiply',
        '/'   => 'divide',
      );      
      
      // Check for optimization possibilities if left- and righthand sides are constant values
      if (isset($opt[$bin->op]) && $bin->lhs instanceof ConstantValueNode && $bin->rhs instanceof ConstantValueNode) {
        if (NULL !== ($r= call_user_func_array(array($this, 'eval'.$opt[$bin->op]), array($bin->lhs, $bin->rhs)))) {
          $this->emitOne($op, $r);
          return;
        }
      }
      
      $this->emitOne($op, $bin->rhs);
      $this->emitOne($op, $bin->lhs);
      oel_add_binary_op($op, $ops[$bin->op]);
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
      }

      if (!$un->expression instanceof VariableNode) {
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
     * @param   resource op
     * @param   xp.compiler.ast.TernaryNode ternary
     */
    protected function emitTernary($op, TernaryNode $ternary) {
      $this->emitOne($op, $ternary->condition);
      oel_add_begin_tenary_op($op);                   // FIXME: Name should be te*r*nary
      $this->emitOne($op, $ternary->expression);
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
      $this->emitOne($op, $loop->expression);
      oel_add_begin_foreach($op); {
        oel_add_begin_variable_parse($op);
        oel_push_variable($op, ltrim($loop->assignment, '$'));
        oel_push_value($op, NULL);
      }
      oel_add_begin_foreach_body($op); {
        $this->emitAll($op, $loop->statements);
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
        $this->emitAll($op, (array)$if->otherwise->statements);
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
        oel_add_call_method_static($op, $n, $ref->member->name, $this->resolve($ref->class->name));
        $ref->free && oel_add_free($op);
      } else if ($ref->member instanceof VariableNode && '$class' === $ref->member->name) {
      
        // Magic "class" member
        oel_push_value($op, $this->resolve($ref->class->name));
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
      
        // First catch
        oel_add_begin_firstcatch(
          $op, 
          $this->resolve($try->handling[0]->type->name), 
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
            $this->resolve($try->handling[$i]->type->name), 
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
      $n= $this->emitAll($op, (array)$new->parameters);
      oel_add_new_object($op, $n, $this->resolve($new->type->name));

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
      if (!$assign->variable instanceof VariableNode) {
        $this->errors[]= 'Cannot assign to '.xp::stringOf($assign);
        return;
      }

      $this->emitOne($op, $assign->expression);
      $this->types[$assign->variable]= $this->typeOf($assign->expression);

      oel_add_begin_variable_parse($op);
      oel_push_variable($op, ltrim($assign->variable->name, '$'));    // without '$'
      $this->emitChain($op, $assign->variable);
      oel_add_assign($op);    // TODO: depending on $assign->op, use other assignments
      $assign->free && oel_add_free($op);
    }

    /**
     * Emit a method
     *
     * @param   resource op
     * @param   xp.compiler.ast.MethodNode method
     */
    protected function emitMethod($op, MethodNode $method) {
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

      // Arguments
      foreach ((array)$method->arguments as $i => $arg) {
        oel_add_receive_arg($mop, $i + 1, substr($arg['name'], 1));  // without '$'
        $this->types[new VariableNode($arg['name'])]= $arg['type'];
      }

      $method->body && $this->emitAll($mop, $method->body);
      oel_finalize($mop);
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
      foreach ($constructor->arguments as $i => $arg) {
        oel_add_receive_arg($cop, $i + 1, substr($arg['name'], 1));  // without '$'
        $this->types[new VariableNode($arg['name'])]= $arg['type'];
      }

      $constructor->body && $this->emitAll($cop, $constructor->body);
      oel_finalize($cop);
    }
    
    /**
     * Emits class registration
     *
     * <code>
     *   xp::$registry['class.'.$name]= $qualified;
     * </code>
     *
     * @param   resource op
     * @param   string name
     * @param   string qualified
     */
    protected function registerClass($op, $name, $qualified) {
      oel_push_value($op, 'class.'.$name);
      oel_push_value($op, $qualified);
      oel_add_call_method_static($op, 2, 'registry', 'xp');
      oel_add_free($op);
    }
    
    /**
     * Emit a class field
     *
     * @param   resource op
     * @param   xp.compiler.ast.ConstructorNode constructor
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
      $abstract= Modifiers::isAbstract($declaration->modifiers);
      $parent= $declaration->parent ? $declaration->parent->name : 'lang.Enum';
      if ($abstract) {
        // FIXME segfault oel_add_begin_abstract_class_declaration($op, $declaration->name->name, $this->resolve($parent));
        oel_add_begin_class_declaration($op, $declaration->name->name, $this->resolve($parent));
      } else {
        oel_add_begin_class_declaration($op, $declaration->name->name, $this->resolve($parent));
      }
      array_unshift($this->class, $this->resolve($declaration->name->name));

      // Interfaces
      foreach ($declaration->implements as $type) {
        oel_add_implements_interface($op, $this->resolve($type->name));
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

      // Methods
      $this->emitAll($op, (array)$declaration->body['methods']);

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
      
      $this->registerClass($op, $this->class[0], $declaration->name->name);
      array_shift($this->class);
    }

    /**
     * Emit a class declaration
     *
     * @param   resource op
     * @param   xp.compiler.ast.ClassNode declaration
     */
    protected function emitClass($op, ClassNode $declaration) {
      $abstract= Modifiers::isAbstract($declaration->modifiers);
      $parent= $declaration->parent ? $declaration->parent->name : 'lang.Object';
      if ($abstract) {
        // FIXME segfault oel_add_begin_abstract_class_declaration($op, $declaration->name->name, $this->resolve($parent));
        oel_add_begin_class_declaration($op, $declaration->name->name, $this->resolve($parent));
      } else {
        oel_add_begin_class_declaration($op, $declaration->name->name, $this->resolve($parent));
      }
      array_unshift($this->class, $this->resolve($declaration->name->name));

      // Interfaces
      foreach ($declaration->implements as $type) {
        oel_add_implements_interface($op, $this->resolve($type->name));
      }
      
      // Members
      $this->emitAll($op, (array)$declaration->body['fields']);
      $this->emitAll($op, (array)$declaration->body['methods']);
      
      // Finish
      if ($abstract) {
        // FIXME segfault oel_add_end_abstract_class_declaration($op);
        oel_add_end_class_declaration($op);
      } else {
        oel_add_end_class_declaration($op);
      }
      $this->registerClass($op, $this->class[0], $declaration->name->name);
      array_shift($this->class);
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
      $return->expression && $this->emitOne($op, $return->expression);
      
      // Special case when returning variables: Do not end variable parse 
      // but instead call free on result. Seems weird but has to do with
      // how variables are internally handled!
      if ($return->expression instanceof VariableNode) {
        oel_add_begin_variable_parse($op);
        oel_push_variable($op, ltrim($return->expression->name, '$'));    // without '$'
        $this->emitChain($op, $return->expression);
        oel_add_free($op);
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
        // DEBUG Console::$err->writeLine('@', $node->position[0], ' Emit ', $node->getClassName(), ' ', $node->hashCode());
        try {
          call_user_func_array(array($this, $target), array($op, $node));
        } catch (Throwable $e) {
          $this->errors[]= $e->getMessage();
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
     * Resolve a class name
     *
     * @param   string name
     * @return  string resolved
     */
    protected function typeOf(xp·compiler·ast·Node $node) {
      if ($node instanceof ArrayNode) {
        return new TypeName('*[]');     // FIXME: Component type
      } else if ($node instanceof StringNode) {
        return new TypeName('string');
      } else if ($node instanceof NumberNode) {
        return new TypeName('int');     // FIXME: Floats
      } else if ($node instanceof VariableNode) {
        return $this->types[$node];
      } else {
        // DEBUG Console::$err->writeLine('Warning: Cannot determine type for '.xp::stringOf($node));
        return new TypeName(NULL);
      }
    }
    
    /**
     * Resolve a class name
     *
     * @param   string name
     * @return  string resolved
     */
    protected function resolve($name) {
      if ('self' === $name) {
        return $this->class[0];
      } else {
        return xp::reflect($name);
      }
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
      $this->op= oel_new_op_array();
      oel_set_source_file($this->op, $tree->origin);
      oel_set_source_line($this->op, 0);
      
      // Imports. Ensure lang.Enum class is always loaded
      $n= 1;
      oel_push_value($this->op, 'lang.Enum');
      foreach ((array)$tree->imports as $import) {
        if ('.*' == substr($import->name, -2)) {    // FIXME: Should be instanceof PatternImport?
          foreach (Package::forName(substr($import->name, 0, -2))->getClassNames() as $name) {
            oel_push_value($this->op, $name);
            $n++;
          }
        } else {
          oel_push_value($this->op, $import->name);
          $n++;
        }
      }
      oel_add_call_function($this->op, $n, 'uses');
      oel_add_free($this->op);
      
      // Declaration
      $this->emitOne($this->op, $tree->declaration);
      
      // Check on errors
      if ($this->errors) {
        throw new FormatException(xp::stringOf($this->errors));
      }

      // Finalize
      oel_finalize($this->op);
      oel_execute($this->op);

      // DEBUG Reflection::export(new ReflectionClass($tree->declaration->name->name));
      return $tree->declaration->name->name;
    }    
  }
?>
