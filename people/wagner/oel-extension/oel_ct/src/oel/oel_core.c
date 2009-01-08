PHP_FUNCTION(oel_new_op_array) {
    php_oel_op_array *res_op_array;
    res_op_array= oel_create_new_op_array(TSRMLS_C);
    ZEND_REGISTER_RESOURCE(return_value, res_op_array, le_oel_oar);
}

PHP_FUNCTION(oel_finalize) {
    zval             *arg_op_array;
    php_oel_op_array *res_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }

    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    oel_finalize_op_array(res_op_array TSRMLS_CC);
}

PHP_FUNCTION(oel_execute) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    zend_bool          orig_in_compilation, orig_in_execution;
    int               error;
    zend_execute_data *orig_current_execute_data;
    zend_op          **orig_opline_ptr;
    zend_op_array     *orig_active_op_array;

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    if (!res_op_array->final) {
        oel_compile_error(E_WARNING, "op array must be finalized before executing");
    } else {
        if (!res_op_array->merged) {
            zend_hash_merge(EG(function_table), res_op_array->oel_cg.function_table, NULL, NULL, sizeof(zend_function),    0);
            zend_hash_merge(EG(class_table),    res_op_array->oel_cg.class_table,    NULL, NULL, sizeof(zend_class_entry), 0);
            res_op_array->merged= 1;
        }

        /* execute */
        error= -1;
        orig_in_compilation=       CG(in_compilation);
        orig_in_execution=         EG(in_execution);
        orig_current_execute_data= EG(current_execute_data);
        orig_opline_ptr=           EG(opline_ptr);
        orig_active_op_array=      EG(active_op_array);
        EG(active_op_array)= res_op_array->oel_cg.active_op_array;
        zend_try {
            zend_execute(res_op_array->oel_cg.active_op_array TSRMLS_CC);
            if ((EG(exception))) {
                zend_throw_exception_internal(EG(exception) TSRMLS_CC);
            } else {
                RETVAL_ZVAL(*EG(return_value_ptr_ptr), 1, 1);
            }
        } zend_catch {
            error= EG(exit_status);
        } zend_end_try();
        EG(active_op_array)=      orig_active_op_array;
        EG(opline_ptr)=           orig_opline_ptr;
        EG(current_execute_data)= orig_current_execute_data;
        EG(in_execution)=         orig_in_execution;
        CG(in_compilation)=       orig_in_compilation;
        
        switch (error) {
            case -1: 
                /* Success */ 
                break;

            case 0xFF: 
                zend_error(E_WARNING, "Op array execution was ended by fatal error");
                break;

            default:
                zend_error(E_WARNING, "Op array execution was ended by a call to exit");
                break;
        }
    }
}

PHP_FUNCTION(oel_add_echo) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *val;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    val= oel_stack_pop_operand(res_op_array TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_echo(val TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_return) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *val;
    int  end_v_parse=  0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    val= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    if ((val->op_type & (IS_VAR | IS_CV)) && (val->u.EA.type & (ZEND_PARSED_STATIC_MEMBER | ZEND_PARSED_VARIABLE | ZEND_PARSED_MEMBER))) {
        if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "return variable without oel_add_begin_variable_parse");
        end_v_parse= 1;
        oel_stack_pop_token(res_op_array TSRMLS_CC);
    }

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_return(val, end_v_parse TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_free) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *var;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    var= oel_stack_pop_operand(res_op_array TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_free(var TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_break) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    int                arg_depth= 0;
    znode             *depth= NULL;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|l!", &arg_op_array, &arg_depth) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    if (arg_depth) {
        depth= oel_create_extvar(res_op_array TSRMLS_CC);
        ZVAL_LONG(&depth->u.constant, arg_depth);
    }

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_brk_cont(ZEND_BRK, depth TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_continue) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    int                arg_depth= 0;
    znode             *depth= NULL;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|l!", &arg_op_array, &arg_depth) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    if (arg_depth) {
        depth= oel_create_extvar(res_op_array TSRMLS_CC);
        ZVAL_LONG(&depth->u.constant, arg_depth);
    }

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_brk_cont(ZEND_CONT, depth TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_exit) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *expr= NULL, *result;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    result= oel_create_extvar(res_op_array TSRMLS_CC);
    expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_exit(result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_include) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *expr, *result;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_include_or_eval(ZEND_INCLUDE, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_include_once) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *expr, *result;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_include_or_eval(ZEND_INCLUDE_ONCE, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_require) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *expr, *result;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_include_or_eval(ZEND_REQUIRE, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_require_once) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *expr, *result;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_include_or_eval(ZEND_REQUIRE_ONCE, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_eval) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *expr, *result;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_include_or_eval(ZEND_EVAL, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_unset) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *expr;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_unset without oel_add_begin_variable_parse");

    oel_stack_pop_token(res_op_array TSRMLS_CC);
    expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_end_variable_parse(BP_VAR_UNSET, 0 TSRMLS_CC);
    zend_do_unset(expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}
