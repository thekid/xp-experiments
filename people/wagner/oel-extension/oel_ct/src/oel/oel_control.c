PHP_FUNCTION(oel_add_begin_if) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    oel_create_token(res_op_array, OEL_TYPE_TOKEN_ELSE TSRMLS_CC);
    znode *cond= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *if_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_IF TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_if_cond(cond, if_token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_if) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_IF)) oel_compile_error(E_ERROR, "token is not of type if");

    znode *if_token= oel_stack_pop_token(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_if_after_statement(if_token, 1 TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_elseif) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ELSE)) oel_compile_error(E_ERROR, "elseif can only be used inner an if block");

    znode *cond= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *if_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_ELSEIF TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_if_cond(cond, if_token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_elseif) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ELSEIF)) oel_compile_error(E_ERROR, "token is not of type elseif");

    znode *if_token= oel_stack_pop_token(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_if_after_statement(if_token, 0 TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_else) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ELSE)) oel_compile_error(E_ERROR, "token is not of type else");

    oel_stack_pop_token(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_if_end(TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_switch) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_SWITCH TSRMLS_CC);
    token->op_type= IS_UNUSED;

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_switch_cond(expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_switch) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_SWITCH)) oel_compile_error(E_ERROR, "token is not of type switch");

    znode *token= oel_stack_pop_token(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_switch_end(token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_case) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_SWITCH)) oel_compile_error(E_ERROR, "token is not of type switch");

    znode *switch_token= oel_stack_top_token(res_op_array TSRMLS_CC);
    znode *case_token=   oel_create_token(res_op_array, OEL_TYPE_TOKEN_SWITCH_CASE TSRMLS_CC);
    znode *expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_case_before_statement(switch_token, case_token, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_case) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_SWITCH_CASE)) oel_compile_error(E_ERROR, "token is not of type case");

    znode *case_token=   oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *switch_token= oel_stack_top_token(res_op_array TSRMLS_CC);
    switch_token->op_type= IS_CONST;

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_case_after_statement(switch_token, case_token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_default) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_SWITCH)) oel_compile_error(E_ERROR, "token is not of type switch");

    znode *switch_token= oel_stack_top_token(res_op_array TSRMLS_CC);
    znode *case_token=   oel_create_token(res_op_array, OEL_TYPE_TOKEN_SWITCH_DEFAULT TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_default_before_statement(switch_token, case_token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_default) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_SWITCH_DEFAULT)) oel_compile_error(E_ERROR, "token is not of type default");

    znode *case_token=   oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *switch_token= oel_stack_top_token(res_op_array TSRMLS_CC);
    switch_token->op_type= IS_CONST;

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_case_after_statement(switch_token, case_token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

