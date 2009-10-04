<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler.emit.source';

  uses(
    'xp.compiler.emit.Emitter', 
    'xp.compiler.emit.NativeImporter',
    'xp.compiler.emit.source.Result', 
    'xp.compiler.syntax.php.Lexer',
    'xp.compiler.syntax.php.Parser',
    'xp.compiler.syntax.xp.Lexer',
    'xp.compiler.syntax.xp.Parser',
    'xp.compiler.ast.StatementsNode',
    'xp.compiler.types.CompilationUnitScope',
    'xp.compiler.types.TypeDeclarationScope',
    'xp.compiler.types.MethodScope',
    'lang.reflect.Modifiers',
    'util.collections.HashTable'
  );

  /**
   * Emits sourcecode using PHP sourcecode
   *
   * @test     xp://tests.execution.source.ArrayTest
   * @test     xp://tests.execution.source.CatchTest
   * @test     xp://tests.execution.source.ClassDeclarationTest
   * @test     xp://tests.execution.source.ComparisonTest
   * @test     xp://tests.execution.source.EnumDeclarationTest
   * @test     xp://tests.execution.source.ExecutionTest
   * @test     xp://tests.execution.source.ExtensionMethodsTest
   * @test     xp://tests.execution.source.FinallyTest
   * @test     xp://tests.execution.source.InstanceCreationTest
   * @test     xp://tests.execution.source.InterfaceDeclarationTest
   * @test     xp://tests.execution.source.LoopExecutionTest
   * @test     xp://tests.execution.source.MathTest
   * @test     xp://tests.execution.source.MultiCatchTest
   * @test     xp://tests.execution.source.PropertiesTest
   * @test     xp://tests.execution.source.VariablesTest
   * @ext      // oel
   * @see      xp://xp.compiler.ast.Node
   */
  class xp·compiler·emit·source·Emitter extends Emitter {
    protected 
      $op           = NULL,
      $method       = array(NULL),
      $finalizers   = array(NULL),
      $metadata     = array(NULL),
      $continuation = array(NULL),
      $properties   = array(NULL),
      $inits        = array(NULL),
      $origins      = array(NULL),
      $scope        = array(NULL);
    
    /**
     * Enter the given scope
     *
     * @param   xp.compiler.types.Scope
     */
    protected function enter(Scope $s) {
      array_unshift($this->scope, $this->scope[0]->enter($s));
    }

    /**
     * Leave the current scope, returning to the previous
     *
     */
    protected function leave() {
      array_shift($this->scope);
    }
    
    /**
     * Emit uses statements for a given list of types
     *
     * @param   resource op
     * @param   xp.compiler.types.TypeName[] types
     */
    protected function emitUses($op, array $types) {
      if (!$types) return;
      
      $n= 0;
      $this->cat && $this->cat->debug('uses(', $types, ')');
      // oel_add_begin_function_call($op, 'uses');
      foreach ($types as $type) {
        try {
          $name= $this->resolveType($type, FALSE)->name();
          // oel_push_value($op, $name);
          // oel_add_pass_param($op, ++$n);
        } catch (Throwable $e) {
          $this->error('0424', $e->toString());
        }      
      }
      // oel_add_end_function_call($op, $n);
      // oel_add_free($op);
    }
    
    /**
     * Emit parameters
     *
     * @param   resource op
     * @param   xp.compiler.ast.Node[] params
     * @return  int
     */
    protected function emitParameters($op, array $params) {
      $op->concat('(');
      $s= sizeof($params)- 1;
      foreach ($params as $i => $param) {
        $this->emitOne($op, $param);
        $i < $s && $op->concat(',');
      }
      $op->concat(')');
      return sizeof($params);
    }
    
    /**
     * Emit invocations
     *
     * @param   resource op
     * @param   xp.compiler.ast.InvocationNode inv
     */
    protected function emitInvocation($op, InvocationNode $inv) {
      if (!isset($this->scope[0]->statics[$inv->name])) {
        if (!($resolved= $this->scope[0]->resolveStatic($inv->name))) {
          $this->error('T501', 'Cannot resolve '.$inv->name.'()', $inv);
          $inv->free || xp::stringOf(NULL); //  oel_push_value($op, NULL);        // Prevent fatal
          return;
        }
        $this->scope[0]->statics[$inv->name]= $resolved;         // Cache information
      }
      $ptr= $this->scope[0]->statics[$inv->name];

      // Static method call vs. function call
      if (TRUE === $ptr) {
        $op->concat($inv->name);
        $this->emitParameters($op, (array)$inv->parameters);
        $this->scope[0]->setType($inv, TypeName::$VAR);
      } else {
        $op->concat($ptr->holder->literal().'::'.$ptr->name());
        $this->emitParameters($op, (array)$inv->parameters);
        $this->scope[0]->setType($inv, $ptr->returns);
      }
      $inv->free && xp::stringOf(NULL); //  oel_add_free($op);
    }
    
    /**
     * Emit strings
     *
     * @param   resource op
     * @param   xp.compiler.ast.StringNode str
     */
    protected function emitString($op, StringNode $str) {
      $op->concat("'".$str->resolve()."'");
    }

    /**
     * Emit an array (a sequence of elements with a zero-based index)
     *
     * @param   resource op
     * @param   xp.compiler.ast.ArrayNode arr
     */
    protected function emitArray($op, ArrayNode $arr) {
      $op->concat('array(');
      foreach ((array)$arr->values as $value) {
        $this->emitOne($op, $value);
        $op->concat(',');
      }
      $op->concat(')');
    }

    /**
     * Emit a map (a key/value pair dictionary)
     *
     * @param   resource op
     * @param   xp.compiler.ast.MapNode map
     */
    protected function emitMap($op, MapNode $map) {
      $op->concat('array(');
      foreach ((array)$map->elements as $pair) {
        $this->emitOne($op, $pair[0]);
        $op->concat(' => ');
        $this->emitOne($op, $pair[1]);
        $op->concat(',');
      }
      $op->concat(')');
    }

    /**
     * Emit booleans
     *
     * @param   resource op
     * @param   xp.compiler.ast.BooleanNode const
     */
    protected function emitBoolean($op, BooleanNode $const) {
      $op->concat($const->resolve() ? 'TRUE' : 'FALSE');
    }

    /**
     * Emit null
     *
     * @param   resource op
     * @param   xp.compiler.ast.NullNode const
     */
    protected function emitNull($op, NullNode $const) {
      $op->concat('NULL');
    }
    
    /**
     * Emit constants
     *
     * @param   resource op
     * @param   xp.compiler.ast.ConstantNode const
     */
    protected function emitConstant($op, ConstantNode $const) {
      $this->warn('T203', 'Global constants ('.$const->value.') are discouraged', $const);
      try {
        // oel_push_value($op, $const->resolve());
      } catch (IllegalStateException $e) {
        $this->warn('T201', 'Constant lookup for '.$const->value.' deferred until runtime', $const);
        // oel_push_constant($op, $const->value);
      }
    }

    /**
     * Emit casts
     *
     * @param   resource op
     * @param   xp.compiler.ast.CastNode cast
     */
    protected function emitCast($op, CastNode $cast) {
      static $primitives= array(
        'int'     => '(int)', // oel_OP_TO_INT,
        'double'  => '(double)', // oel_OP_TO_DOUBLE,
        'string'  => '(string)', // oel_OP_TO_STRING,
        'array'   => '(array)', // oel_OP_TO_ARRAY,
        'bool'    => '(bool)', // oel_OP_TO_BOOL,
        // Missing intentionally: object and unset casts
      );

      if (isset($primitives[$cast->type->name])) {
        $this->emitOne($op, $cast->expression);
        // oel_add_cast_op($op, $primitives[$cast->type->name]);
      } else {
        // oel_add_begin_function_call($op, 'cast'
{
          $this->emitOne($op, $cast->expression);
          // oel_add_pass_param($op, 1);

          // oel_push_value($op, $this->resolveType($cast->type)->name());
          // oel_add_pass_param($op, 2);
        }
        // oel_add_end_function_call($op, 2);
      }
      
      $this->scope[0]->setType($cast, $cast->type);
      $cast->free && xp::stringOf(NULL); //  oel_add_free($op);
    }

    /**
     * Emit integers
     *
     * @param   resource op
     * @param   xp.compiler.ast.IntegerNode num
     */
    protected function emitInteger($op, IntegerNode $num) {
      $op->concat($num->resolve());
    }

    /**
     * Emit decimals
     *
     * @param   resource op
     * @param   xp.compiler.ast.DecimalNode num
     */
    protected function emitDecimal($op, DecimalNode $num) {
      $r= $num->resolve();
      $op->concat($r);
      
      // Prevent float(2) being dumped as "2" and thus an int literal
      strstr($r, '.') || $op->concat('.0');
    }

    /**
     * Emit hex numbers
     *
     * @param   resource op
     * @param   xp.compiler.ast.HexNode num
     */
    protected function emitHex($op, HexNode $num) {
      $op->concat($num->resolve());
    }
    
    /**
     * Emit a variable. Implements type overloading
     *
     * @param   resource op
     * @param   xp.compiler.ast.VariableNode var
     */
    protected function emitVariable($op, VariableNode $var) {
      $op->concat('$'.$var->name);
    }

    /**
     * Emit an array access. Helper to emitChain()
     *
     * @param   resource op
     * @param   xp.compiler.ast.ArrayAccessNode access
     * @param   xp.compiler.types.TypeName type
     * @return  xp.compiler.types.TypeName resulting type
     */
    protected function emitArrayAccess($op, ArrayAccessNode $access, TypeName $type) {
      $result= TypeName::$VAR;
      if ($type->isArray()) {
        $result= $type->arrayComponentType();
      } else if ($type->isMap()) {
        // OK, TODO: Further verification
      } else if ($type->isClass()) {
        // Check for this[] indexer property
      } else if ($type->isVariable()) {
        $this->warn('T203', 'Array access (var)'.$access->hashCode().' verification deferred until runtime', $accesss);
      } else {
        $this->warn('T305', 'Using array-access on unsupported type '.$type->toString(), $access);
      }
      
      $op->concat('[');
      if ($access->offset) {
        $this->emitOne($op, $access->offset);
      }
      $op->concat(']');
      return $result;
    }

    /**
     * Emit a member access. Helper to emitChain()
     *
     * @param   resource op
     * @param   xp.compiler.ast.VariableNode access
     * @param   xp.compiler.types.TypeName type
     * @return  xp.compiler.types.TypeName resulting type
     */
    protected function emitMemberAccess($op, VariableNode $access, TypeName $type) {
      $result= TypeName::$VAR;
      if ($type->isClass()) {
        $ptr= $this->resolveType($type);
        if ($ptr->hasField($access->name)) {
          $result= $ptr->getField($access->name)->type;
        } else {
          $this->warn('T201', 'No such field '.$access->name.' in '.$type->toString(), $accesss);
        }
      } else if ($type->isVariable()) {
        $this->warn('T203', 'Member access (var).'.$access->name.' verification deferred until runtime', $accesss);
      } else {
        $this->warn('T305', 'Using member access on unsupported type '.$type->toString(), $access);
      }

      $op->concat('->'.$access->name);
      return $result;
    }

    /**
     * Emit a member call. Helper to emitChain()
     *
     * @param   resource op
     * @param   xp.compiler.ast.InvocationNode access
     * @param   xp.compiler.types.TypeName type
     * @return  xp.compiler.types.TypeName resulting type
     */
    protected function emitMemberCall($op, InvocationNode $access, TypeName $type) {
      $result= TypeName::$VAR;
      if ($type->isClass()) {
        $ptr= $this->resolveType($type);
        if ($ptr->hasMethod($access->name)) {
          $result= $ptr->getMethod($access->name)->returns;
        } else if ($this->scope[0]->hasExtension($ptr, $access->name)) {
          $ext= $this->scope[0]->getExtension($ptr, $access->name);

          // FIXME: Slow access via __call()
          $op->concat('->'.$access->name);
          $this->emitParameters($op, (array)$access->parameters);
          return $ext->returns;
          
          // Assign this to a temporary variable
          //
          // The statement:
          //   $r= $a.b().c().d;
          //
          // will become:
          //  $t= $a.b();
          //  $r= Extension::method($t, ...);
          //  $r.d;
          //
          // when c() is an extension method to b()'s return type
          $temp= $access->hashCode();
          // oel_add_begin_variable_parse($op);
          // oel_push_variable($op, $temp);
          // oel_add_assign($op);
          // oel_add_free($op);

          // Call Extension::method($temp [, $args0 [, $arg1 [, ...]]]);
          // oel_add_begin_static_method_call($op, $ext->name, $ext->holder->literal());
          $n= $this->emitParameters($op, array_merge(
            array(new VariableNode($temp)),
            (array)$access->parameters
          ));
          // oel_add_end_static_method_call($op, $n);

          // Push result
          // oel_add_begin_variable_parse($op);
          // oel_push_variable($op, 'R');
          // oel_add_assign($op);
          
          return $ext->returns;
        } else {
          $this->warn('T201', 'No such method '.$access->name.'() in '.$type->compoundName(), $accesss);
        }
      } else if ($type->isVariable()) {
        $this->warn('T203', 'Member call (var).'.$access->name.'() verification deferred until runtime', $accesss);
      } else {
        $this->warn('T305', 'Using member calls on unsupported type '.$type->toString(), $access);
      }

      $op->concat('->'.$access->name);
      $this->emitParameters($op, (array)$access->parameters);
      return $result;
    }

    /**
     * Emit a chain
     *
     * <pre>
     *   $this.name;       // Chain(VariableNode[this], VariableNode[name])
     *   $a.getClass();    // Chain(VariableNode[a], InvocationNode[getClass])
     *   $args[0];         // Chain(VariableNode[args], ArrayAccessNode[IntegerNode(0)])
     *   $args[];          // Chain(VariableNode[args], ArrayAccessNode[])
     * </pre>
     * 
     * @param   resource op
     * @param   xp.compiler.ast.ChainNode chain
     */
    public function emitChain($op, ChainNode $chain) {
      $s= sizeof($chain->elements);
      
      // Rewrite for unsupported syntax:
      // - $a.getMethods()[2] to array_slice($a.getMethods(), 2, 1)
      // - $a.get()[2].all()[3] to array_slice(array_slice($a.get(), 2, 1).all(), 3, 1)
      $insertion= array();
      for ($i= 1; $i < $s; $i++) {
        if ($chain->elements[$i] instanceof InvocationNode && $chain->elements[$i+ 1] instanceof ArrayAccessNode) {
          $op->concat('current(array_slice(');
          $insertion[$i]= new String(', ');
          $this->emitOne($insertion[$i], $chain->elements[$i+ 1]->offset);
          $insertion[$i]->concat(', 1))');
          $chain->elements[$i+ 1]= new NoopNode();
        }
      }
    
      // Emit first node
      $this->emitOne($op, $chain->elements[0]);
      
      // Emit chain members
      // oel_add_begin_variable_parse($op);
      $t= $this->scope[0]->typeOf($chain->elements[0]);
      for ($i= 1; $i < $s; $i++) {
        $c= $chain->elements[$i];

        $this->cat && $this->cat->debugf(
          '@%-3d Emit %s(free= %d): %s',
          $c->position[0], 
          $c->getClassName(), 
          $c->free, 
          $c->hashCode()
        );
        
        if ($c instanceof VariableNode) {
          $t= $this->emitMemberAccess($op, $c, $t);
        } else if ($c instanceof ArrayAccessNode) {
          $t= $this->emitArrayAccess($op, $c, $t);
        } else if ($c instanceof InvocationNode) {
          $t= $this->emitMemberCall($op, $c, $t);
        }
        isset($insertion[$i]) && $op->concat($insertion[$i]);
      }
      
      // Record type
      $this->scope[0]->setType($chain, $t);
      
      // If chain is used in read context, do not end variable parse
      $chain->read || xp::stringOf(NULL); //  oel_add_end_variable_parse($op);
      $chain->free && xp::stringOf(NULL); //  oel_add_free($op);
    }

    /**
     * Emit binary operation node
     *
     * @param   resource op
     * @param   xp.compiler.ast.BinaryOpNode bin
     */
    protected function emitBinaryOp($op, BinaryOpNode $bin) {
      static $bop= array(
        '~'   => '.',
        '-'   => '-',
        '+'   => '+',
        '*'   => '*',
        '/'   => '/',
        '%'   => '%',
        '|'   => '|',
        '&'   => '&',
        '^'   => '^',
      );
      static $lop= array(
        '&&'  => '&&', // oel_OP_BOOL_AND,
        '||'  => '||', // oel_OP_BOOL_OR,
      );
      
      // Check for logical operations. TODO: LogicalOperationNode?
      if (isset($lop[$bin->op])) {
        $op->concat('(');
        $this->emitOne($op, $bin->lhs);
        $op->concat(') '.$lop[$bin->op].' (');
        $this->emitOne($op, $bin->rhs);
        $op->concat(')');
      } else {
        $this->emitOne($op, $bin->lhs);
        $op->concat(' '.$bop[$bin->op].' ');
        $this->emitOne($op, $bin->rhs);
      }
      $bin->free && xp::stringOf(NULL); //  oel_add_free($op);
    }

    /**
     * Emit unary operation node
     *
     * @param   resource op
     * @param   xp.compiler.ast.UnaryOpNode un
     */
    protected function emitUnaryOp($op, UnaryOpNode $un) {
      static $ops= array(
        '++'   => '++',
        '--'   => '--',
      );
      
      if ('!' === $un->op) {      // FIXME: Use NotNode for this?
        $op->concat('!');
        $this->emitOne($op, $un->expression);
        return;
      } else if ('-' === $un->op) {
        $this->emitOne($op, new BinaryOpNode(array(
          'lhs' => $un->expression,
          'rhs' => new IntegerNode(array('value' => -1)),
          'op'  => '*'
        )));
        return;
      } else if (!$un->expression instanceof VariableNode) {
        $this->error('U400', 'Cannot perform unary '.$un->op.' on '.$un->getClassName(), $un);
        return;
      }

      if ($un->postfix) {
        $op->concat('$'.$un->expression->name.$ops[$un->op]);
      } else {
        $op->concat($ops[$un->op].'$'.$un->expression->name);
      }
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
      $op->concat('?');
      $this->emitOne($op, $ternary->expression ? $ternary->expression : $ternary->condition);
      $op->concat(':');
      $this->emitOne($op, $ternary->conditional);
    }

    /**
     * Emit comparison node
     *
     * @param   resource op
     * @param   xp.compiler.ast.ComparisonNode cmp
     */
    protected function emitComparison($op, ComparisonNode $cmp) {
      static $ops= array(
        '=='   => '==', 
        '==='  => '===',
        '!='   => '!=', 
        '!=='  => '!==',
        '<='   => '<=', 
        '<'    => '<',  
        '>='   => '>=', 
        '>'    => '>',  
      );

      $this->emitOne($op, $cmp->lhs);
      $op->concat(' '.$ops[$cmp->op].' ');
      $this->emitOne($op, $cmp->rhs);
    }

    /**
     * Emit continue statement
     *
     * @param   resource op
     * @param   xp.compiler.ast.ContinueNode statement
     */
    protected function emitContinue($op, ContinueNode $statement) {
      $op->concat('continue;');
    }

    /**
     * Emit break statement
     *
     * @param   resource op
     * @param   xp.compiler.ast.BreakNode statement
     */
    protected function emitBreak($op, BreakNode $statement) {
      $op->concat('break;');
    }

    /**
     * Emit noop
     *
     * @param   resource op
     * @param   xp.compiler.ast.NoopNode statement
     */
    protected function emitNoop($op, NoopNode $statement) {
      // NOOP
    }

    /**
     * Emit statements
     *
     * @param   resource op
     * @param   xp.compiler.ast.StatementsNode statements
     */
    protected function emitStatements($op, StatementsNode $statements) {
      $this->emitAll($op, (array)$statements->list);
    }

    /**
     * Emit foreach loop
     *
     * @param   resource op
     * @param   xp.compiler.ast.ForeachNode loop
     */
    protected function emitForeach($op, ForeachNode $loop) {
      $op->concat('foreach (');
      
      // Special case when iterating on variables: Do not end variable parse 
      if ($loop->expression instanceof VariableNode) {
        // oel_add_begin_variable_parse($op);
        // oel_push_variable($op, $loop->expression->name);
      } else {
        $this->emitOne($op, $loop->expression);
      }
      
      // Assign type. TODO: Depending on what the expression returns, this might
      // be something different!
      $t= $this->scope[0]->typeOf($loop->expression);
      if ($t->isArray()) {
        $it= $t->arrayComponentType();
      } else if ($t->isVariable()) {
        $it= TypeName::$VAR;
      } else if ('lang.Iterable' === $this->resolveType($t)->name()) {
        $it= isset($t->components[0]) ? $t->components[0] : TypeName::$VAR;;
      } else {
        $this->warn('T300', 'Illegal type '.$t->toString().' for loop expression '.$loop->expression->getClassName().'['.$loop->expression->hashCode().']', $loop);
        $it= TypeName::$VAR;
      }
      $this->scope[0]->setType(new VariableNode($loop->assignment['value']), $it);

      $op->concat(' as ');
      if (isset($loop->assignment['key'])) {
        $op->concat('$'.$loop->assignment['key'].' => ');
      }
      $op->concat('$'.$loop->assignment['value'].') {');
      $this->emitAll($op, (array)$loop->statements);
      $op->concat('}');
    }

    /**
     * Emit do ... while loop
     *
     * @param   resource op
     * @param   xp.compiler.ast.DoNode loop
     */
    protected function emitDo($op, DoNode $loop) {
      $op->concat('do {');
      $this->emitAll($op, (array)$loop->statements);
      $op->concat('} while (');
      $this->emitOne($op, $loop->expression);
      $op->concat(');');
    }

    /**
     * Emit while loop
     *
     * @param   resource op
     * @param   xp.compiler.ast.WhileNode loop
     */
    protected function emitWhile($op, WhileNode $loop) {
      $op->concat('while (');
      $this->emitOne($op, $loop->expression);
      $op->concat(') {');
      $this->emitAll($op, (array)$loop->statements);
      $op->concat('}');
    }
    
    protected function emitForComponent($op, array $nodes) {
      $s= sizeof($nodes)- 1;
      foreach ($nodes as $node) {
        $node->free= FALSE;
        $this->emitOne($op, $node);
        $i < $s && $op->concat(', ');
      }
    }

    /**
     * Emit for loop
     *
     * @param   resource op
     * @param   xp.compiler.ast.ForNode loop
     */
    protected function emitFor($op, ForNode $loop) {
      $op->concat('for (');
      $this->emitForComponent($op, (array)$loop->initialization);
      $op->concat(';');
      $this->emitForComponent($op, (array)$loop->condition);
      $op->concat(';');
      $this->emitForComponent($op, (array)$loop->loop);
      $op->concat(') {');
      $this->emitAll($op, (array)$loop->statements);
      $op->concat('}');
    }
    
    /**
     * Emit if statement
     *
     * @param   resource op
     * @param   xp.compiler.ast.IfNode if
     */
    protected function emitIf($op, IfNode $if) {
      $op->concat('if (');
      $this->emitOne($op, $if->condition);
      $op->concat(') {');
      $this->emitAll($op, (array)$if->statements);
      $op->concat('}');
      if ($if->otherwise) {
        $op->concat('else {');
        $this->emitAll($op, (array)$if->otherwise->statements);
        $op->concat('}');
      }
    }

    /**
     * Emit a switch case
     *
     * @param   resource op
     * @param   xp.compiler.ast.CaseNode case
     */
    protected function emitCase($op, CaseNode $case) {
      $op->concat('case ');
      $this->emitOne($op, $case->expression);
      $op->concat(': ');
      $this->emitAll($op, (array)$case->statements);
    }

    /**
     * Emit the switch default case
     *
     * @param   resource op
     * @param   xp.compiler.ast.DefaultNode default
     */
    protected function emitDefault($op, DefaultNode $default) {
      $op->concat('default: ');
      $this->emitAll($op, (array)$default->statements);
    }

    /**
     * Emit switch statement
     *
     * @param   resource op
     * @param   xp.compiler.ast.SwitchNode switch
     */
    protected function emitSwitch($op, SwitchNode $switch) {
      $op->concat('switch (');
      $this->emitOne($op, $switch->expression);
      $op->concat(') {');
      $this->emitAll($op, (array)$switch->cases);
      $op->concat('}');
    }
    
    /**
     * Emit class members, for example:
     * <code>
     *   XPClass::forName();        // static method call
     *   lang.types.String::class;  // special "class" member
     *   Tokens::T_STRING;          // class constant
     *   self::$instance;           // static member variable
     * </code>
     *
     * @param   resource op
     * @param   xp.compiler.ast.ClassMemberNode ref
     */
    protected function emitClassMember($op, ClassMemberNode $ref) {
      $ptr= $this->resolveType($ref->class);
      if ($ref->member instanceof InvocationNode) {
      
        // Static method call
        if (!$ptr->hasMethod($ref->member->name)) {
          $this->warn('T305', 'Cannot resolve '.$ref->member->name.'() in type '.$ptr->toString(), $ref);
        } else {
          $m= $ptr->getMethod($ref->member->name);
          $this->scope[0]->setType($ref, $m->returns);
        }

        $op->concat($ptr->literal().'::'.$ref->member->name);
        $this->emitParameters($op, (array)$ref->member->parameters);
      } else if ($ref->member instanceof VariableNode) {
      
        // Static member
        if (!$ptr->hasField($ref->member->name)) {
          $this->warn('T305', 'Cannot resolve '.$ref->member->name.' in type '.$ptr->toString(), $ref);
        } else {
          $f= $ptr->getField($ref->member->name);
          $this->scope[0]->setType($ref, $f->type);
        }

        $op->concat($ptr->literal().'::$'.$ref->member->name);
      } else if ($ref->member instanceof ConstantNode && 'class' === $ref->member->value) {
        
        // Magic "class" member
        $op->concat('XPClass::forName(\''.$ptr->name().'\')');
        $this->scope[0]->setType($ref, new TypeName('lang.XPClass'));
      } else if ($ref->member instanceof ConstantNode) {

        // Class constant
        // oel_push_constant($op, $ref->member->value, $ptr->literal());
      } else {
        $this->error('M405', 'Cannot emit class member '.xp::stringOf($ref->member), $ref);
        // oel_push_value($op, NULL);
        return;
      }

      $ref->free && xp::stringOf(NULL); //  oel_add_free($op);
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
      static $mangled= '··e';

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
      
      // If no handlers are left, create a simple catch-all-and-rethrow
      // handler
      if (0 == $numHandlers) {
        $rethrow= new ThrowNode(array('expression' => new VariableNode($mangled)));
        $first= new CatchNode(array(
          'type'       => new TypeName('lang.Throwable'),
          'variable'   => $mangled,
          'statements' => $this->finalizers[0] ? array($this->finalizers[0], $rethrow) : array($rethrow)
        ));
      } else {
        $first= $try->handling[0];
        $this->scope[0]->setType(new VariableNode($first->variable), $first->type);
      }

      $op->concat('try {'); {
        $this->emitAll($op, (array)$try->statements);
        $this->finalizers[0] && $this->emitOne($op, $this->finalizers[0]);
      }
      
      // First catch.
      $op->concat('} catch('.$this->resolveType($first->type)->literal().' $'.$first->variable.') {'); {
        $this->scope[0]->setType(new VariableNode($first->variable->variable), $first->type);
        $this->emitAll($op, (array)$first->statements);
        $this->finalizers[0] && $this->emitOne($op, $this->finalizers[0]);
      }
      
      // Additional catches
      for ($i= 1; $i < $numHandlers; $i++) {
        $op->concat('} catch('.$this->resolveType($try->handling[$i]->type)->literal().' $'.$try->handling[$i]->variable.') {'); {
          $this->scope[0]->setType(new VariableNode($try->handling[$i]->variable), $try->handling[$i]->type);
          $this->emitAll($op, (array)$try->handling[$i]->statements);
          $this->finalizers[0] && $this->emitOne($op, $this->finalizers[0]);
        }
      }
      
      $op->concat('}');
      array_shift($this->finalizers);
    }
    
    /**
     * Emit a throw node
     *
     * @param   resource op
     * @param   xp.compiler.ast.ThrowNode throw
     */
    protected function emitThrow($op, ThrowNode $throw) {
      $op->concat('throw ');
      $this->emitOne($op, $throw->expression);
      $op->concat(';');
    }

    /**
     * Emit a finally node
     *
     * @param   resource op
     * @param   xp.compiler.ast.FinallyNode finally
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

      // Anonymous instance creation:
      //
      // - Create unique classname
      // - Extend parent class if type is a class
      // - Implement type and extend lang.Object if it's an interface 
      //
      // Do not register type name from new(), it will be added by 
      // emitClass() during declaration emittance.
      if (isset($new->body)) {
        $parent= $this->resolveType($new->type, $this, FALSE);
        if (Types::INTERFACE_KIND === $parent->kind()) {
          $p= array('parent' => new TypeName('lang.Object'), 'implements' => array($new->type));
        } else if (Types::ENUM_KIND === $parent->kind()) {
          $this->error('C405', 'Cannot create anonymous enums', $new);
          return;
        } else {
          $p= array('parent' => $new->type, 'implements' => NULL);
        }
        
        $unique= new TypeName($parent->literal().'··'.++$i);
        $decl= new ClassNode(0, NULL, $unique, $p['parent'], $p['implements'], $new->body);
        $ptr= new TypeDeclaration(new ParseTree(NULL, array(), $decl), $parent);
        $this->scope[0]->declarations[]= $decl;
        $this->scope[0]->setType($new, $unique);
        $this->scope[0]->addResolved($unique->name, $ptr);
      } else {
        $ptr= $this->resolveType($new->type);
        $this->scope[0]->setType($new, $new->type);
      }
      
      $op->concat('new '.$ptr->literal());
      $n= $this->emitParameters($op, (array)$new->parameters);

      $new->free && xp::stringOf(NULL); //  oel_add_free($op);
    }
    
    /**
     * Emit an assignment
     *
     * @param   resource op
     * @param   xp.compiler.ast.AssignmentNode assign
     */
    protected function emitAssignment($op, AssignmentNode $assign) {
      static $ops= array(
        '='    => '=', 
        '~='   => '.=',
        '-='   => '-=',
        '+='   => '+=',
        '*='   => '*=',
        '/='   => '/=',
        '%='   => '%=',
      );
      
      $this->emitOne($op, $assign->variable);
      $op->concat($ops[$assign->op]);
      $this->emitOne($op, $assign->expression);
      $this->scope[0]->setType($assign->variable, $this->scope[0]->typeOf($assign->expression));
    }

    /**
     * Emit an operator
     *
     * @param   resource op
     * @param   xp.compiler.ast.OperatorNode method
     */
    protected function emitOperator($op, OperatorNode $operator) {
      $this->errors('F501', 'Operator overloading not supported', $operator);
    }

    /**
     * Emit method arguments
     *
     * @param   resource op
     * @param   array<string, *>[] arguments
     * @param   string delim
     */
    protected function emitArguments($op, array $arguments, $delim) {
      $op->concat('(');
      $s= sizeof($arguments)- 1;
      $defer= array();
      foreach ($arguments as $i => $arg) {
        if (isset($arg['vararg'])) {
          if ($i > 0) {
            $defer[]= '$'.$arg['name'].'= array_slice(func_get_args(), '.$i.');';
          } else {
            $defer[]= '$'.$arg['name'].'= func_get_args();';
          }
          $this->scope[0]->setType(new VariableNode($arg['name']), new TypeName($arg['type']->name.'[]'));
          $op->concat('$··= NULL');
          break;
        }
        
        $op->concat('$'.$arg['name']);
        if (isset($arg['default'])) {
          $op->concat('= ');
          $resolveable= FALSE; 
          if ($arg['default'] instanceof Resolveable) {
            try {
              $init= $arg['default']->resolve();
              $op->concat(var_export($init, TRUE));
              $resolveable= TRUE; 
            } catch (IllegalStateException $e) {
            }
          }
          if (!$resolveable) {
            $op->concat('NULL');
            $init= new String();
            $init->concat('if (func_num_args() < ')->concat($i + 1)->concat(') { ');
            $init->concat('$')->concat($arg['name'])->concat('= ');
            $this->emitOne($init, $arg['default']);
            $init->concat('; }');
            $defer[]= $init;
          }
        }
        $i < $s && $op->concat(',');
        
        // FIXME: Emit type hint if type is a class, interface or enum
        $this->scope[0]->setType(new VariableNode($arg['name']), $arg['type'] ? $arg['type'] : TypeName::$VAR);
      }
      $op->concat(')');
      $op->concat($delim);
      
      foreach ($defer as $src) {
        $op->concat($src);
      }
    }

    /**
     * Create annotations meta data
     *
     * @param   xp.compiler.ast.AnnotationNode[]
     * @return  array<string, var> annotations
     */
    protected function annotationsAsMetadata(array $annotations) {
      $meta= array();
      foreach ($annotations as $annotation) {
        $params= array();
        foreach ((array)$annotation->parameters as $name => $value) {
          if ($value instanceof ClassMemberNode) {    // class literal
            $params[$name]= $this->resolveType($value->class)->name();
          } else if ($value instanceof Resolveable) {
            $params[$name]= $value->resolve();
          } else if ($value instanceof ArrayNode) {
            $params[$name]= array();
            foreach ($value->values as $element) {
              $element instanceof Resolveable && $params[$name][]= $element->resolve();
            }
          }
        }

        if (!$annotation->parameters) {
          $meta[$annotation->type]= NULL;
        } else if (isset($annotation->parameters['default'])) {
          $meta[$annotation->type]= $params['default'];
        } else {
          $meta[$annotation->type]= $params;
        }
      }
      return $meta;
    }    

    /**
     * Create parameters meta data
     *
     * @param   array<string, *>[] arguments
     * @return  array<string, var> metadata
     */
    protected function parametersAsMetadata(array $parameters) {
      $meta= array();
      foreach ($parameters as $i => $param) {
        $meta[$i]= $param['type']->compoundName();
      }
      return $meta;
    }    

    /**
     * Emit a method
     *
     * @param   resource op
     * @param   xp.compiler.ast.MethodNode method
     */
    protected function emitMethod($op, MethodNode $method) {
      if (!$method->comment && !strstr($this->scope[0]->declarations[0]->name->name, '$')) {
        $this->warn('D201', 'No api doc for '.$this->scope[0]->declarations[0]->name->name.'::'.$method->name.'()', $method);
      }
      if ($this->scope[0]->declarations[0] instanceof InterfaceNode) {
        if ($method->body) {
          $this->error('I403', 'Interface methods may not have a body', $method);
          return;
        }
        $empty= TRUE;
      } else {
        $empty= Modifiers::isAbstract($method->modifiers);
      }
      if ($method->extension) {
        $this->scope[0]->addExtension(
          $type= $this->resolveType($method->extension),
          $this->resolveType(new TypeName('self'))->getMethod($method->name)
        );
        $this->metadata[0]['EXT'][$method->name]= $type->literal();   // HACK, this should be accessible in scope
      }
      $op->concat(implode(' ', Modifiers::namesOf($method->modifiers)));
      $op->concat(' function '.$method->name);
      
      // Begin
      $this->enter(new MethodScope());
      if (!Modifiers::isStatic($method->modifiers)) {
        $this->scope[0]->setType(new VariableNode('this'), $this->scope[0]->declarations[0]->name);
      }

      // oel_set_source_file($mop, $this->origins[0]);
      array_unshift($this->method, $method);

      // Arguments, body
      $this->emitArguments($op, (array)$method->arguments, $empty ? ';' : '{');
      if (!$empty) {
        $this->emitAll($op, (array)$method->body);
        $op->concat('}');
      }
      
      // Finalize
      $this->metadata[0][1][$method->name]= array(
        DETAIL_ARGUMENTS    => $this->parametersAsMetadata((array)$method->arguments),
        DETAIL_RETURNS      => $method->returns->name,
        DETAIL_THROWS       => array(),
        DETAIL_COMMENT      => preg_replace('/\n\s+\* ?/', "\n  ", "\n ".$method->comment),
        DETAIL_ANNOTATIONS  => $this->annotationsAsMetadata((array)$method->annotations)
      );
      // oel_finalize($mop);

      array_shift($this->method);
      $this->leave();
    }

    /**
     * Emit a constructor
     *
     * @param   resource op
     * @param   xp.compiler.ast.ConstructorNode constructor
     */
    protected function emitConstructor($op, ConstructorNode $constructor) {
      if (!$constructor->comment && !strstr($this->scope[0]->declarations[0]->name->name, '$')) {
        $this->warn('D201', 'No api doc for '.$this->scope[0]->declarations[0]->name->name.'\'s constructor', $constructor);
      }

      $op->concat(implode(' ', Modifiers::namesOf($method->modifiers)));
      $op->concat(' function __construct');
      
      // Begin
      $this->enter(new MethodScope());
      $this->scope[0]->setType(new VariableNode('this'), $this->scope[0]->declarations[0]->name);
      // oel_set_source_file($cop, $this->origins[0]);
      array_unshift($this->method, $constructor);

      // Arguments, initializations, body
      $this->emitArguments($op, (array)$constructor->arguments, '{');
      if ($this->inits[0][FALSE]) {
        foreach ($this->inits[0][FALSE] as $field) {
          $this->emitOne($op, new AssignmentNode(array(
            'variable'   => new ChainNode(array(new VariableNode('this'), new VariableNode($field->name))),
            'expression' => $field->initialization,
            'free'       => TRUE,
            'op'         => '=',
          )));
        }
        unset($this->inits[0][FALSE]);
      }
      $this->emitAll($op, (array)$constructor->body);
      $op->concat(';');   // XXX FIXME!!! This should not be necessary!!! XXX
      $op->concat('}');
      
      // Finalize
      $this->metadata[0][1]['__construct']= array(
        DETAIL_ARGUMENTS    => $this->parametersAsMetadata((array)$constructor->arguments),
        DETAIL_RETURNS      => NULL,
        DETAIL_THROWS       => array(),
        DETAIL_COMMENT      => preg_replace('/\n\s+\* ?/', "\n  ", "\n ".$constructor->comment),
        DETAIL_ANNOTATIONS  => $this->annotationsAsMetadata((array)$constructor->annotations)
      );
      // oel_finalize($cop);
      array_shift($this->method);
      $this->leave();
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
      foreach ($this->metadata[0]['EXT'] as $method => $for) {   // HACK, this should be accessible in scope
        $op->concat('xp::$registry[\''.$for.'::'.$method.'\']= new ReflectionMethod(\''.$name.'\', \''.$method.'\');');
      }
      unset($this->metadata[0]['EXT']);
      $op->concat('xp::$registry[\'class.'.$name.'\']= \''.$qualified.'\';');
      $op->concat('xp::$registry[\'classloader.'.$qualified.'\']= \'compiled://\';');
      $op->concat('xp::$registry[\'details.'.$name.'\']= '.var_export($this->metadata[0], TRUE).';');
      
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
        $this->scope[0]->declarations[0]->implements[]= 'ArrayAccess';
        
        foreach (array(
          'get'   => array('offsetGet', $property->arguments),
          'set'   => array('offsetSet', array_merge($property->arguments, array(array('name' => 'value', 'type' => $property->type)))),
          'isset' => array('offsetExists', $property->arguments),
          'unset' => array('offsetUnset', $property->arguments),
        ) as $handler => $def) {
          $op->concat('function '.$def[0]);
          $this->emitArguments($op, $def[1], '{');
          $this->enter(new MethodScope());
          $this->scope[0]->setType(new VariableNode('this'), $this->scope[0]->declarations[0]->name);
          $this->emitAll($op, $property->handlers[$handler]);
          $this->leave();
          $op->concat('}');
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
      static $mangled= '··name';
      
      if (isset($properties['get'])) {
        $op->concat('function __get($'.$mangled.') {');
        $this->enter(new MethodScope());
        $this->scope[0]->setType(new VariableNode('this'), $this->scope[0]->declarations[0]->name);
        // oel_set_source_file($gop, $this->origins[0]);
        foreach ($properties['get'] as $name => $statements) {
          $op->concat('if (\''.$name.'\' === $'.$mangled.') {');
          $this->emitAll($op, (array)$statements);
          $op->concat('} else ');
        }
        $op->concat('return parent::__get($'.$mangled.'); }');
        $this->leave();
      }
      if (isset($properties['set'])) {
        $op->concat('function __set($'.$mangled.', $value) {');
        $this->enter(new MethodScope());
        $this->scope[0]->setType(new VariableNode('this'), $this->scope[0]->declarations[0]->name);
        // oel_set_source_file($gop, $this->origins[0]);
        foreach ($properties['set'] as $name => $statements) {
          $op->concat('if (\''.$name.'\' === $'.$mangled.') {');
          $this->emitAll($op, (array)$statements);
          $op->concat('} else ');
        }
        $op->concat('parent::__set($'.$mangled.', $value); }');
        $this->leave();
      }
    }
    
    /**
     * Emit a class field
     *
     * @param   resource op
     * @param   xp.compiler.ast.FieldNode field
     */
    protected function emitField($op, FieldNode $field) {    
      $static= Modifiers::isStatic($field->modifiers);
      
      if (!$field->initialization) {
        $init= NULL;
      } else if ($field->initialization instanceof Resolveable) {
        $init= $field->initialization->resolve();
      } else {    // Need to initialize these later
        $init= NULL;
        $this->inits[0][$static][]= $field;
      }
      
      if (Modifiers::isPublic($field->modifiers)) {
        $op->concat('public ');
      } else if (Modifiers::isProtected($field->modifiers)) {
        $op->concat('protected ');
      } else if (Modifiers::isPrivate($field->modifiers)) {
        $op->concat('private ');
      }
      if (Modifiers::isStatic($field->modifiers)) {
        $op->concat('static ');
      }
      $op->concat('$'.$field->name);
      $op->concat(';');

      /*// oel_add_declare_property(
        $op, 
        $field->name,
        $init,
        $static,
        $field->modifiers
      );*/
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
      if (!$declaration->comment) {
        $this->warn('D201', 'No api doc for enum '.$declaration->name->name, $declaration);
      }

      $parent= $declaration->parent ? $declaration->parent : new TypeName('lang.Enum');
      $parentType= $this->resolveType($parent, FALSE);
      $this->enter(new TypeDeclarationScope());    

      // Ensure parent class and interfaces are loaded
      $this->emitUses($op, array_merge(
        array($parent), 
        (array)$declaration->implements
      ));

      if (Modifiers::isAbstract($declaration->modifiers)) {
        $op->concat('abstract ');
        $abstract= TRUE;
      } else if (Modifiers::isFinal($declaration->modifiers)) {
        $op->concat('final ');
      }
      $op->concat(' class '.$declaration->name->name.' extends '.$parentType->literal());
      array_unshift($this->metadata, array(array(), array()));
      array_unshift($this->properties, array('get' => array(), 'set' => array()));

      // Interfaces
      if ($declaration->implements) {
        $op->concat(' implements ');
        $s= sizeof($declaration->implements)- 1;
        foreach ($declaration->implements as $i => $type) {
          $op->concat($this->resolveType($type, FALSE)->literal());
          $i < $s && $op->concat(', ');
        }
      }
      
      // Member declaration
      $op->concat(' {');
      foreach ($declaration->body['members'] as $i => $member) {
        $op->concat('public static $'.$member->name.';');
      }

      $op->concat('static function __static() {');
      // oel_set_source_file($sop, $this->origins[0]);
      foreach ($declaration->body['members'] as $i => $member) {
        $op->concat('self::$'.$member->name.'= ');
        if ($member->body) {
          if (!$abstract) {
            $this->error('E403', 'Only abstract enums can contain members with bodies ('.$member->name.')');
            // Continues so declaration is closed
          }
          $op->concat('newinstance(__CLASS__, array(');
        } else {
          $op->concat('new self(');
        }
        if ($member->value) {
          $this->emitOne($op, $member->value);
        } else {
          $op->concat($i);
        }
        $op->concat(', \''.$member->name.'\')');
        if ($member->body) {
          $op->concat(', \'{ static function __static() { }');
          $sop= new String('');
          $this->emitAll($sop, $member->body['methods']);
          $op->concat($sop->replace("'", "\'"));
          $op->concat('}\');');
        } else {
          $op->concat(';');
        }
      }
      $op->concat('}');
      
      // public static self[] values() { return parent::membersOf(__CLASS__) }
      $op->concat('public static function values() { return parent::membersOf(__CLASS__); }');

      // Members
      $this->emitAll($op, (array)$declaration->body['fields']);
      $this->emitAll($op, (array)$declaration->body['methods']);
      $this->emitProperties($op, $this->properties[0]);

      // Finish
      $op->concat('}');
      
      $this->leave();
      $this->registerClass($op, $declaration->name->name, ($this->scope[0]->package ? $this->scope[0]->package->name.'.' : '').$declaration->name->name);
      array_shift($this->properties);
      array_shift($this->metadata);
    }

    /**
     * Emit a Interface declaration
     *
     * @param   resource op
     * @param   xp.compiler.ast.InterfaceNode declaration
     */
    protected function emitInterface($op, InterfaceNode $declaration) {
      if (!$declaration->comment) {
        $this->warn('D201', 'No api doc for interface '.$declaration->name->name, $declaration);
      }
      if (isset($declaration->body['fields'])) {
        $this->error('I403', 'Interfaces may not have field declarations', $declaration);
        return;
      }
      $this->enter(new TypeDeclarationScope());    

      // Ensure parent interfaces are loaded
      $this->emitUses($op, (array)$declaration->parents);

      $op->concat('interface '.$declaration->name->name);
      array_unshift($this->metadata, array(array(), array()));
      if ($declaration->parents) {
        $op->concat(' extends ');
        $s= sizeof($declaration->parents)- 1;
        foreach ((array)$declaration->parents as $i => $type) {
          $op->concat($this->resolveType($type, FALSE)->literal());
          $i < $s && $op->concat(', ');
        }
      }
      $op->concat(' {');
      $this->emitAll($op, (array)$declaration->body['methods']);
      $op->concat('}');
      
      $this->leave();
      $this->registerClass($op, $declaration->name->name, ($this->scope[0]->package ? $this->scope[0]->package->name.'.' : '').$declaration->name->name);
      array_shift($this->metadata);
    }

    /**
     * Emit a class declaration
     *
     * @param   resource op
     * @param   xp.compiler.ast.ClassNode declaration
     */
    protected function emitClass($op, ClassNode $declaration) {
      if (!$declaration->comment && !strstr($declaration->name->name, '$')) {
        $this->warn('D201', 'No api doc for class '.$declaration->name->name, $declaration);
      }
      $parent= $declaration->parent ? $declaration->parent : new TypeName('lang.Object');
      $parentType= $this->resolveType($parent, FALSE);
      $this->enter(new TypeDeclarationScope());    
      
      // Ensure parent class and interfaces are loaded
      $this->emitUses($op, array_merge(
        array($parent), 
        (array)$declaration->implements
      ));
    
      if (Modifiers::isAbstract($declaration->modifiers)) {
        $op->concat('abstract ');
      } else if (Modifiers::isFinal($declaration->modifiers)) {
        $op->concat('final ');
      }
      $op->concat(' class '.$declaration->name->name.' extends '.$parentType->literal());
      array_unshift($this->metadata, array(array(), array()));
      array_unshift($this->properties, array());
      array_unshift($this->inits, array(FALSE => array(), TRUE => array()));
      
      // Members
      $body= new String();
      isset($declaration->body['fields']) && $this->emitAll($body, $declaration->body['fields']);
      isset($declaration->body['methods']) && $this->emitAll($body, $declaration->body['methods']);
      $this->emitProperties($body, $this->properties[0]);

      // Interfaces
      if ($declaration->implements) {
        $op->concat(' implements ');
        $s= sizeof($declaration->implements)- 1;
        foreach ($declaration->implements as $i => $type) {
          $op->concat($type instanceof TypeName ? $this->resolveType($type, FALSE)->literal() : $type);
          $i < $s && $op->concat(', ');
        }
      }
      
      $op->concat('{');
      $op->concat($body);

      // Static initializer blocks (array<Statement[]>)
      if (isset($declaration->body['static']) || $this->inits[0][TRUE]) {
        $op->concat('static function __static() {');
        // oel_set_source_file($sop, $this->origins[0]);
        foreach ($this->inits[0][TRUE] as $field) {
          $this->emitOne($op, new AssignmentNode(array(
            'variable'   => new ClassMemberNode(array('class' => new TypeName('self'), 'member' => new VariableNode($field->name))),
            'expression' => $field->initialization,
            'free'       => TRUE,
            'op'         => '=',
          )));
        }
        foreach ((array)$declaration->body['static'] as $statements) {
          $this->emitAll($op, (array)$statements);
        }
        $op->concat('}');
      }
      
      // Generate a constructor if initializations are available.
      // They will have already been emitted if a constructor exists!
      if ($this->inits[0][FALSE]) {
        if ($parentType->hasConstructor()) {
          $arguments= array();
          $parameters= array();
          foreach ($parentType->getConstructor()->parameters as $i => $type) {
            $arguments[]= array('name' => '··a'.$i, 'type' => $type);    // TODO: default
            $parameters[]= new VariableNode('··a'.$i);
          }
          $body= array(new ClassMemberNode(array(
            'class'  => new TypeName('parent'),
            'member' => new InvocationNode(array(
              'name'       => '__construct',
              'parameters' => $parameters
            )),
            'free'   => TRUE
          )));
        } else {
          $body= array();
          $arguments= array();
        }
        $this->emitOne($op, new ConstructorNode(array(
          'modifiers'    => MODIFIER_PUBLIC,
          'arguments'    => $arguments,
          'annotations'  => NULL,
          'body'         => $body,
          'comment'      => '(Generated)',
          'position'     => $declaration->position
        )));
      }
      
      // Finish
      $op->concat('}');
      
      $this->metadata[0]['class']= array(
        DETAIL_COMMENT => preg_replace('/\n\s+\* ?/', "\n", "\n ".$declaration->comment)
      );

      $this->leave();      
      $this->registerClass($op, $declaration->name->name, ($this->scope[0]->package ? $this->scope[0]->package->name.'.' : '').$declaration->name->name);
      array_shift($this->properties);
      array_shift($this->metadata);
      array_shift($this->inits);      
    }

    /**
     * Emit instanceof
     *
     * @param   resource op
     * @param   xp.compiler.ast.InstanceOfNode instanceof
     */
    protected function emitInstanceOf($op, InstanceOfNode $instanceof) {
      $this->emitOne($op, $instanceof->expression);
      // oel_add_instanceof($op, $this->resolveType($instanceof->type)->literal());
      $instanceof->free && xp::stringOf(NULL); //  oel_add_free($op);
    }

    /**
     * Emit clone
     *
     * @param   resource op
     * @param   xp.compiler.ast.CloneNode clone
     */
    protected function emitClone($op, CloneNode $clone) {
      $op->concat('clone ');
      $this->emitOne($op, $clone->expression);
    }

    /**
     * Emit import
     *
     * @param   resource op
     * @param   xp.compiler.ast.ImportNode import
     */
    protected function emitImport($op, ImportNode $import) {
      if ('.*' == substr($import->name, -2)) {
        $this->scope[0]->addPackageImport(substr($import->name, 0, -2));
      } else {
        $this->scope[0]->addTypeImport($import->name);
      }
    }

    /**
     * Emit native import
     *
     * @param   resource op
     * @param   xp.compiler.ast.NativeImportNode import
     */
    protected function emitNativeImport($op, NativeImportNode $import) {
      $imported= $this->scope[0]->importer->import($import->name);
      if (0 === ($k= key($imported))) {
        $this->scope[0]->statics[0]= array_merge($this->scope[0]->statics[0], $imported[$k]);
      } else {
        $this->scope[0]->statics[$k]= $imported[$k];
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
        $this->scope[0]->statics[0][substr($import->name, 0, -2)]= $this->resolveType(new TypeName(substr($import->name, 0, -2)));
      } else {
        $p= strrpos($import->name, '.');
        $method= $this->resolveType(new TypeName(substr($import->name, 0, $p)))->getMethod(substr($import->name, $p+ 1));
        $this->scope[0]->statics[$method->name()]= $method;
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
      
      if (!$return->expression) {
        $op->concat('return');
      } else {
        $op->concat('return ');
        $this->emitOne($op, $return->expression);
      }
      $op->concat(';');
    }
    
    /**
     * Emit a single node
     *
     * @param   resource op
     * @param   xp.compiler.ast.Node in
     * @return  int
     */
    protected function emitOne($op, xp·compiler·ast·Node $in) {
      $node= $this->optimizations->optimize($in);
    
      // Search emission method
      $target= 'emit'.substr(get_class($node), 0, -strlen('Node'));
      if (method_exists($this, $target)) {
        // oel_set_source_line($op, $node->position[0]);
        $this->cat && $this->cat->debugf(
          '@%-3d Emit %s(free= %d): %s',
          $node->position[0], 
          $node->getClassName(), 
          $node->free, 
          $node->hashCode()
        );
        try {
          call_user_func_array(array($this, $target), array($op, $node));
        } catch (Throwable $e) {
          $this->error('0500', $e->toString(), $node);
          return 0;
        }
        $node->free && $op->concat(';');
        return 1;
      } else {
        $this->error('0422', 'Cannot emit '.$node->getClassName(), $node);
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
     * Resolve a type, raising an error message if type resolution
     * raises an error and return an unknown type reference in this
     * case.
     *
     * @param   xp.compiler.types.TypeName
     * @return  xp.compiler.types.Types
     */
    protected function resolveType(TypeName $t) {
      try {
        return $this->scope[0]->resolveType($t);
      } catch (ResolveException $e) {
        $this->error('R'.$e->getKind(), $e->compoundMessage());
        return new TypeReference($t->name, Types::UNKNOWN_KIND);
      }
    }

    /**
     * Entry point
     *
     * @param   xp.compiler.ast.ParseTree tree
     * @param   xp.compiler.types.Scope scope
     * @return  xp.compiler.Result
     */
    public function emit(ParseTree $tree, Scope $scope) {
      $this->messages= array(
        'warnings' => array(),
        'errors'   => array()
      );
      
      // Create and initialize op array
      $bytes= new String('');
      // oel_set_source_file($op, $tree->origin);
      // oel_set_source_line($op, 0);
      
      array_unshift($this->origins, $tree->origin);
      array_unshift($this->scope, $scope->enter(new CompilationUnitScope()));
      $this->scope[0]->importer= new NativeImporter();
      $this->scope[0]->declarations= array($tree->declaration);
      $this->scope[0]->package= $tree->package;
      
      // Functions from lang.base.php
      $this->scope[0]->statics= array(
        0             => array(),
        'newinstance' => TRUE,
        'with'        => TRUE,
        'create'      => TRUE,
        'raise'       => TRUE,
        'delete'      => TRUE,
        'cast'        => TRUE,
        'is'          => TRUE,
      );

      // Import and declarations
      $this->emitAll($bytes, (array)$tree->imports);
      while ($this->scope[0]->declarations) {
        $this->emitOne($bytes, current($this->scope[0]->declarations));
        array_shift($this->scope[0]->declarations);
      }

      // Load used classes
      $this->emitUses($bytes, $this->scope[0]->used);

      // Leave scope
      array_shift($this->origins);
      $this->leave();
      
      // Check on errors
      $this->cat && $this->cat->infof(
        '== %s: %d error(s), %d warning(s) ==', 
        basename($tree->origin), 
        sizeof($this->messages['errors']), 
        sizeof($this->messages['warnings'])
      );
      if ($this->messages['errors']) {
        throw new FormatException('Errors emitting '.$tree->origin.': '.xp::stringOf($this->messages));
      }

      // Finalize
      // oel_finalize($op);
      
      return new xp·compiler·emit·source·Result($bytes);
    }    
  }
?>
