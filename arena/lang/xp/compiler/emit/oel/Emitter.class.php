<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler.emit.oel';

  uses('xp.compiler.emit.Emitter', 'lang.reflect.Modifiers');

  /**
   * (Insert class' description here)
   *
   * @ext      oel
   * @see      xp://xp.compiler.ast.Node
   */
  class xp·compiler·emit·oel·Emitter extends Emitter {
    protected $op= NULL;
    protected $errors= array();
    
    protected function emitInvocation($op, $inv) {
      $n= $this->emitAll($op, $inv->parameters);
      oel_add_call_function($op, $n, $inv->name);
      oel_add_free($op);
    }
    
    protected function emitString($op, $str) {
      oel_push_value($op, $str->value);
    }
    
    protected function emitVariable($op, $var) {
      oel_add_begin_variable_parse($op);
      oel_push_variable($op, ltrim($var->name, '$'));    // without '$'
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
    protected function emitChain($op, $node) {
      $c= $node->chained;
      while (NULL !== $c) {
        if ($c instanceof VariableNode) {
          oel_push_property($op, $c->name);
        } else if ($c instanceof ArrayAccessNode) {
          oel_push_value($op, $c->offset->value);
          oel_push_dim($op);
        } else if ($c instanceof InvocationNode) {   // DOES NOT WORK!
          $n= $this->emitAll($op, $c->parameters);
          oel_add_call_method($op, $n, $c->name);
          oel_add_begin_variable_parse($op);
        } else {
          $this->errors[]= 'Unknown chained element '.xp::stringOf($c);
        }
        $c= $c->chained;
      }
    }
    
    protected function emitIf($op, $if) {
      $this->emitOne($op, $if->condition);
      oel_add_begin_if($op); {
        $this->emitAll($op, $if->statements);
      } oel_add_end_if($op); {
        $this->emitAll($op, $if->otherwise->statements);
      }
      oel_add_end_else($op);
    }
    
    protected function emitClassMember($op, $ref) {
      if ($ref->member instanceof InvocationNode) {       // Static method call
        $n= $this->emitAll($op, $ref->member->parameters);
        oel_add_call_method_static($op, $n, $ref->member->name, $ref->class->name);
        oel_add_free($op);
      } else if ($ref->member instanceof VariableNode) {  // Static member
        oel_add_begin_variable_parse($op);
        oel_push_variable($op, ltrim($ref->member->name, '$'), $ref->class->name);   // without '$'
        $this->emitChain($op, $ref->member);
        oel_add_end_variable_parse($op);
      } else {
        $this->errors[]= 'Cannot emit class member '.xp::stringOf($ref->member);
      }
    }

    protected function emitInstanceCreation($op, $new) {
      $n= $this->emitAll($op, $new->parameters);
      oel_add_new_object($op, $n, $new->type->name);
      oel_add_begin_variable_parse($op);
      $this->emitChain($op, $new);
      oel_add_end_variable_parse($op);
    }
    
    protected function emitAssignment($op, $assign) {
      if (!$assign->variable instanceof VariableNode) {
        $this->errors[]= 'Cannot assign to '.xp::stringOf($assign);
        return;
      }

      $this->emitOne($op, $assign->expression);

      oel_add_begin_variable_parse($op);
      oel_push_variable($op, ltrim($assign->variable->name, '$'));    // without '$'
      $this->emitChain($op, $assign->variable);

      oel_add_assign($op);    // TODO: depending on $assign->op, use other assignments
      oel_add_free($op);
    }

      
    protected function emitClass($op, $declaration) {
      oel_add_begin_class_declaration($op, $declaration->name->name);
      
      // Methods
      foreach ($declaration->body['methods'] as $node) {
        $method= oel_new_method(
          $op, 
          $node->name, 
          FALSE,          // Returns reference
          Modifiers::isStatic($node->modifiers),
          $node->modifiers,
          Modifiers::isFinal($node->modifiers)
        );
        
        // Arguments
        foreach ($node->arguments as $i => $arg) {
          oel_add_receive_arg($method, $i + 1, substr($arg['name'], 1));  // without '$'
        }
        
        $this->emitAll($method, $node->body);
      }
      oel_add_end_class_declaration($op);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   resource op
     * @param   xp.compiler.ast.Node node
     * @return  int
     */
    protected function emitOne($op, $node) {
      $target= 'emit'.substr(get_class($node), 0, -strlen('Node'));
      if (method_exists($this, $target)) {
        oel_set_source_line($op, $node->position[0]);
        call_user_func_array(array($this, $target), array($op, $node));
        return 1;
      } else {
        $this->errors[]= 'Cannot emit '.xp::stringOf($node);
        return 0;
      }
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   resource op
     * @param   xp.compiler.ast.Node[] nodes
     * @return  int
     */
    protected function emitAll($op, $nodes) {
      $r= 0;
      foreach ((array)$nodes as $node) {
        $r+= $this->emitOne($op, $node);
      }
      return $r;
    }
    
    /**
     * Entry point
     *
     * @param   xp.compiler.ast.ParseTree tree
     * @return  string class name
     */
    public function emit(ParseTree $tree) {
      $this->errors= array();
      $this->op= oel_new_op_array();
      oel_set_source_file($this->op, $tree->origin);
      oel_set_source_line($this->op, 0);
      
      // Imports
      $n= 0;
      foreach ($tree->imports as $import) {
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
