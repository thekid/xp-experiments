<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler.emit.source';

  uses(
    'xp.compiler.emit.Emitter', 
    'xp.compiler.emit.NativeImporter',
    'xp.compiler.emit.source.Buffer', 
    'xp.compiler.emit.source.Result', 
    'xp.compiler.syntax.php.Lexer',
    'xp.compiler.syntax.php.Parser',
    'xp.compiler.syntax.xp.Lexer',
    'xp.compiler.syntax.xp.Parser',
    'xp.compiler.ast.StatementsNode',
    'xp.compiler.ast.LocalsToMemberPromoter',
    'xp.compiler.types.CompilationUnitScope',
    'xp.compiler.types.TypeDeclarationScope',
    'xp.compiler.types.MethodScope',
    'xp.compiler.types.CompiledType',
    'xp.compiler.types.TypeInstance',
    'lang.reflect.Modifiers',
    'util.collections.HashTable'
  );

  /**
   * Emits sourcecode using PHP sourcecode
   *
   * @test     xp://tests.execution.source.AnnotationTest
   * @test     xp://tests.execution.source.ArrayTest
   * @test     xp://tests.execution.source.AssignmentTest
   * @test     xp://tests.execution.source.CastingTest
   * @test     xp://tests.execution.source.CatchTest
   * @test     xp://tests.execution.source.ChainingTest
   * @test     xp://tests.execution.source.ClassDeclarationTest
   * @test     xp://tests.execution.source.ComparisonTest
   * @test     xp://tests.execution.source.ConcatTest
   * @test     xp://tests.execution.source.DefaultArgsTest
   * @test     xp://tests.execution.source.EnumDeclarationTest
   * @test     xp://tests.execution.source.ExtensionMethodsTest
   * @test     xp://tests.execution.source.FinallyTest
   * @test     xp://tests.execution.source.InstanceCreationTest
   * @test     xp://tests.execution.source.InterfaceDeclarationTest
   * @test     xp://tests.execution.source.LambdaTest
   * @test     xp://tests.execution.source.LoopExecutionTest
   * @test     xp://tests.execution.source.MathTest
   * @test     xp://tests.execution.source.MultiCatchTest
   * @test     xp://tests.execution.source.OperatorTest
   * @test     xp://tests.execution.source.PropertiesTest
   * @test     xp://tests.execution.source.StaticImportTest
   * @test     xp://tests.execution.source.TernaryOperatorTest
   * @test     xp://tests.execution.source.VarArgsTest
   * @test     xp://tests.execution.source.VariablesTest
   * @test     xp://tests.execution.source.WithTest
   * @see      xp://xp.compiler.ast.Node
   */
  class xp·compiler·emit·source·Emitter extends Emitter {
    protected 
      $op           = NULL,
      $method       = array(NULL),
      $finalizers   = array(NULL),
      $metadata     = array(NULL),
      $properties   = array(NULL),
      $inits        = array(NULL),
      $scope        = array(NULL),
      $local        = array(NULL),
      $types        = array(NULL);
    
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
     * Check whether a node is writeable - that is: can be the left-hand
     * side of an assignment
     *
     * @param   xp.compiler.ast.Node node
     * @return  bool
     */
    protected function isWriteable($node) {
      if ($node instanceof VariableNode || $node instanceof ArrayAccessNode) {
        return TRUE;
      } else if ($node instanceof ClassMemberNode) {
        return $this->isWriteable($node->member);
      } else if ($node instanceof MemberAccessNode) {
        return TRUE;    // TODO: Check for private, protected
      }
      return FALSE;
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
      $op->append('uses(');
      $s= sizeof($types)- 1;
      foreach ($types as $i => $type) {
        
        // Do not add uses() elements for types emitted inside the same sourcefile
        if (isset($this->local[0][$type->name])) continue;
        
        try {
          $op->append("'")->append($this->resolveType($type, FALSE)->name())->append("'");
          $i < $s && $op->append(',');
        } catch (Throwable $e) {
          $this->error('0424', $e->toString());
        }      
      }
      $op->append(');');
    }
    
    /**
     * Emit parameters
     *
     * @param   resource op
     * @param   xp.compiler.ast.Node[] params
     * @param   bool brackets
     * @return  int
     */
    protected function emitInvocationArguments($op, array $params, $brackets= TRUE) {
      $brackets && $op->append('(');
      $s= sizeof($params)- 1;
      foreach ($params as $i => $param) {
        $this->emitOne($op, $param);
        $i < $s && $op->append(',');
      }
      $brackets && $op->append(')');
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
          return;
        }
        $this->scope[0]->statics[$inv->name]= $resolved;         // Cache information
      }
      $ptr= $this->scope[0]->statics[$inv->name];

      // Static method call vs. function call
      if (TRUE === $ptr) {
        $op->append($inv->name);
        $this->emitInvocationArguments($op, (array)$inv->arguments);
        $this->scope[0]->setType($inv, TypeName::$VAR);
      } else {
        $op->append($ptr->holder->literal().'::'.$ptr->name());
        $this->emitInvocationArguments($op, (array)$inv->arguments);
        $this->scope[0]->setType($inv, $ptr->returns);
      }
    }
    
    /**
     * Emit strings
     *
     * @param   resource op
     * @param   xp.compiler.ast.StringNode str
     */
    protected function emitString($op, StringNode $str) {
      $op->append("'");
      $op->append(strtr($str->resolve(), array(
        "'"   => "\'",
        '\\'  => '\\\\'
      )));
      $op->append("'");
    }

    /**
     * Emit an array (a sequence of elements with a zero-based index)
     *
     * @param   resource op
     * @param   xp.compiler.ast.ArrayNode arr
     */
    protected function emitArray($op, ArrayNode $arr) {
      $op->append('array(');
      foreach ((array)$arr->values as $value) {
        $this->emitOne($op, $value);
        $op->append(',');
      }
      $op->append(')');
    }

    /**
     * Emit a map (a key/value pair dictionary)
     *
     * @param   resource op
     * @param   xp.compiler.ast.MapNode map
     */
    protected function emitMap($op, MapNode $map) {
      $op->append('array(');
      foreach ((array)$map->elements as $pair) {
        $this->emitOne($op, $pair[0]);
        $op->append(' => ');
        $this->emitOne($op, $pair[1]);
        $op->append(',');
      }
      $op->append(')');
    }

    /**
     * Emit booleans
     *
     * @param   resource op
     * @param   xp.compiler.ast.BooleanNode const
     */
    protected function emitBoolean($op, BooleanNode $const) {
      $op->append($const->resolve() ? 'TRUE' : 'FALSE');
    }

    /**
     * Emit null
     *
     * @param   resource op
     * @param   xp.compiler.ast.NullNode const
     */
    protected function emitNull($op, NullNode $const) {
      $op->append('NULL');
    }
    
    /**
     * Emit constants
     *
     * @param   resource op
     * @param   xp.compiler.ast.ConstantNode const
     */
    protected function emitConstant($op, ConstantNode $const) {
      if ($constant= $this->scope[0]->resolveConstant($const->value)) {
        $op->append(var_export($constant->value, TRUE));
        return;
      }

      try {
        $op->append(var_export($const->resolve(), TRUE));
      } catch (IllegalStateException $e) {
        $this->warn('T201', 'Constant lookup for '.$const->value.' deferred until runtime: '.$e->getMessage(), $const);
        $op->append($const->value);
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
        'int'     => '(int)',
        'double'  => '(double)',
        'string'  => '(string)',
        'array'   => '(array)',
        'bool'    => '(bool)',
        // Missing intentionally: object and unset casts
      );

      if ($cast->type->isPrimitive()) {
        $op->append($primitives[$cast->type->name]);
        $this->emitOne($op, $cast->expression);
      } else if ($cast->type->isArray() || $cast->type->isMap()) {
        $op->append('(array)');
        $this->emitOne($op, $cast->expression);
      } else if ($cast->check) {
        $op->append('cast(');
        $this->emitOne($op, $cast->expression);
        $op->append(', \'')->append($this->resolveType($cast->type)->name())->append('\')');
      } else {
        $this->emitOne($op, $cast->expression);
      }
      
      $this->scope[0]->setType($cast, $cast->type);
    }

    /**
     * Emit integers
     *
     * @param   resource op
     * @param   xp.compiler.ast.IntegerNode num
     */
    protected function emitInteger($op, IntegerNode $num) {
      $op->append($num->resolve());
    }

    /**
     * Emit decimals
     *
     * @param   resource op
     * @param   xp.compiler.ast.DecimalNode num
     */
    protected function emitDecimal($op, DecimalNode $num) {
      $r= $num->resolve();
      $op->append($r);
      
      // Prevent float(2) being dumped as "2" and thus an int literal
      strstr($r, '.') || $op->append('.0');
    }

    /**
     * Emit hex numbers
     *
     * @param   resource op
     * @param   xp.compiler.ast.HexNode num
     */
    protected function emitHex($op, HexNode $num) {
      $op->append($num->resolve());
    }
    
    /**
     * Emit a variable
     *
     * @param   resource op
     * @param   xp.compiler.ast.VariableNode var
     */
    protected function emitVariable($op, VariableNode $var) {
      $op->append('$'.$var->name);
    }

    /**
     * Emit a member access. Helper to emitChain()
     *
     * @param   resource op
     * @param   xp.compiler.ast.DynamicVariableReferenceNode access
     */
    public function emitDynamicMemberAccess($op, DynamicVariableReferenceNode $access) {
      $this->emitOne($op, $call->target);

      $op->append('->{');
      $this->emitOne($op, $access->expression);
      $op->append('}');
      
      $this->scope[0]->setType($call, TypeName::$VAR);
    }

    /**
     * Emit method call
     *
     * @param   resource op
     * @param   xp.compiler.ast.MethodCallNode call
     */
    public function emitMethodCall($op, MethodCallNode $call) {
      $op->mark();
      $this->emitOne($op, $call->target);
      
      // Check for extension methods
      $ptr= new TypeInstance($this->resolveType($this->scope[0]->typeOf($call->target)));
      if ($this->scope[0]->hasExtension($ptr, $call->name)) {
        $ext= $this->scope[0]->getExtension($ptr, $call->name);
        $op->insertAtMark($ext->holder->literal().'::'.$call->name.'(');
        $op->append(', ');
        $this->emitInvocationArguments($op, (array)$call->arguments);
        $op->append(')');
        $this->scope[0]->setType($call, $ext->returns);
        return;
      }

      // Manually verify as we can then rely on call target type being available
      if (!$this->checks->verify($call, $this->scope[0], $this, TRUE)) return;
      
      // Rewrite for unsupported syntax
      // - new Date().toString() to create(new Date()).toString()
      // - (<expr>).toString to create(<expr>).toString()
      if (
        $call->target instanceof InstanceCreationNode ||
        $call->target instanceof BracedExpressionNode
      ) {
        $op->insertAtMark('create(');
        $op->append(')');
      }

      $op->append('->'.$call->name);
      $this->emitInvocationArguments($op, (array)$call->arguments);

      // Record type
      $this->scope[0]->setType($call, $ptr->hasMethod($call->name) ? $ptr->getMethod($call->name)->returns : TypeName::$VAR);
    }

    /**
     * Emit member access
     *
     * @param   resource op
     * @param   xp.compiler.ast.MemberAccessNode access
     */
    public function emitMemberAccess($op, MemberAccessNode $access) {
      $op->mark();
      $this->emitOne($op, $access->target);
      
      $type= $this->scope[0]->typeOf($access->target);
      
      // Overload [...].length
      if ($type->isArray() && 'length' === $access->name) {
        $op->insertAtMark('sizeof(');
        $op->append(')');
        $this->scope[0]->setType($access, new TypeName('int'));
        return;
      }

      // Manually verify as we can then rely on call target type being available
      if (!$this->checks->verify($access, $this->scope[0], $this, TRUE)) return;

      // Rewrite for unsupported syntax
      // - new Person().name to create(new Person()).name
      // - (<expr>).name to create(<expr>).name
      if (
        $access->target instanceof InstanceCreationNode ||
        $access->target instanceof BracedExpressionNode
      ) {
        $op->insertAtMark('create(');
        $op->append(')');
      }

      $op->append('->'.$access->name);
      
      // Record type
      $ptr= new TypeInstance($this->resolveType($type));
      if ($ptr->hasField($access->name)) {
        $result= $ptr->getField($access->name)->type;
      } else if ($ptr->hasProperty($access->name)) {
        $result= $ptr->getProperty($access->name)->type;
      } else {
        $result= TypeName::$VAR;
      }
      $this->scope[0]->setType($access, $result);
    }

    /**
     * Emit array access
     *
     * @param   resource op
     * @param   xp.compiler.ast.ArrayAccessNode access
     */
    public function emitArrayAccess($op, ArrayAccessNode $access) {
      $op->mark();
      $this->emitOne($op, $access->target);
      
      $type= $this->scope[0]->typeOf($access->target);
      $result= TypeName::$VAR;
      if ($type->isArray()) {
        $result= $type->arrayComponentType();
      } else if ($type->isMap()) {
        $components= $type->mapComponentTypes();
        $result= $components[1];
      } else if ($type->isClass()) {
        $ptr= new TypeInstance($this->resolveType($type));
        if ($ptr->hasIndexer()) {
          $result= $ptr->getIndexer()->type;
        } else {
          $this->warn('T305', 'Type '.$ptr->name().' does not support offset access', $access);
        }
      } else if ($type->isVariable()) {
        $this->warn('T203', 'Array access (var)'.$access->hashCode().' verification deferred until runtime', $access);
      } else {
        $this->warn('T305', 'Using array-access on unsupported type '.$type->toString(), $access);
      }
      
      // Rewrite for unsupported syntax
      // - $a.getMethods()[2] to current(array_slice($a.getMethods(), 2, 1))
      // - T::asList()[2] to current(array_slice(T::asList()), 2, 1)
      // - new int[]{5, 6, 7}[2] to current(array_slice(array(5, 6, 7), 2, 1))
      if (
        !$access->target instanceof ArrayAccessNode && 
        !$access->target instanceof MemberAccessNode &&
        !$access->target instanceof VariableNode &&
        !$access->target instanceof ClassMemberNode
      ) {
        $op->insertAtMark('current(array_slice(');
        $op->append(',');
        $this->emitOne($op, $access->offset);
        $op->append(', 1))');
      } else {
        $op->append('[');
        $access->offset && $this->emitOne($op, $access->offset);
        $op->append(']');
      }
      $this->scope[0]->setType($access, $result);
    }

    /**
     * Emit a braced expression
     *
     * @param   resource op
     * @param   xp.compiler.ast.BracedExpressionNode const
     */
    protected function emitBracedExpression($op, BracedExpressionNode $braced) {
      $op->append('(');
      $this->emitOne($op, $braced->expression);
      $op->append(')');
    }

    /**
     * Emit binary operation node
     *
     * @param   resource op
     * @param   xp.compiler.ast.BinaryOpNode bin
     */
    protected function emitBinaryOp($op, BinaryOpNode $bin) {
      static $ops= array(
        '~'   => '.',
        '-'   => '-',
        '+'   => '+',
        '*'   => '*',
        '/'   => '/',
        '%'   => '%',
        '|'   => '|',
        '&'   => '&',
        '^'   => '^',
        '&&'  => '&&',
        '||'  => '||',
        '>>'  => '>>',
        '<<'  => '<<',
      );
      static $ovl= array(
        '~'   => 'concat',
        '-'   => 'minus',
        '+'   => 'plus',
        '*'   => 'times',
        '/'   => 'div',
        '%'   => 'mod',
      );
      
      $t= $this->scope[0]->typeOf($bin->lhs);
      if ($t->isClass()) {
        $ptr= $this->resolveType($t);
        if ($ptr->hasOperator($bin->op)) {
          $o= $ptr->getOperator($bin->op);
          $op->append($ptr->literal());
          $op->append('::operator··')->append($ovl[$bin->op])->append('(');
          $this->emitOne($op, $bin->lhs);
          $op->append(',');
          $this->emitOne($op, $bin->rhs);
          $op->append(')');

          $this->scope[0]->setType($bin, $o->returns);
          return;
        }
      }
      
      $this->emitOne($op, $bin->lhs);
      $op->append($ops[$bin->op]);
      $this->emitOne($op, $bin->rhs);
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
        $op->append('!');
        $this->emitOne($op, $un->expression);
        return;
      } else if ('-' === $un->op) {
        $op->append('-');
        $this->emitOne($op, $un->expression);
        return;
      } else if ('~' === $un->op) {
        $op->append('~');
        $this->emitOne($op, $un->expression);
        return;
      } else if (!$this->isWriteable($un->expression)) {
        $this->error('U400', 'Cannot perform unary '.$un->op.' on '.$un->expression->getClassName(), $un);
        return;
      }

      if ($un->postfix) {
        $this->emitOne($op, $un->expression);
        $op->append($ops[$un->op]);
      } else {
        $op->append($ops[$un->op]);
        $this->emitOne($op, $un->expression);
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
      $op->append('?');
      $this->emitOne($op, $ternary->expression ? $ternary->expression : $ternary->condition);
      $op->append(':');
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
      $op->append(' '.$ops[$cmp->op].' ');
      $this->emitOne($op, $cmp->rhs);
    }

    /**
     * Emit continue statement
     *
     * @param   resource op
     * @param   xp.compiler.ast.ContinueNode statement
     */
    protected function emitContinue($op, ContinueNode $statement) {
      $op->append('continue;');
    }

    /**
     * Emit break statement
     *
     * @param   resource op
     * @param   xp.compiler.ast.BreakNode statement
     */
    protected function emitBreak($op, BreakNode $statement) {
      $op->append('break;');
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
     * Emit with statement
     *
     * @param   resource op
     * @param   xp.compiler.ast.WithNode with
     */
    protected function emitWith($op, WithNode $with) {
      $this->emitAll($op, $with->assignments);
      $this->emitAll($op, $with->statements);
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
      $op->append('foreach (');
      $this->emitOne($op, $loop->expression);
      
      // Assign key and value types by checking for loop expression's type
      // * var type may be enumerable
      // * any other type may define an overlad
      $t= $this->scope[0]->typeOf($loop->expression);
      if ($t->isVariable()) {
        $this->warn('T203', 'Enumeration of (var)'.$loop->expression->hashCode().' verification deferred until runtime', $loop);
        $vt= TypeName::$VAR;
        $kt= new TypeName('int');
      } else {
        $ptr= $this->resolveType($t);
        if (!$ptr->isEnumerable()) {
          $this->warn('T300', 'Type '.$ptr->name().' is not enumerable in loop expression '.$loop->expression->getClassName().'['.$loop->expression->hashCode().']', $loop);
          $vt= TypeName::$VAR;
          $kt= new TypeName('int');
        } else {
          $enum= $ptr->getEnumerator();
          $vt= $enum->value;
          $kt= $enum->key;
        }
      }

      $op->append(' as ');
      if (isset($loop->assignment['key'])) {
        $op->append('$'.$loop->assignment['key'].' => ');
        $this->scope[0]->setType(new VariableNode($loop->assignment['key']), $kt);
      }
      $op->append('$'.$loop->assignment['value'].') {');
      $this->scope[0]->setType(new VariableNode($loop->assignment['value']), $vt);
      $this->emitAll($op, (array)$loop->statements);
      $op->append('}');
    }

    /**
     * Emit do ... while loop
     *
     * @param   resource op
     * @param   xp.compiler.ast.DoNode loop
     */
    protected function emitDo($op, DoNode $loop) {
      $op->append('do {');
      $this->emitAll($op, (array)$loop->statements);
      $op->append('} while (');
      $this->emitOne($op, $loop->expression);
      $op->append(');');
    }

    /**
     * Emit while loop
     *
     * @param   resource op
     * @param   xp.compiler.ast.WhileNode loop
     */
    protected function emitWhile($op, WhileNode $loop) {
      $op->append('while (');
      $this->emitOne($op, $loop->expression);
      $op->append(') {');
      $this->emitAll($op, (array)$loop->statements);
      $op->append('}');
    }
    
    /**
     * Emit components inside a for() statement
     *
     * @param   resource op
     * @return  xp.compiler.ast.Node[] nodes
     */
    protected function emitForComponent($op, array $nodes) {
      $s= sizeof($nodes)- 1;
      foreach ($nodes as $i => $node) {
        $this->emitOne($op, $node);
        $i < $s && $op->append(', ');
      }
    }

    /**
     * Emit for loop
     *
     * @param   resource op
     * @param   xp.compiler.ast.ForNode loop
     */
    protected function emitFor($op, ForNode $loop) {
      $op->append('for (');
      $this->emitForComponent($op, (array)$loop->initialization);
      $op->append(';');
      $this->emitForComponent($op, (array)$loop->condition);
      $op->append(';');
      $this->emitForComponent($op, (array)$loop->loop);
      $op->append(') {');
      $this->emitAll($op, (array)$loop->statements);
      $op->append('}');
    }
    
    /**
     * Emit if statement
     *
     * @param   resource op
     * @param   xp.compiler.ast.IfNode if
     */
    protected function emitIf($op, IfNode $if) {
      $op->append('if (');
      $this->emitOne($op, $if->condition);
      $op->append(') {');
      $this->emitAll($op, (array)$if->statements);
      $op->append('}');
      if ($if->otherwise) {
        $op->append('else {');
        $this->emitAll($op, (array)$if->otherwise->statements);
        $op->append('}');
      }
    }

    /**
     * Emit a switch case
     *
     * @param   resource op
     * @param   xp.compiler.ast.CaseNode case
     */
    protected function emitCase($op, CaseNode $case) {
      $op->append('case ');
      $this->emitOne($op, $case->expression);
      $op->append(': ');
      $this->emitAll($op, (array)$case->statements);
    }

    /**
     * Emit the switch default case
     *
     * @param   resource op
     * @param   xp.compiler.ast.DefaultNode default
     */
    protected function emitDefault($op, DefaultNode $default) {
      $op->append('default: ');
      $this->emitAll($op, (array)$default->statements);
    }

    /**
     * Emit switch statement
     *
     * @param   resource op
     * @param   xp.compiler.ast.SwitchNode switch
     */
    protected function emitSwitch($op, SwitchNode $switch) {
      $op->append('switch (');
      $this->emitOne($op, $switch->expression);
      $op->append(') {');
      $this->emitAll($op, (array)$switch->cases);
      $op->append('}');
    }
    
    /**
     * Emit class members, for example:
     * <code>
     *   XPClass::forName();        // static method call
     *   lang.types.String::class;  // special "class" member
     *   Tokens::T_STRING;          // class constant
     *   self::$instance;           // static member variable
     *   parent::__construct();     // super class call, here: constructor
     * </code>
     *
     * @param   resource op
     * @param   xp.compiler.ast.ClassMemberNode ref
     */
    protected function emitClassMember($op, ClassMemberNode $ref) {
      $ptr= $this->resolveType($ref->class);
      if ($ref->member instanceof InvocationNode) {
      
        if ('__construct' === $ref->member->name) {

          // Constructor calls. FIXME: Should this be a 
          if (!$ptr->hasConstructor()) {
            $this->warn('T305', 'Type '.$ptr->toString().' has no constructor', $ref);
          }
        } else {

          // Static method call
          if (!$ptr->hasMethod($ref->member->name)) {
            $this->warn('T305', 'Cannot resolve '.$ref->member->name.'() in type '.$ptr->toString(), $ref);
          } else {
            $m= $ptr->getMethod($ref->member->name);
            $this->scope[0]->setType($ref, $m->returns);
          }
        }

        $op->append($ptr->literal().'::'.$ref->member->name);
        $this->emitInvocationArguments($op, (array)$ref->member->arguments);
      } else if ($ref->member instanceof VariableNode) {
      
        // Static member
        if (!$ptr->hasField($ref->member->name)) {
          $this->warn('T305', 'Cannot resolve '.$ref->member->name.' in type '.$ptr->toString(), $ref);
        } else {
          $f= $ptr->getField($ref->member->name);
          $this->scope[0]->setType($ref, $f->type);
        }

        $op->append($ptr->literal().'::$'.$ref->member->name);
      } else if ($ref->member instanceof ConstantNode && 'class' === $ref->member->value) {
        
        // Magic "class" member
        $op->append('XPClass::forName(\''.$ptr->name().'\')');
        $this->scope[0]->setType($ref, new TypeName('lang.XPClass'));
      } else if ($ref->member instanceof ConstantNode) {

        // Class constant
        $op->append($ptr->literal().'::'.$ref->member->value);
      } else {
        $this->error('M405', 'Cannot emit class member '.xp::stringOf($ref->member), $ref);
        return;
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

      $op->append('try {'); {
        $this->emitAll($op, (array)$try->statements);
        $this->finalizers[0] && $this->emitOne($op, $this->finalizers[0]);
      }
      
      // First catch.
      $op->append('} catch('.$this->resolveType($first->type)->literal().' $'.$first->variable.') {'); {
        $this->scope[0]->setType(new VariableNode($first->variable->variable), $first->type);
        $this->emitAll($op, (array)$first->statements);
        $this->finalizers[0] && $this->emitOne($op, $this->finalizers[0]);
      }
      
      // Additional catches
      for ($i= 1; $i < $numHandlers; $i++) {
        $op->append('} catch('.$this->resolveType($try->handling[$i]->type)->literal().' $'.$try->handling[$i]->variable.') {'); {
          $this->scope[0]->setType(new VariableNode($try->handling[$i]->variable), $try->handling[$i]->type);
          $this->emitAll($op, (array)$try->handling[$i]->statements);
          $this->finalizers[0] && $this->emitOne($op, $this->finalizers[0]);
        }
      }
      
      $op->append('}');
      array_shift($this->finalizers);
    }

    /**
     * Emit an automatic resource management (ARM) block
     *
     * @param   resource op
     * @param   xp.compiler.ast.ArmNode arm
     */
    protected function emitArm($op, ArmNode $arm) {
      static $mangled= '··e';
      static $ignored= '··i';

      $this->emitAll($op, $arm->initializations);
      $op->append('$'.$mangled.'= NULL; try {');
      $this->emitAll($op, (array)$arm->statements);
      $op->append('} catch (Exception $'.$mangled.') {}');
      foreach ($arm->variables as $v) {
        $op->append('try { $')->append($v->name)->append('->close(); } catch (Exception $'.$ignored.') {}');
      }
      $op->append('if ($'.$mangled.') throw $'.$mangled.';'); 
    }
    
    /**
     * Emit a throw node
     *
     * @param   resource op
     * @param   xp.compiler.ast.ThrowNode throw
     */
    protected function emitThrow($op, ThrowNode $throw) {
      $op->append('throw ');
      $this->emitOne($op, $throw->expression);
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
     * Emit a dynamic instance creation node
     *
     * @param   resource op
     * @param   xp.compiler.ast.DynamicInstanceCreationNode new
     */
    protected function emitDynamicInstanceCreation($op, DynamicInstanceCreationNode $new) {
      $op->append('new ')->append('$')->append($new->variable);
      $this->emitInvocationArguments($op, (array)$new->parameters);
      
      $this->scope[0]->setType($new, new TypeName('lang.Object'));
    }

    /**
     * Emit an instance creation node
     *
     * @param   resource op
     * @param   xp.compiler.ast.InstanceCreationNode new
     */
    protected function emitInstanceCreation($op, InstanceCreationNode $new) {

      // Anonymous instance creation:
      //
      // - Create unique classname
      // - Extend parent class if type is a class
      // - Implement type and extend lang.Object if it's an interface 
      //
      // Do not register type name from new(), it will be added by 
      // emitClass() during declaration emittance.
      $generic= NULL;
      if (isset($new->body)) {
        $parent= $this->resolveType($new->type, $this, FALSE);
        if (Types::INTERFACE_KIND === $parent->kind()) {
          $p= array('parent' => new TypeName('lang.Object'), 'implements' => array($new->type));
          
          // If the interface we implement is generic, we need to
          // make the generated class a generic instance.
          if ($new->type->components) {
            $components= array();
            foreach ($new->type->components as $component) {
              $components[]= $this->resolveType($component, $this, FALSE)->name();
            }
            $generic= array($parent->name(), NULL, $components);
          }
          
        } else if (Types::ENUM_KIND === $parent->kind()) {
          $this->error('C405', 'Cannot create anonymous enums', $new);
          return;
        } else {
          $p= array('parent' => $new->type, 'implements' => NULL);
        }
        
        $unique= new TypeName($parent->literal().'··'.uniqid());
        $decl= new ClassNode(0, NULL, $unique, $p['parent'], $p['implements'], $new->body);
        $decl->synthetic= TRUE;
        $generic && $decl->generic= $generic;
        $ptr= new TypeDeclaration(new ParseTree(NULL, array(), $decl), $parent);
        $this->scope[0]->declarations[]= $decl;
        $this->scope[0]->setType($new, $unique);
        $this->scope[0]->addResolved($unique->name, $ptr);
      } else {
        $ptr= $this->resolveType($new->type);
        $this->scope[0]->setType($new, $new->type);
      }
      
      // If generic instance is created, use the create(spec, args*)
      // core functionality. If this a compiled generic type we may
      // do quite a bit better - but how do we detect this?
      if ($new->type->components && !$generic) {
        $op->append('create(\'new '.$ptr->name().'<');
        $s= sizeof($new->type->components)- 1;
        foreach ($new->type->components as $i => $component) {
          $op->append($this->resolveType($component)->name());
          $i < $s && $op->append(',');
        }
        $op->append('>\'');
        if ($new->parameters) {
          $op->append(',');
          $this->emitInvocationArguments($op, (array)$new->parameters, FALSE);
        }
        $op->append(')');
      } else {
        $op->append('new '.$ptr->literal());
        $this->emitInvocationArguments($op, (array)$new->parameters);
      }
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
        '|='   => '|=',
        '^='   => '^=',
        '&='   => '&=',
        '<<='  => '<<=',
        '>>='  => '>>=',
      );

      static $ovl= array(
        '~='   => 'concat',
        '-='   => 'minus',
        '+='   => 'plus',
        '*='   => 'times',
        '/='   => 'div',
        '%='   => 'mod',
      );

      $t= $this->scope[0]->typeOf($assign->variable);
      if ($t->isClass()) {
        $ptr= $this->resolveType($t);
        if ($ptr->hasOperator($assign->op{0})) {
          $o= $ptr->getOperator($assign->op{0});
          
          $this->emitOne($op, $assign->variable);
          $op->append('=');
          $op->append($ptr->literal());
          $op->append('::operator··')->append($ovl[$assign->op])->append('(');
          $this->emitOne($op, $assign->variable);
          $op->append(',');
          $this->emitOne($op, $assign->expression);
          $op->append(')');

          $this->scope[0]->setType($assign, $o->returns);
          return;
        }
      }
      
      // First set type to void, emit assignment, then overwrite type with
      // right-hand-side's type. This is done in order to guard for checks
      // on uninitialized variables, which is OK during assignment.
      $this->scope[0]->setType($assign->variable, TypeName::$VOID);
      $this->emitOne($op, $assign->variable);
      $op->append($ops[$assign->op]);
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
      static $ovl= array(
        '~'   => 'concat',
        '-'   => 'minus',
        '+'   => 'plus',
        '*'   => 'times',
        '/'   => 'div',
        '%'   => 'mod',
      );
      
      $this->enter(new MethodScope());

      $op->append('public static function operator··');
      $op->append($ovl[$operator->symbol]);
      $signature= $this->emitParameters($op, (array)$operator->parameters, '{');
      $this->emitAll($op, (array)$operator->body);
      $op->append('}');
      
      $this->leave();
      
      // Register type information
      $o= new xp·compiler·types·Operator();
      $o->symbol= $operator->symbol;
      $o->returns= new TypeName($this->resolveType($operator->returns)->name());
      $o->parameters= $signature;
      $o->modifiers= $operator->modifiers;
      $this->types[0]->addOperator($o);
    }

    /**
     * Emit method arguments
     *
     * @param   resource op
     * @param   array<string, *>[] arguments
     * @param   string delim
     * @return  xp.compiler.TypeName[] the signature
     */
    protected function emitParameters($op, array $arguments, $delim) {
      $signature= array();
      $op->append('(');
      $s= sizeof($arguments)- 1;
      $defer= array();
      foreach ($arguments as $i => $arg) {
        if (!$arg['type']) {
          $t= TypeName::$VAR;
          $ptr= new TypeReference($t);
        } else {
          $t= $arg['type'];
          $ptr= $this->resolveType($t);
          if (!$arg['check'] || isset($arg['vararg'])) {
            // No runtime type checks
          } else if ($t->isArray() || $t->isMap()) {
            $op->append('array ');
          } else if ($t->isClass() && !$this->scope[0]->declarations[0]->name->isPlaceHolder($t)) {
            $op->append($ptr->literal())->append(' ');
          } else {
            // No restriction on primitives possible in PHP
          }
        }
        $signature[]= new TypeName($ptr->name());
        
        $this->metadata[0][1][$this->method[0]->name][DETAIL_ARGUMENTS][$i]= $ptr->name();
        
        if (isset($arg['vararg'])) {
          if ($i > 0) {
            $defer[]= '$'.$arg['name'].'= array_slice(func_get_args(), '.$i.');';
          } else {
            $defer[]= '$'.$arg['name'].'= func_get_args();';
          }
          $this->scope[0]->setType(new VariableNode($arg['name']), new TypeName($t->name.'[]'));
          break;
        }
        
        $op->append('$'.$arg['name']);
        if (isset($arg['default'])) {
          $op->append('= ');
          $resolveable= FALSE; 
          if ($arg['default'] instanceof Resolveable) {
            try {
              $init= $arg['default']->resolve();
              $op->append(var_export($init, TRUE));
              $resolveable= TRUE; 
            } catch (IllegalStateException $e) {
            }
          }
          if (!$resolveable) {
            $op->append('NULL');
            $init= new xp·compiler·emit·source·Buffer('', $op->line);
            $init->append('if (func_num_args() < ')->append($i + 1)->append(') { ');
            $init->append('$')->append($arg['name'])->append('= ');
            $this->emitOne($init, $arg['default']);
            $init->append('; }');
            $defer[]= $init;
          }
        }
        $i < $s && !isset($arguments[$i+ 1]['vararg']) && $op->append(',');
        
        $this->scope[0]->setType(new VariableNode($arg['name']), $t);
      }
      $op->append(')');
      $op->append($delim);
      
      foreach ($defer as $src) {
        $op->append($src);
      }
      
      return $signature;
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
     * Emit a lambda
     *
     * @param   resource op
     * @param   xp.compiler.ast.LambdaNode lambda
     * @see     http://cr.openjdk.java.net/~mcimadamore/lambda_trans.pdf
     */
    protected function emitLambda($op, LambdaNode $lambda) {
      $unique= new TypeName('Lambda··'.uniqid());
      
      // Visit all statements, promoting local variable used within tp members
      $promoter= new LocalsToMemberPromoter();
      $parameters= $replaced= array();
      foreach ($lambda->parameters as $parameter) {
        $parameters[]= array('name' => $parameter->name, 'type' => TypeName::$VAR);
        $promoter->exclude($parameter->name);
      }
      $promoted= $promoter->promote($lambda);
      
      // Generate constructor
      $cparameters= $cstmt= $fields= array();
      foreach ($promoted['replaced'] as $name => $member) {
        $cparameters[]= array('name' => substr($name, 1), 'type' => TypeName::$VAR);
        $cstmt[]= new AssignmentNode(array(
          'variable'    => $member, 
          'expression'  => new VariableNode(substr($name, 1)), 
          'op'          => '='
        ));
        $fields[]= new FieldNode(array(
          'name'        => substr($name, 1), 
          'type'        => TypeName::$VAR)
        );
      }
      
      // Generate an anonymous lambda class
      $decl= new ClassNode(0, NULL, $unique, NULL, NULL, array_merge($fields, array(
        new ConstructorNode(array(
          'parameters' => $cparameters,
          'body'       => $cstmt
        )),
        new MethodNode(array(
          'name'        => 'invoke', 
          'parameters'  => $parameters,
          'body'        => $promoted['node']->statements,
          'returns'     => TypeName::$VAR
        ))
      )));
      $decl->synthetic= TRUE;
      $this->scope[0]->declarations[]= $decl;
      
      // Finally emit array(new [UNIQUE]([CAPTURE]), "method")
      $op->append('array(new '.$unique->name.'('.implode(',', array_keys($promoted['replaced'])).'), \'invoke\')');
    }

    /**
     * Emit a method
     *
     * @param   resource op
     * @param   xp.compiler.ast.MethodNode method
     */
    protected function emitMethod($op, MethodNode $method) {
      if ($method->extension) {
        $this->scope[0]->addExtension(
          $type= $this->resolveType($method->extension),
          $this->resolveType(new TypeName('self'))->getMethod($method->name)
        );
        $this->metadata[0]['EXT'][$method->name]= $type->literal();   // HACK, this should be accessible in scope
      }
      $op->append(implode(' ', Modifiers::namesOf($method->modifiers)));
      $op->append(' function '.$method->name);
      
      // Begin
      $this->enter(new MethodScope());
      if (!Modifiers::isStatic($method->modifiers)) {
        $this->scope[0]->setType(new VariableNode('this'), $this->scope[0]->declarations[0]->name);
      }
      
      $return= $this->resolveType($method->returns);
      $this->metadata[0][1][$method->name]= array(
        DETAIL_ARGUMENTS    => array(),
        DETAIL_RETURNS      => $return->name(),
        DETAIL_THROWS       => array(),
        DETAIL_COMMENT      => preg_replace('/\n\s+\* ?/', "\n  ", "\n ".$method->comment),
        DETAIL_ANNOTATIONS  => $this->annotationsAsMetadata((array)$method->annotations)
      );

      array_unshift($this->method, $method);

      // Parameters, body
      if (NULL !== $method->body) {
        $signature= $this->emitParameters($op, (array)$method->parameters, '{');
        $this->emitAll($op, $method->body);
        $op->append('}');
      } else {
        $signature= $this->emitParameters($op, (array)$method->parameters, ';');
      }
      
      // Finalize - FIXME: Put this in ...asMetadata()
      if ($this->scope[0]->declarations[0]->name->isGeneric()) {
      
        // Return type
        if ($this->scope[0]->declarations[0]->name->isPlaceholder($method->returns)) {
          $this->metadata[0][1][$method->name][DETAIL_ANNOTATIONS]['generic']['return']= $method->returns->compoundName();
        }
        
        // Parameters
        $genericParams= '';
        $usesGenerics= FALSE;
        foreach ((array)$method->parameters as $arg) {
          if (!$usesGenerics && $this->scope[0]->declarations[0]->name->isPlaceHolder($arg['type'])) $usesGenerics= TRUE;
          $genericParams.= ', '.$arg['type']->compoundName();
          $arg['vararg'] && $genericParams.= '...';
        }
        if ($usesGenerics) {
          $this->metadata[0][1][$method->name][DETAIL_ANNOTATIONS]['generic']['params']= substr($genericParams, 2);
        }
      }

      array_shift($this->method);
      $this->leave();
      
      // Register type information
      $m= new xp·compiler·types·Method();
      $m->name= $method->name;
      $m->returns= new TypeName($return->name());
      $m->parameters= $signature;
      $m->modifiers= $method->modifiers;
      $this->types[0]->addMethod($m);
    }

    /**
     * Emit static initializer
     *
     * @param   resource op
     * @param   xp.compiler.ast.StaticInitializerNode initializer
     */
    protected function emitStaticInitializer($op, StaticInitializerNode $initializer) {
      $op->append('static function __static() {');
      
      // Static initializations outside of initializer
      if ($this->inits[0][TRUE]) {
        foreach ($this->inits[0][TRUE] as $field) {
          $this->emitOne($op, new AssignmentNode(array(
            'variable'   => new ClassMemberNode(new TypeName('self'), new VariableNode($field->name)),
            'expression' => $field->initialization,
            'op'         => '=',
          )));
          $op->append(';');
        }
        unset($this->inits[0][TRUE]);
      }
      $this->emitAll($op, (array)$initializer->statements);
      $op->append('}');
    }

    /**
     * Emit a constructor
     *
     * @param   resource op
     * @param   xp.compiler.ast.ConstructorNode constructor
     */
    protected function emitConstructor($op, ConstructorNode $constructor) {
      $op->append(implode(' ', Modifiers::namesOf($constructor->modifiers)));
      $op->append(' function __construct');
      
      // Begin
      $this->enter(new MethodScope());
      $this->scope[0]->setType(new VariableNode('this'), $this->scope[0]->declarations[0]->name);

      $this->metadata[0][1]['__construct']= array(
        DETAIL_ARGUMENTS    => array(),
        DETAIL_RETURNS      => NULL,
        DETAIL_THROWS       => array(),
        DETAIL_COMMENT      => preg_replace('/\n\s+\* ?/', "\n  ", "\n ".$constructor->comment),
        DETAIL_ANNOTATIONS  => $this->annotationsAsMetadata((array)$constructor->annotations)
      );

      array_unshift($this->method, $constructor);

      // Arguments, initializations, body
      if (NULL !== $constructor->body) {
        $signature= $this->emitParameters($op, (array)$constructor->parameters, '{');
        if ($this->inits[0][FALSE]) {
          foreach ($this->inits[0][FALSE] as $field) {
            $this->emitOne($op, new AssignmentNode(array(
              'variable'   => new MemberAccessNode(new VariableNode('this'), $field->name),
              'expression' => $field->initialization,
              'op'         => '=',
            )));
            $op->append(';');
          }
          unset($this->inits[0][FALSE]);
        }
        $this->emitAll($op, $constructor->body);
        $op->append('}');
      } else {
        $signature= $this->emitParameters($op, (array)$constructor->parameters, ';');
      }
      
      // Finalize - FIXME: Put this in ...asMetadata()
      if ($this->scope[0]->declarations[0]->name->isGeneric()) {
      
        // Parameters
        $genericParams= '';
        $usesGenerics= FALSE;
        foreach ((array)$constructor->parameters as $arg) {
          if (!$usesGenerics && $this->scope[0]->declarations[0]->name->isPlaceHolder($arg['type'])) $usesGenerics= TRUE;
          $genericParams.= ', '.$arg['type']->compoundName();
          $arg['vararg'] && $genericParams.= '...';
        }
        if ($usesGenerics) {
          $this->metadata[0][1]['__construct'][DETAIL_ANNOTATIONS]['generic']['params']= substr($genericParams, 2);
        }
      }

      array_shift($this->method);
      $this->leave();

      // Register type information
      $c= new xp·compiler·types·Constructor();
      $c->parameters= $signature;
      $c->modifiers= $constructor->modifiers;
      $this->types[0]->constructor= $c;
    }
    
    /**
     * Emits class registration
     *
     * <code>
     *   xp::$registry['class.'.$name]= $qualified;
     *   xp::$registry['details.'.$qualified]= $meta;
     * </code>
     *
     * @param   resource op
     * @param   string name
     * @param   string qualified
     */
    protected function registerClass($op, $name, $qualified) {
      if (isset($this->metadata[0]['EXT'])) {     // HACK, this should be accessible in scope
        foreach ($this->metadata[0]['EXT'] as $method => $for) {
          $op->append('xp::$registry[\''.$for.'::'.$method.'\']= new ReflectionMethod(\''.$name.'\', \''.$method.'\');');
        }
      }
      unset($this->metadata[0]['EXT']);
      $op->append('xp::$registry[\'class.'.$name.'\']= \''.$qualified.'\';');
      $op->append('xp::$registry[\'details.'.$qualified.'\']= '.var_export($this->metadata[0], TRUE).';');
    }

    /**
     * Emit a class property
     *
     * @param   resource op
     * @param   xp.compiler.ast.IndexerNode indexer
     */
    protected function emitIndexer($op, IndexerNode $indexer) {
      $defines= array(
        'get'   => array('offsetGet', $indexer->parameters, $indexer->type),
        'set'   => array('offsetSet', array_merge($indexer->parameters, array(array('name' => 'value', 'type' => $indexer->type))), TypeName::$VOID),
        'isset' => array('offsetExists', $indexer->parameters, new TypeName('bool')),
        'unset' => array('offsetUnset', $indexer->parameters, TypeName::$VOID),
      );

      foreach ($indexer->handlers as $name => $statements) {
        $this->emitOne($op, new MethodNode(array(
          'modifiers'  => MODIFIER_PUBLIC,
          'annotations'=> NULL,
          'name'       => $defines[$name][0],
          'returns'    => $defines[$name][2],
          'parameters' => $defines[$name][1],
          'throws'     => NULL,
          'body'       => $statements,
          'extension'  => NULL,
          'comment'      => '(Generated)'
        )));
      }
      
      foreach ($indexer->parameters as $parameter) {
        $signature[]= new TypeName($this->resolveType($parameter['type'])->name());
      }

      // Register type information
      $i= new xp·compiler·types·Indexer();
      $i->type= new TypeName($this->resolveType($indexer->type)->name());
      $i->parameters= $signature;
      $i->modifiers= $indexer->modifiers;
      $this->types[0]->indexer= $i;
    }

    /**
     * Emit a class property
     *
     * @param   resource op
     * @param   xp.compiler.ast.PropertyNode property
     */
    protected function emitProperty($op, PropertyNode $property) {
      foreach ($property->handlers as $name => $statements) {
        $this->properties[0][$name][$property->name]= $statements;
      }

      // Register type information
      $p= new xp·compiler·types·Property();
      $p->name= $property->name;
      $p->type= new TypeName($this->resolveType($property->type)->name());
      $p->modifiers= $property->modifiers;
      $this->types[0]->addProperty($p);
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
      
      $auto= array();
      if (!empty($properties['get'])) {
        $op->append('function __get($'.$mangled.') {');
        $this->enter(new MethodScope());
        $this->scope[0]->setType(new VariableNode('this'), $this->scope[0]->declarations[0]->name);
        foreach ($properties['get'] as $name => $statements) {
          $op->append('if (\''.$name.'\' === $'.$mangled.') {');
          if (NULL === $statements) {
            $op->append('return $this->__·'.$name.';');
            $auto[$name]= TRUE;
          } else {
            $this->emitAll($op, $statements);
          }
          $op->append('} else ');
        }
        $op->append('return parent::__get($'.$mangled.'); }');
        $this->leave();
      }
      if (!empty($properties['set'])) {
        $op->append('function __set($'.$mangled.', $value) {');
        $this->enter(new MethodScope());
        $this->scope[0]->setType(new VariableNode('this'), $this->scope[0]->declarations[0]->name);
        foreach ($properties['set'] as $name => $statements) {
          $op->append('if (\''.$name.'\' === $'.$mangled.') {');
          if (NULL === $statements) {
            $op->append('$this->__·'.$name.'= $value;');
            $auto[$name]= TRUE;
          } else {
            $this->emitAll($op, $statements);
          }
          $op->append('} else ');
        }
        $op->append('parent::__set($'.$mangled.', $value); }');
        $this->leave();
      }
      
      // Declare auto-properties as private with NULL as initial value
      foreach ($auto as $name => $none) $op->append('private $__·'.$name.'= NULL;');
    }

    /**
     * Emit an enum member
     *
     * @param   resource op
     * @param   xp.compiler.ast.EnumMemberNode member
     */
    protected function emitEnumMember($op, EnumMemberNode $member) {
      $op->append('public static $'.$member->name.';');

      // Add field metadata (type, stored in @type annotation, see
      // lang.reflect.Field and lang.XPClass::detailsForField())
      $this->metadata[0][0][$member->name]= array(
        DETAIL_ANNOTATIONS  => array('type' => $this->resolveType(new TypeName('self'))->name())
      );
    }  

    /**
     * Emit a class constant
     *
     * @param   resource op
     * @param   xp.compiler.ast.ClassConstantNode const
     */
    protected function emitClassConstant($op, ClassConstantNode $const) {    
      $op->append('const ')->append($const->name)->append('=');
      $this->emitOne($op, $const->value);
      $op->append(';');
      
      // Register type information. 
      // Value can safely be resolved as only resolveable values are allowed
      $c= new xp·compiler·types·Constant();
      $c->type= new TypeName($this->resolveType($const->type)->name());
      $c->name= $const->name;
      $c->value= $const->value->resolve();
      $this->types[0]->addConstant($c);
    }
    
    /**
     * Emit a class field
     *
     * @param   resource op
     * @param   xp.compiler.ast.FieldNode field
     */
    protected function emitField($op, FieldNode $field) {    
      $static= Modifiers::isStatic($field->modifiers);
      
      // See whether an initialization is necessary
      $initializable= FALSE;
      if ($field->initialization) {
        if ($field->initialization instanceof Resolveable) {
          try {
            $init= $field->initialization->resolve();
            $initializable= TRUE;
          } catch (IllegalStateException $e) {
            $this->warn('R100', $e->getMessage(), $field->initialization);
          }
        } else {    // Need to initialize these later
          $this->inits[0][$static][]= $field;
        }
      }

      
      if (Modifiers::isPublic($field->modifiers)) {
        $op->append('public ');
      } else if (Modifiers::isProtected($field->modifiers)) {
        $op->append('protected ');
      } else if (Modifiers::isPrivate($field->modifiers)) {
        $op->append('private ');
      }
      if (Modifiers::isStatic($field->modifiers)) {
        $op->append('static ');
      }
      $op->append('$'.$field->name);
      $initializable && $op->append('= ')->append(var_export($init, TRUE));
      $op->append(';');

      // Add field metadata (type, stored in @type annotation, see
      // lang.reflect.Field and lang.XPClass::detailsForField()). If
      // the field is "var" and we have an initialization, determine
      // the type from that
      if ($field->type->isVariable() && $field->initialization) {
        $field->type= $this->scope[0]->typeOf($field->initialization);
      }
      $type= $this->resolveType($field->type);
      $this->metadata[0][0][$field->name]= array(
        DETAIL_ANNOTATIONS  => array('type' => $type->name())
      );

      // Register type information
      $f= new xp·compiler·types·Field();
      $f->name= $field->name;
      $f->type= new TypeName($type->name());
      $f->modifiers= $field->modifiers;
      $this->types[0]->addField($f);
    }
    
    /**
     * Emit type name and modifiers
     *
     * @param   resource op
     * @param   string type
     * @param   xp.compiler.ast.TypeDeclarationNode declaration
     * @param   xp.compiler.types.TypeName[] dependencies
     */
    protected function emitTypeName($op, $type, TypeDeclarationNode $declaration, $dependencies) {

      // Check whether class needs to be fully qualified
      if ($declaration->modifiers & MODIFIER_PACKAGE) {
        $op->append('$package= \'')->append($this->scope[0]->package->name)->append("';");
        $declaration->literal= strtr($this->scope[0]->package->name, '.', '·').'·'.$declaration->name->name;
      } else {
        $declaration->literal= $declaration->name->name;
      }
      
      // Ensure parent class and interfaces are loaded.
      $this->emitUses($op, $dependencies);

      // Emit abstract and final modifiers
      if (Modifiers::isAbstract($declaration->modifiers)) {
        $op->append('abstract ');
      } else if (Modifiers::isFinal($declaration->modifiers)) {
        $op->append('final ');
      } 
      
      // Emit declaration
      $op->append(' ')->append($type)->append(' ')->append($declaration->literal);
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
     * @param   resource op
     * @param   xp.compiler.ast.EnumNode declaration
     */
    protected function emitEnum($op, EnumNode $declaration) {
      $parent= $declaration->parent ? $declaration->parent : new TypeName('lang.Enum');
      $parentType= $this->resolveType($parent, FALSE);
      $thisType= $this->resolveType($declaration->name, FALSE);
      $this->scope[0]->addResolved($declaration->name->name, $thisType);
      $this->scope[0]->imports[$declaration->name->name]= $declaration->name->name;   // FIXME: ???
      $this->enter(new TypeDeclarationScope());

      // Ensure parent class and interfaces are loaded
      $this->emitTypeName($op, 'class', $declaration, array_merge(
        array($parent), 
        (array)$declaration->implements
      ));
      $op->append(' extends '.$parentType->literal());
      array_unshift($this->metadata, array(array(), array()));
      array_unshift($this->properties, array('get' => array(), 'set' => array()));
      $abstract= Modifiers::isAbstract($declaration->modifiers);

      // Interfaces
      if ($declaration->implements) {
        $op->append(' implements ');
        $s= sizeof($declaration->implements)- 1;
        foreach ($declaration->implements as $i => $type) {
          $op->append($this->resolveType($type, FALSE)->literal());
          $i < $s && $op->append(', ');
        }
      }
      
      // Member declaration
      $op->append(' {');
      
      // public static self[] values() { return parent::membersOf(__CLASS__) }
      $declaration->body[]= new MethodNode(array(
        'modifiers'  => MODIFIER_PUBLIC | MODIFIER_STATIC,
        'annotations'=> NULL,
        'name'       => 'values',
        'returns'    => new TypeName('self[]'),
        'parameters' => NULL,
        'throws'     => NULL,
        'body'       => array(
          new ReturnNode(new ClassMemberNode(
            new TypeName('parent'),
            new InvocationNode('membersOf', array(new StringNode($thisType->literal())))
          ))
        ),
        'extension'  => NULL,
        'comment'    => '(Generated)'
      ));

      // Members
      foreach ((array)$declaration->body as $node) {
        $this->emitOne($op, $node);
      }
      $this->emitProperties($op, $this->properties[0]);
      
      // Initialization
      $op->append('static function __static() {');
      foreach ($declaration->body as $i => $member) {
        if (!$member instanceof EnumMemberNode) continue;
        $op->append('self::$'.$member->name.'= ');
        if ($member->body) {
          if (!$abstract) {
            $this->error('E403', 'Only abstract enums can contain members with bodies ('.$member->name.')');
            // Continues so declaration is closed
          }
          
          $unique= new TypeName($declaration->name->name.'··'.$member->name);
          $decl= new ClassNode(0, NULL, $unique, $declaration->name, array(), $member->body);
          $decl->synthetic= TRUE;
          $ptr= new TypeDeclaration(new ParseTree(NULL, array(), $decl), $thisType);
          $this->scope[0]->declarations[]= $decl;
          $this->scope[0]->addResolved($unique->name, $ptr);
          $op->append('new '.$unique->name.'(');
        } else {
          $op->append('new self(');
        }
        if ($member->value) {
          $this->emitOne($op, $member->value);
        } else {
          $op->append($i);
        }
        $op->append(', \''.$member->name.'\');');
      }
      $op->append('}');

      // Finish
      $op->append('}');

      $this->metadata[0]['class']= array(
        DETAIL_COMMENT     => preg_replace('/\n\s+\* ?/', "\n", "\n ".$declaration->comment),
        DETAIL_ANNOTATIONS => $this->annotationsAsMetadata((array)$declaration->annotations)
      );
      
      $this->leave();
      $this->registerClass($op, $declaration->literal, ($this->scope[0]->package ? $this->scope[0]->package->name.'.' : '').$declaration->name->name);
      array_shift($this->properties);
      array_shift($this->metadata);

      // Register type info
      $this->types[0]->name= ($this->scope[0]->package ? $this->scope[0]->package->name.'.' : '').$declaration->name->name;
      $this->types[0]->kind= Types::ENUM_KIND;
      $this->types[0]->literal= $declaration->literal;
      $this->types[0]->parent= $parentType;
    }

    /**
     * Emit a Interface declaration
     *
     * @param   resource op
     * @param   xp.compiler.ast.InterfaceNode declaration
     */
    protected function emitInterface($op, InterfaceNode $declaration) {
      $this->enter(new TypeDeclarationScope());    
      $this->emitTypeName($op, 'interface', $declaration, (array)$declaration->parents);
      array_unshift($this->metadata, array(array(), array()));
      if ($declaration->parents) {
        $op->append(' extends ');
        $s= sizeof($declaration->parents)- 1;
        foreach ((array)$declaration->parents as $i => $type) {
          $op->append($this->resolveType($type, FALSE)->literal());
          $i < $s && $op->append(', ');
        }
      }
      $op->append(' {');
      foreach ((array)$declaration->body as $node) {
        $this->emitOne($op, $node);
      }
      $op->append('}');

      $this->metadata[0]['class']= array(
        DETAIL_COMMENT     => preg_replace('/\n\s+\* ?/', "\n", "\n ".$declaration->comment),
        DETAIL_ANNOTATIONS => $this->annotationsAsMetadata((array)$declaration->annotations)
      );
      
      $this->leave();
      $this->registerClass($op, $declaration->literal, ($this->scope[0]->package ? $this->scope[0]->package->name.'.' : '').$declaration->name->name);
      array_shift($this->metadata);

      // Register type info
      $this->types[0]->name= ($this->scope[0]->package ? $this->scope[0]->package->name.'.' : '').$declaration->name->name;
      $this->types[0]->kind= Types::INTERFACE_KIND;
      $this->types[0]->literal= $declaration->literal;
      $this->types[0]->parent= NULL;
    }

    /**
     * Emit a class declaration
     *
     * @param   resource op
     * @param   xp.compiler.ast.ClassNode declaration
     */
    protected function emitClass($op, ClassNode $declaration) {
      $parent= $declaration->parent ? $declaration->parent : new TypeName('lang.Object');
      $parentType= $this->resolveType($parent, FALSE);
      $this->enter(new TypeDeclarationScope());    
      $this->emitTypeName($op, 'class', $declaration, array_merge(
        $declaration->parent ? array($parent) : array(),
        (array)$declaration->implements
      ));
      $op->append(' extends '.$parentType->literal());
      array_unshift($this->metadata, array(array(), array()));
      array_unshift($this->properties, array());
      array_unshift($this->inits, array(FALSE => array(), TRUE => array()));
      
      // Check if we need to implement ArrayAccess
      foreach ((array)$declaration->body as $node) {
        if ($node instanceof IndexerNode) {
          $declaration->implements[]= 'ArrayAccess';
        }
      }
      
      // Interfaces
      if ($declaration->implements) {
        $op->append(' implements ');
        $s= sizeof($declaration->implements)- 1;
        foreach ($declaration->implements as $i => $type) {
          $op->append($type instanceof TypeName ? $this->resolveType($type, FALSE)->literal() : $type);
          $i < $s && $op->append(', ');
        }
      }
      
      // Members
      $op->append('{');
      foreach ((array)$declaration->body as $node) {
        $this->emitOne($op, $node);
      }
      $this->emitProperties($op, $this->properties[0]);
      
      // Generate a constructor if initializations are available.
      // They will have already been emitted if a constructor exists!
      if ($this->inits[0][FALSE]) {
        if ($parentType->hasConstructor()) {
          $arguments= array();
          $parameters= array();
          foreach ($parentType->getConstructor()->parameters as $i => $type) {
            $parameters[]= array('name' => '··a'.$i, 'type' => $type);    // TODO: default
            $arguments[]= new VariableNode('··a'.$i);
          }
          $body= array(new ClassMemberNode(new TypeName('parent'), new InvocationNode('__construct', $arguments)));
        } else {
          $body= array();
          $arguments= array();
        }
        $this->emitOne($op, new ConstructorNode(array(
          'modifiers'    => MODIFIER_PUBLIC,
          'parameters'   => $parameters,
          'annotations'  => NULL,
          'body'         => $body,
          'comment'      => '(Generated)',
          'position'     => $declaration->position
        )));
      }

      // Generate a static initializer if initializations are available.
      // They will have already been emitted if a static initializer exists!
      if ($this->inits[0][TRUE]) {
        $this->emitOne($op, new StaticInitializerNode(NULL));
      }
      
      // Generics
      $meta= array();
      if ($declaration->name->isGeneric()) {
        $meta= array('generic' => array('self' => ''));
        $s= sizeof($declaration->name->components)- 1;
        foreach ($declaration->name->components as $i => $component) {
          $meta['generic']['self'].= ($i < $s ? ', ' : '').$component->compoundName();
        }
      }
      
      // Finish
      $op->append('}');
      
      $this->metadata[0]['class']= array(
        DETAIL_COMMENT     => preg_replace('/\n\s+\* ?/', "\n", "\n ".$declaration->comment),
        DETAIL_ANNOTATIONS => array_merge($meta, $this->annotationsAsMetadata((array)$declaration->annotations))
      );

      // Generic instances have {definition-type, null, [argument-type[0..n]]} 
      // stored  as type names in their details
      if (isset($declaration->generic)) {
        $this->metadata[0]['class'][DETAIL_GENERIC]= $declaration->generic;
      }

      $this->leave();
      $this->registerClass($op, $declaration->literal, ($this->scope[0]->package ? $this->scope[0]->package->name.'.' : '').$declaration->name->name);
      array_shift($this->properties);
      array_shift($this->metadata);
      array_shift($this->inits);

      // Register type info
      $this->types[0]->name= ($this->scope[0]->package ? $this->scope[0]->package->name.'.' : '').$declaration->name->name;
      $this->types[0]->kind= Types::CLASS_KIND;
      $this->types[0]->literal= $declaration->literal;
      $this->types[0]->parent= $parentType;
    }

    /**
     * Emit dynamic instanceof
     *
     * @param   resource op
     * @param   xp.compiler.ast.DynamicInstanceOfNode instanceof
     */
    protected function emitDynamicInstanceOf($op, DynamicInstanceOfNode $instanceof) {
      $this->emitOne($op, $instanceof->expression);
      $op->append(' instanceof ')->append('$')->append($instanceof->variable);
    }

    /**
     * Emit instanceof
     *
     * @param   resource op
     * @param   xp.compiler.ast.InstanceOfNode instanceof
     */
    protected function emitInstanceOf($op, InstanceOfNode $instanceof) {
      $this->emitOne($op, $instanceof->expression);
      $op->append(' instanceof ')->append($this->resolveType($instanceof->type)->literal());
    }

    /**
     * Emit clone
     *
     * @param   resource op
     * @param   xp.compiler.ast.CloneNode clone
     */
    protected function emitClone($op, CloneNode $clone) {
      $op->append('clone ');
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
        $op->append('return');
      } else {
        $op->append('return ');
        $this->emitOne($op, $return->expression);
      }
    }

    /**
     * Emit a silence node
     *
     * @param   resource op
     * @param   xp.compiler.ast.SilenceOperatorNode silenced
     */
    protected function emitSilenceOperator($op, SilenceOperatorNode $silenced) {
      $op->append('@');
      $this->emitOne($op, $silenced->expression);
      $this->scope[0]->setType($silenced, $this->scope[0]->typeOf($silenced->expression));
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
        $op->position($node->position);
        $this->cat && $this->cat->debugf(
          '@%-3d Emit %s: %s',
          $node->position[0], 
          $node->getClassName(), 
          $node->hashCode()
        );
        try {
          $this->checks->verify($node, $this->scope[0], $this) && call_user_func(array($this, $target), $op, $node);
        } catch (Throwable $e) {
          $this->error('0500', $e->toString(), $node);
          return 0;
        }
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
        $op->append(';');
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
        $ptr= $this->scope[0]->resolveType($t);
        $this->cat && $this->cat->info('Resolve', $t, '=', $ptr);
        return $ptr;
      } catch (ResolveException $e) {
        $this->cat && $this->cat->warn('Resolve', $t, '~', $e->compoundMessage());
        $this->error('R'.$e->getKind(), $e->compoundMessage());
        return new TypeReference($t, Types::UNKNOWN_KIND);
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
      $bytes= new xp·compiler·emit·source·Buffer('', 1);
      
      array_unshift($this->local, array());
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
        'isset'       => TRUE,
        'unset'       => TRUE,
        'empty'       => TRUE,
        'eval'        => TRUE,
        'include'     => TRUE,
        'require'     => TRUE,
        'include_once'=> TRUE,
        'require_once'=> TRUE,
      );

      $this->cat && $this->cat->infof('== Enter %s ==', basename($tree->origin));

      // Import and declarations
      $t= NULL;
      $this->emitAll($bytes, (array)$tree->imports);
      while ($this->scope[0]->declarations) {
        array_unshift($this->types, new CompiledType());

        $decl= current($this->scope[0]->declarations);
        $this->local[0][$decl->name->name]= TRUE;
        $this->emitOne($bytes, $decl);
        array_shift($this->scope[0]->declarations);

        $t || $t= $this->types[0];
      }

      // Load used classes
      $this->emitUses($bytes, $this->scope[0]->used);

      // Leave scope
      array_shift($this->local);
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
      return new xp·compiler·emit·source·Result($t, $bytes);
    }    
  }
?>
