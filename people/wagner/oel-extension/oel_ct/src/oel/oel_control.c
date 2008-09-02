PHP_FUNCTION(oel_add_begin_if) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);

    oel_create_token(res_op_array, OEL_TYPE_TOKEN_ELSE TSRMLS_CC);

    znode *cond= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *if_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_IF TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_if_cond(cond, if_token TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_end_if) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_IF)) oel_compile_error(E_ERROR, "token is not of type if");
    znode *if_token= oel_stack_pop_function(res_op_array TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_if_after_statement(if_token, 1 TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_begin_elseif) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ELSE)) oel_compile_error(E_ERROR, "elseif can only be used inner an if block");

    znode *cond= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *if_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_ELSEIF TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_if_cond(cond, if_token TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_end_elseif) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ELSEIF)) oel_compile_error(E_ERROR, "token is not of type elseif");

    znode *if_token= oel_stack_pop_function(res_op_array TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_if_after_statement(if_token, 0 TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_end_else) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ELSE)) oel_compile_error(E_ERROR, "token is not of type else");

    oel_stack_pop_function(res_op_array TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_if_end(TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_begin_switch) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);

    znode *expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_SWITCH TSRMLS_CC);
    token->op_type = IS_UNUSED;

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_switch_cond(expr TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_end_switch) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_SWITCH)) oel_compile_error(E_ERROR, "token is not of type switch");

    znode *token= oel_stack_pop_function(res_op_array TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_switch_end(token TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_begin_case) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_SWITCH)) oel_compile_error(E_ERROR, "token is not of type switch");

    znode *switch_token= oel_stack_top_function(res_op_array TSRMLS_CC);
    znode *case_token=   oel_create_token(res_op_array, OEL_TYPE_TOKEN_SWITCH_CASE TSRMLS_CC);
    znode *expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_case_before_statement(switch_token, case_token, expr TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_end_case) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_SWITCH_CASE)) oel_compile_error(E_ERROR, "token is not of type case");

    znode *case_token=   oel_stack_pop_function(res_op_array TSRMLS_CC);
    znode *switch_token= oel_stack_top_function(res_op_array TSRMLS_CC);
    switch_token->op_type= IS_CONST;

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_case_after_statement(switch_token, case_token TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_begin_default) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_SWITCH)) oel_compile_error(E_ERROR, "token is not of type switch");

    znode *switch_token= oel_stack_top_function(res_op_array TSRMLS_CC);
    znode *case_token=   oel_create_token(res_op_array, OEL_TYPE_TOKEN_SWITCH_DEFAULT TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_default_before_statement(switch_token, case_token TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_end_default) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_SWITCH_DEFAULT)) oel_compile_error(E_ERROR, "token is not of type default");

    znode *case_token=   oel_stack_pop_function(res_op_array TSRMLS_CC);
    znode *switch_token= oel_stack_top_function(res_op_array TSRMLS_CC);
    switch_token->op_type= IS_CONST;

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_case_after_statement(switch_token, case_token TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

