<?php
  require('lang.base.php');
  
  function opString($op) {
    if (NULL === $op) return 'null';
    switch ($op['type_name']) {
      case 'IS_CV': return 'CV<#'.$op['var'].' $'.$op['varname'].'>';
      case 'IS_CONST': if (NULL === $op['constant']) {
        return 'C<null>';
      } else if (is_string($op['constant'])) {
        return 'C<string:"'.addcslashes(str_replace('"', '\"', $op['constant']), "\0..\17").'">';
      } else {
        return 'C<'.gettype($op['constant']).':'.xp::stringOf($op['constant']).'>';
      }
      case 'IS_UNUSED': return 'unused';
      case 'IS_VAR': return 'V<#'.$op['var'].'>';
      case 'IS_TMP_VAR': return 'T<#'.$op['var'].'>';
      default: xp::error('Unknown '.xp::stringOf($op));
    }
  }
  
  function cdString($cd) {
    switch ($cd['opcode_name']) {
      case 'ZEND_RECV': 
        return 'recv                 '.opString($cd['result']).' := '.opString($cd['op1']);
      case 'ZEND_RECV_INIT': 
        return 'recv_init            '.opString($cd['result']).' := '.opString($cd['op1']).' || '.opString($cd['op2']);
      case 'ZEND_FETCH_CONSTANT': 
        return 'fetch_const          '.opString($cd['result']).' := '.opString($cd['op2']);
      case 'ZEND_FETCH_OBJ_FUNC_ARG': 
        return 'fetch_obj_func_arg   '.opString($cd['result']).' := ::'.opString($cd['op2']);
      case 'ZEND_FETCH_FUNC_ARG': 
        return 'fetch_func_arg       '.opString($cd['result']).' := '.opString($cd['op1']);
      case 'ZEND_FETCH_CLASS': 
        return 'fetch_class          '.opString($cd['result']).' := '.($cd['op2']['constant'] ? opString($cd['op2']) : 'self');
      case 'ZEND_FETCH_R': 
        return 'fetch_r              '.opString($cd['result']).' := '.opString($cd['op1']);
      case 'ZEND_FETCH_OBJ_R': 
        return 'fetch_obj_r          '.opString($cd['result']).' := ::'.opString($cd['op2']);
      case 'ZEND_FETCH_OBJ_W': 
        return 'fetch_obj_w          '.opString($cd['result']).' := ::'.opString($cd['op2']);
      case 'ZEND_FETCH_DIM_R': 
        return 'fetch_dim_r          '.opString($cd['result']).' := '.opString($cd['op1']).'['.opString($cd['op2']).']';
      case 'ZEND_FETCH_DIM_W': 
        return 'fetch_dim_r          '.opString($cd['result']).' := '.opString($cd['op1']).'['.opString($cd['op2']).']';
      case 'ZEND_ASSIGN': 
        return 'assign               '.opString($cd['op1']).' := '.opString($cd['op2']).' (*'.opString($cd['result']).')';
      case 'ZEND_ASSIGN_DIM': 
        return 'assign_dim           '.opString($cd['op1']).'['.opString($cd['op2']).'] (*'.opString($cd['result']).')';
      case 'ZEND_ISSET_ISEMPTY_DIM_OBJ': 
        return 'isset_dim            '.opString($cd['result']).' := isset '.opString($cd['op1']).'['.opString($cd['op2']).']';
      case 'ZEND_ASSIGN_OBJ': 
        return 'assign_obj           '.opString($cd['result']).' := V<#'.$cd['op1']['var'].'>::'.opString($cd['op2']);
      case 'ZEND_QM_ASSIGN': 
        return 'qm_assign            '.opString($cd['result']).' := '.opString($cd['op1']);
      case 'ZEND_DO_FCALL': 
        return 'invoke               '.opString($cd['result']).' := '.opString($cd['op1']);
      case 'ZEND_DO_FCALL_BY_NAME': 
        return 'invokename           -> '.opString($cd['result']);
      case 'ZEND_SEND_VAR_NO_REF': 
        return 'send_var_no_ref      '.opString($cd['op1']);
      case 'ZEND_SEND_REF': 
        return 'send_ref             '.opString($cd['op1']);
      case 'ZEND_SEND_VAR': 
        return 'send_var             '.opString($cd['op1']);
      case 'ZEND_SEND_VAL': 
        return 'send_val             '.opString($cd['op1']);
      case 'ZEND_CONCAT': 
        return 'concat               '.opString($cd['result']).' := '.opString($cd['op1']).' . '.opString($cd['op2']);
      case 'ZEND_SUB': 
        return 'sub                  '.opString($cd['result']).' := '.opString($cd['op1']).' - '.opString($cd['op2']);
      case 'ZEND_ADD': 
        return 'add                  '.opString($cd['result']).' := '.opString($cd['op1']).' + '.opString($cd['op2']);
      case 'ZEND_MUL': 
        return 'mul                  '.opString($cd['result']).' := '.opString($cd['op1']).' * '.opString($cd['op2']);
      case 'ZEND_DIV': 
        return 'div                  '.opString($cd['result']).' := '.opString($cd['op1']).' / '.opString($cd['op2']);
      case 'ZEND_MOD': 
        return 'mod                  '.opString($cd['result']).' := '.opString($cd['op1']).' % '.opString($cd['op2']);
      case 'ZEND_BOOL_NOT': 
        return 'not                  '.opString($cd['result']).' := !'.opString($cd['op1']);
      case 'ZEND_IS_IDENTICAL': 
        return 'is_identical         '.opString($cd['result']).' := '.opString($cd['op1']).' === '.opString($cd['op2']);
      case 'ZEND_IS_NOT_IDENTICAL': 
        return 'is_not_identical     '.opString($cd['result']).' := '.opString($cd['op1']).' !== '.opString($cd['op2']);
      case 'ZEND_IS_EQUAL': 
        return 'is_equal             '.opString($cd['result']).' := '.opString($cd['op1']).' == '.opString($cd['op2']);
      case 'ZEND_IS_NOT_EQUAL': 
        return 'is_not_equal         '.opString($cd['result']).' := '.opString($cd['op1']).' != '.opString($cd['op2']);
      case 'ZEND_IS_SMALLER': 
        return 'is_smaller           '.opString($cd['result']).' := '.opString($cd['op1']).' < '.opString($cd['op2']);
      case 'ZEND_IS_SMALLER_OR_EQUAL': 
        return 'is_smaller_or_equal  '.opString($cd['result']).' := '.opString($cd['op1']).' <= '.opString($cd['op2']);
      case 'ZEND_IS_SMALLER': 
        return 'is_smaller           '.opString($cd['result']).' := '.opString($cd['op1']).' < '.opString($cd['op2']);
      case 'ZEND_IS_SMALLER_OR_EQUAL': 
        return 'is_smaller_or_equal  '.opString($cd['result']).' := '.opString($cd['op1']).' <= '.opString($cd['op2']);
      case 'ZEND_INIT_METHOD_CALL': 
        return 'init_call            '.opString($cd['op2']);
      case 'ZEND_INIT_STATIC_METHOD_CALL': 
        return 'init_static_call     '.opString($cd['op1']).'::'.opString($cd['op2']);
      case 'ZEND_INIT_ARRAY': 
        return 'init_array           '.opString($cd['result']);
      case 'ZEND_JMPNZ_EX':
        return 'jmpnz_ex             '.opString($cd['op1']).' ? @'.$cd['op2']['jmp_addr'];
      case 'ZEND_JMPZ_EX':
        return 'jmpz_ex              '.opString($cd['op1']).' ? @'.$cd['op2']['jmp_addr'];
      case 'ZEND_JMPZ':
        return 'jmpz                 '.opString($cd['op1']).' ? @'.$cd['op2']['jmp_addr'];
      case 'ZEND_JMPZNZ':
        return 'jmpznz               '.opString($cd['op1']).' ? @'.$cd['op2']['jmp_addr'];
      case 'ZEND_JMP':
        return 'jmp                  @'.$cd['op1']['jmp_addr'];
      case 'ZEND_POST_INC': 
        return 'post_inc             '.opString($cd['op1']).'++';
      case 'ZEND_POST_DEC': 
        return 'post_dec             '.opString($cd['op1']).'--';
      case 'ZEND_RETURN': 
        return 'return               '.opString($cd['op1']);
      case 'ZEND_THROW': 
        return 'throw                '.opString($cd['op1']);
       case 'ZEND_CATCH': 
        return 'catch                '.opString($cd['op1']).' '.opString($cd['op2']);
     case 'ZEND_CONT': 
        return 'continue             '.opString($cd['op2']);
     case 'ZEND_FREE': 
        return 'free                 '.opString($cd['op1']);
      case 'ZEND_NEW': 
        return 'new                  '.opString($cd['result']).' := '.opString($cd['op1']);
      case 'ZEND_HANDLE_EXCEPTION': 
        return 'handle_exception';
      default: return sprintf(
        '%-20s (%s, %s) -> %s', 
        strtolower(substr($cd['opcode_name'], 5)),
        opString($cd['op1']),
        opString($cd['op2']),
        opString($cd['result'])
      );
    }
  }

  $info= parsekit_compile_file($argv[1], $errors);
  if ($errors) xp::error(xp::stringOf($errors));
      
  // Dump class_table
  foreach ($info['class_table'] as $ce) {
  
    // zend_class_entry
    printf(
      "%s(%d) %s [ %s%s ] F{%d} @ %s<%d-%d> {\n",
      $ce['type_name'],
      $ce['type'],
      $ce['name'],
      $ce['parent'] ? ':'.$ce['parent'] : '<null>',
      $ce['interfaces'] ? ' *'.implode(' & *', $ce['interfaces']) : '',
      $ce['ce_flags'],
      basename($ce['filename']),
      $ce['line_start'],
      $ce['line_end']
    );

    // properties_info
    printf("  Properties (%d) {\n", sizeof($ce['properties_info']));
    foreach ($ce['properties_info'] as $pi) {
      printf("    %d \$%s\n", $pi['flags'], addcslashes($pi['name'], "\0"));
    }
    printf("  }\n");

    // method handlers
    printf("  Handlers {\n");
    isset($ce['constructor']) && printf("    NEW   -> %s\n", $ce['constructor']);
    isset($ce['clone']) && printf("    CLONE -> %s\n", $ce['clone']);
    isset($ce['__get']) && printf("    READ  -> %s\n", $ce['__get']);
    isset($ce['__set']) && printf("    WRITE -> %s\n", $ce['__set']);
    isset($ce['__call']) && printf("    INV   -> %s\n", $ce['__call']);
    printf("  }\n");
    
    // function_table
    printf("  Methods (%d) {\n", sizeof($ce['function_table']));
    foreach ($ce['function_table'] as $fe) {
      printf(
        "    %s(%d) %s::%s(#%d) F{%d}%s @ %s<%d-%d>\n", 
        $fe['type_name'],
        $fe['type'],
        $fe['scope'],
        $fe['function_name'],
        $fe['num_args'], 
        $fe['fn_flags'],
        $fe['uses_this'] ? ' &this' : '',
        basename($fe['filename']),
        $fe['line_start'],
        $fe['line_end']
      );
    }
    printf("  }\n");

    printf("}\n");
    
    // Dump opcodes
    foreach ($ce['function_table'] as $fe) {
      printf("@%s [\n", $fe['function_name']);
      foreach ($fe['opcodes'] as $i => $opcode) {
        printf("  %3d@%4d: %s\n", 
          $i, 
          $opcode['lineno'],
          cdString($opcode)
        );
      }
      printf("]\n\n");
    }
  }
?>
