<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.compiler.emit.oel';

  uses('xp.compiler.emit.Emitter');

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

    protected function emitChain($op, $node) {
      $c= $node->chained;
      while ($c) {
        if ($c instanceof VariableNode) {
          oel_push_property($op, $c->name);
        } else if ($c instanceof ArrayAccessNode) {
          oel_push_value($op, $c->offset->value);
          oel_push_dim($op);
        } else if (0 && $c instanceof InvocationNode) {   // DOES NOT WORK!
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
    
    protected function emitOne($op, $node) {
      $target= 'emit'.substr(get_class($node), 0, -strlen('Node'));
      if (method_exists($this, $target)) {
        call_user_func_array(array($this, $target), array($op, $node));
        return 1;
      } else {
        $this->errors[]= 'Cannot emit '.xp::stringOf($node);
        return 0;
      }
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
    
    protected function emitAll($op, $nodes) {
      $r= 0;
      foreach ($nodes as $node) {
        $r+= $this->emitOne($op, $node);
      }
      return $r;
    }
    
    /**
     * Entry point
     *
     * @param   
     * @return  
     */
    public function emit(ParseTree $tree) {
      $this->errors= array();
      $this->op= oel_new_op_array();
      // oel_set_source_file($op_a, "Testfile.wll");
      // oel_set_source_line($op_a, 5);
      
      foreach ($tree->imports as $import) {
        oel_push_value($this->op, $import->name);
        oel_add_call_function($this->op, 1, 'uses');
        oel_add_free($this->op);
      }
      
      // TODO: Switch on type (interface, class, ...)
      oel_add_begin_class_declaration($this->op, $tree->declaration->name->name);
      
      // Methods
      foreach ($tree->declaration->body['methods'] as $node) {
        $method= oel_new_method($this->op, $node->name, FALSE, TRUE);   // FIXME: Modifiers?
        
        // Arguments
        foreach ($node->arguments as $i => $arg) {
          oel_add_receive_arg($method, $i + 1, substr($arg['name'], 1));  // without '$'
        }
        
        $this->emitAll($method, $node->body);
      }
      oel_add_end_class_declaration($this->op);
      oel_finalize($this->op);

      if ($this->errors) {
        throw new FormatException(xp::stringOf($this->errors));
      }

      oel_execute($this->op);
      return $tree->declaration->name->name;
    }    
  }
?>
