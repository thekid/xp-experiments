PHP_FUNCTION(oel_add_begin_while) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    znode             *while_token;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    while_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_WHILE TSRMLS_CC);
    while_token->u.opline_num= get_next_op_number(res_op_array->oel_cg.active_op_array);
}

PHP_FUNCTION(oel_add_begin_while_body) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *token, *expr;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_WHILE)) oel_compile_error(E_ERROR, "token is not of type while");

    token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_WHILE_BODY TSRMLS_CC);
    expr=  oel_stack_pop_operand(res_op_array TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_while_cond(expr, token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_while) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *body_token, *while_token;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_WHILE_BODY)) oel_compile_error(E_ERROR, "token is not of type while body");

    body_token=  oel_stack_pop_token(res_op_array TSRMLS_CC);
    while_token= oel_stack_pop_token(res_op_array TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_while_end(while_token, body_token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_dowhile) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *token, *body_token;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_DOWHILE TSRMLS_CC);
    token->u.opline_num= get_next_op_number(res_op_array->oel_cg.active_op_array);
    body_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_DOWHILE_BODY TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_do_while_begin(TSRMLS_C);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_dowhile_body) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    znode             *body_token;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_DOWHILE_BODY)) oel_compile_error(E_ERROR, "token is not of type dowhile body");

    body_token= oel_stack_top_token(res_op_array TSRMLS_CC);
    body_token->u.opline_num= get_next_op_number(res_op_array->oel_cg.active_op_array);
}

PHP_FUNCTION(oel_add_end_dowhile) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *token, *body_token, *expr;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_DOWHILE_BODY)) oel_compile_error(E_ERROR, "token is not of type dowhile body");
    body_token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_DOWHILE)) oel_compile_error(E_ERROR, "token is not of type dowhile");
    token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_do_while_end(token, body_token, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_foreach) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *array, *foreach_token, *as_token, *open_brackets_token;
    int is_variable;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    array= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    is_variable= (array->op_type == IS_CV);
    if (is_variable) {
        if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_begin_foreach without oel_add_begin_variable_parse");
        oel_stack_pop_token(res_op_array TSRMLS_CC);
    }
    foreach_token=       oel_create_token(res_op_array, OEL_TYPE_TOKEN_FOREACH      TSRMLS_CC);
    as_token=            oel_create_token(res_op_array, OEL_TYPE_UNSET              TSRMLS_CC);
    open_brackets_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_FOREACH_HEAD TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_foreach_begin(foreach_token, open_brackets_token, array, as_token, is_variable TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_foreach_body) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *value, *key, *foreach_token, *as_token, *open_brackets_token, *tmp;
    zend_bool          arg_ref= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|b!", &arg_op_array, &arg_ref) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_begin_foreach_body without oel_add_begin_variable_parse (for value)");
    oel_stack_pop_token(res_op_array TSRMLS_CC);
    key= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    value= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    if (arg_ref) value->u.EA.type |= ZEND_PARSED_REFERENCE_VARIABLE;

    if (key->op_type != IS_CONST) {
        if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_begin_foreach_body without oel_add_begin_variable_parse (for key)");
        else oel_stack_pop_token(res_op_array TSRMLS_CC);
        tmp= key;
        key= value;
        value= tmp;
    } else {
        key->op_type= IS_UNUSED;
    }

    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_FOREACH_HEAD)) oel_compile_error(E_ERROR, "token is not of type foreach body");
    open_brackets_token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    as_token=            oel_stack_pop_token(res_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_FOREACH)) oel_compile_error(E_ERROR, "token is not of type foreach");
    foreach_token=       oel_stack_top_token(res_op_array TSRMLS_CC);
    oel_stack_push_token(res_op_array, as_token TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    if (key->op_type != IS_UNUSED) zend_check_writable_variable(key);
    zend_check_writable_variable(value);
    zend_do_foreach_cont(foreach_token, open_brackets_token, as_token, value, key TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_foreach) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *foreach_token, *as_token;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    as_token=            oel_stack_pop_token(res_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_FOREACH)) oel_compile_error(E_ERROR, "token is not of type foreach");
    foreach_token=       oel_stack_pop_token(res_op_array TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_foreach_end(foreach_token, as_token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}
