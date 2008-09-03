PHP_FUNCTION(oel_new_op_array) {
    php_oel_op_array *res_op_array= oel_create_new_op_array(TSRMLS_CC);
    ZEND_REGISTER_RESOURCE(return_value, res_op_array, le_oel_oar);
}

PHP_FUNCTION(oel_finalize) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }

    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    oel_finalize_op_array(res_op_array TSRMLS_CC);
}

PHP_FUNCTION(oel_execute) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    if (!res_op_array->final) {
        oel_compile_error(E_WARNING, "op array must be finalized before executing");
    } else {
        /* execute */
        zend_bool          orig_in_compilation=       CG(in_compilation);
        zend_execute_data *orig_current_execute_data= EG(current_execute_data);
        zend_op          **orig_opline_ptr=           EG(opline_ptr);
        zend_op_array     *orig_active_op_array=      EG(active_op_array);
        EG(active_op_array)= res_op_array->oel_cg.active_op_array;
        zend_first_try {
            zend_execute(res_op_array->oel_cg.active_op_array TSRMLS_CC);
            if ((EG(exception))) {
                zend_throw_exception_internal(EG(exception) TSRMLS_CC);
            } else {
                RETVAL_ZVAL(*EG(return_value_ptr_ptr), 1, 1);
            }
        } zend_catch {
            fprintf(stderr, "BAIL!\n"); /* FIXME */
        } zend_end_try();
        EG(active_op_array)=      orig_active_op_array;
        EG(opline_ptr)=           orig_opline_ptr;
        EG(current_execute_data)= orig_current_execute_data;
        CG(in_compilation)=       orig_in_compilation;
    }
}

PHP_FUNCTION(oel_add_echo) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *val= oel_stack_pop_operand(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_echo(val TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_return) {
    int  end_v_parse= 0;
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *val= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    if (val->u.EA.type & ZEND_PARSED_STATIC_MEMBER
     || val->u.EA.type & ZEND_PARSED_VARIABLE
     || val->u.EA.type & ZEND_PARSED_MEMBER) {
        if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "return variable without oel_add_begin_variable_parse");
        end_v_parse= 1;
        oel_stack_pop_token(res_op_array TSRMLS_CC);
    }

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_return(val, end_v_parse TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_free) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *var= oel_stack_pop_operand(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_free(var TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_break) {
    zval *arg_op_array;
    int   arg_depth= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|l!", &arg_op_array, &arg_depth) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *depth= NULL;
    if (arg_depth) {
        depth= oel_create_extvar(res_op_array TSRMLS_CC);
        ZVAL_LONG(&depth->u.constant, arg_depth);
    }

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_brk_cont(ZEND_BRK, depth TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_continue) {
    zval *arg_op_array;
    int   arg_depth= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|l!", &arg_op_array, &arg_depth) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *depth= NULL;
    if (arg_depth) {
        depth= oel_create_extvar(res_op_array TSRMLS_CC);
        ZVAL_LONG(&depth->u.constant, arg_depth);
    }

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_brk_cont(ZEND_CONT, depth TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_exit) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *result= oel_create_extvar(res_op_array TSRMLS_CC);
    znode *expr= NULL;
    if (oel_stack_size_operand(res_op_array TSRMLS_CC) > 0) {
        expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    } else {
        expr= oel_create_extvar(res_op_array TSRMLS_CC);
        memset(expr, 0, sizeof(znode));
        expr->op_type= IS_UNUSED;
    }

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_exit(result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_include) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_include_or_eval(ZEND_INCLUDE, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_include_once) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_include_or_eval(ZEND_INCLUDE_ONCE, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_require) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_include_or_eval(ZEND_REQUIRE, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_require_once) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_include_or_eval(ZEND_REQUIRE_ONCE, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_eval) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_include_or_eval(ZEND_EVAL, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_unset) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_unset without oel_add_begin_variable_parse");

    oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_end_variable_parse(BP_VAR_UNSET, 0 TSRMLS_CC);
    zend_do_unset(expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}
