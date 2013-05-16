<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'xp.codegen.cut';
  
  uses(
    'xp.codegen.AbstractGenerator',
    'io.File', 
    'io.streams.FileInputStream',
    'xp.compiler.Parser',
    'xp.compiler.Lexer',
    'util.collections.HashTable',
    'lang.types.String',
    'lang.types.Integer'
  );

  /**
   * CUT
   * ====
   * This utility generates classes from a unittest
   *
   * Usage:
   * <pre>
   *   $ cgen ... cut TestClass.class.php
   * </pre>
   *
   * @purpose  Code generator
   */
  class xp·codegen·cut·Generator extends AbstractGenerator {
    protected
      $file        = '';
    
    /**
     * Constructor
     *
     * @param   util.cmd.ParamString args
     */
    public function __construct(ParamString $args) {
      $this->file= new File($args->value(0));
    }
    
    /**
     * Parses tokens
     *
     */
    #[@target]
    public function parse($tokens) {
      switch ($ext= $this->file->getExtension()) {
        case 'xp': 
          $tree= create(new Parser())->parse(new xp·compiler·Lexer(
            new FileInputStream($this->file),
            $this->file->getURI()
          ));
          break;

        default:
          throw new IllegalArgumentException('Cannot parse '.$ext.' files');
      }

      return $tree;
    }
    
    protected static function typeOf(HashTable $types, xp·compiler·ast·Node $node) {
      if ($node instanceof InstanceCreationNode) {
        return $node->type->name;
      } else if ($node instanceof VariableNode) {
        return $types[$node->name];
      } else {
        return NULL;
      }
    }
    
    protected static function declareMethod(HashTable $decl, $name, $modifiers) {
      $decl['methods'][$name]= new HashTable();
      $decl['methods'][$name]['modifiers']= new Integer($modifiers);
    }

    protected static function declareField(HashTable $decl, $name, $modifiers) {
      $decl['fields'][$name]= new HashTable();
      $decl['fields'][$name]['modifiers']= new Integer($modifiers);
    }
    
    protected static function discover(HashTable $decl, HashTable $types, array $nodes) {
      foreach ($nodes as $n) {
        if ($n instanceof AssignmentNode) {
          $types[$n->variable->name]= new String(self::typeOf($types, $n->expression));
          self::discover($decl, $types, array($n->expression));
        } else if ($n instanceof VariableNode) {
          $declare= $decl['class']->equals(self::typeOf($types, $n));
          if ($n->chained instanceof InvocationNode) {
            $declare && self::declareMethod($decl, $n->chained->name, MODIFIER_PUBLIC);
            self::discover($decl, $types, (array)$n->chained->parameters);
          } else if ($n->chained instanceof VariableNode) {
            $declare && self::declareField($decl, $n->chained->name, MODIFIER_PUBLIC);
          }
        } else if ($n instanceof InstanceCreationNode) {
          self::discover($decl, $types, (array)$n->parameters);
        } else if ($n instanceof InvocationNode) {
          self::discover($decl, $types, (array)$n->parameters);
        } else if ($n instanceof ClassMemberNode) {
          $declare= $decl['class']->equals(new String($n->class->name));
          if ($n->member instanceof InvocationNode) {
            $declare && self::declareMethod($decl, $n->member->name, MODIFIER_PUBLIC | MODIFIER_STATIC);
            self::discover($decl, $types, (array)$n->chained->parameters);
          } else if ($n->member instanceof VariableNode) {
            $declare && self::declareField($decl, $n->member->name, MODIFIER_PUBLIC | MODIFIER_STATIC);
          }          
        } else if ($n instanceof IfNode) {
          self::discover($decl, $types, array($n->condition));
          self::discover($decl, $types, (array)$n->statements);
          self::discover($decl, $types, (array)$n->otherwise->statements);
        } else if ($n instanceof SwitchNode) {
          self::discover($decl, $types, array($n->expression));
          foreach ($n->cases as $case) {
            self::discover($decl, $types, (array)$case->statements);
          }
        } else if ($n instanceof ForeachNode) {
          self::discover($decl, $types, array($n->expression));
          self::discover($decl, $types, (array)$n->statements);
        } else if ($n instanceof ForNode) {
          self::discover($decl, $types, (array)$n->initialization);
          self::discover($decl, $types, (array)$n->loop);
          self::discover($decl, $types, (array)$n->condition);
          self::discover($decl, $types, (array)$n->statements);
        } else if ($n instanceof WhileNode) {
          self::discover($decl, $types, array($n->expression));
          self::discover($decl, $types, (array)$n->statements);
        } else if ($n instanceof DoNode) {
          self::discover($decl, $types, array($n->expression));
          self::discover($decl, $types, (array)$n->statements);
        } else if ($n instanceof TryNode) {
          self::discover($decl, $types, (array)$n->statements);
          foreach ($n->handling as $handler) {
            self::discover($decl, $types, (array)$handler->statements);
          }
        } else if ($n instanceof ComparisonNode) {
          self::discover($decl, $types, array($n->lhs));
          self::discover($decl, $types, array($n->rhs));
        } else if ($n instanceof BinaryOpNode) {
          self::discover($decl, $types, array($n->lhs));
          self::discover($decl, $types, array($n->rhs));
        } else if ($n instanceof UnaryOpNode) {
          self::discover($decl, $types, array($n->expression));
        } else if ($n instanceof ConstantValueNode) {
          // NOOP
        } else {
          throw new IllegalStateException('Cannot handle '.$n->toString());
        }
      }
    }

    /**
     * Creates declaration from parse tree
     *
     */
    #[@target(input= array('parse'))]
    public function declaration($tree) {
      $testClass= new String($tree->declaration->name->name);
    
      $decl= new HashTable();
      $decl['class']= $testClass->substring(0, -4);
      $decl['methods']= new HashTable();
      $decl['fields']= new HashTable();

      foreach ($tree->declaration->body['methods'] as $member) {
        $types= new HashTable();
        $types['$this']= $testClass;
        self::discover($decl, $types, (array)$member->body);
      }
      return $decl;
    }
    
    protected static function line() {
      $args= func_get_args();
      return implode('', $args)."\n";
    }

    /**
     * Writes declaration
     *
     */
    #[@target(input= array('declaration', 'output'))]
    public function write($decl, $out) {
      with ($src= ''); {

        // Header
        $src.= self::line('<?php');
        $src.= self::line('/* This class is part of the XP framework');
        $src.= self::line(' *');
        $src.= self::line(' * $Id$');
        $src.= self::line(' */');
        $src.= self::line('');
        
        // Class
        $src.= self::line('  /**');
        $src.= self::line('   * (Insert class\' description here)');
        $src.= self::line('   *');
        $src.= self::line('   */');
        $src.= self::line('  class ', $decl['class'], ' extends Object {');

        // Fields
        foreach ($decl['fields']->keys() as $name) {
          $field= $decl['fields'][$name];
          $src.= self::line('    ', implode(' ', Modifiers::namesOf($field['modifiers']->value)), ' $', $name, ';');
        }
        
        // Methods
        $src.= self::line('');
        foreach ($decl['methods']->keys() as $name) {
          $method= $decl['methods'][$name];
          $src.= self::line('    /**');
          $src.= self::line('     * (Insert method\'s description here)');
          $src.= self::line('     *');
          $src.= self::line('     */');
          $src.= self::line('    ', implode(' ', Modifiers::namesOf($method['modifiers']->value)), ' function ', $name, '()', ' {');
          $src.= self::line('      raise(\'lang.MethodNotImplementedException\', \'', $name, '() not yet implemented\');');
          $src.= self::line('    }');
          $src.= self::line('');
        }
        
        // Close
        $src.= self::line('  }');
        $src.= self::line('?>');

        $out->append($decl['class'].xp::CLASS_FILE_EXT, $src);
      }
    }

    /**
     * Creates a string representation of this generator
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'['.$this->file->toString().']';
    }
  }
?>
