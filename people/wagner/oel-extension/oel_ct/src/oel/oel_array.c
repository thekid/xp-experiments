PHP_FUNCTION(oel_add_begin_array_init) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    zend_bool  arg_is_ref= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|b", &arg_op_array, &arg_is_ref) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);

    znode *result= oel_create_token(res_op_array, OEL_TYPE_TOKEN_ARRAY_INIT TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_init_array(result, NULL, NULL, arg_is_ref TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_end_array_init) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);

    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ARRAY_INIT)) oel_compile_error(E_ERROR, "token is not of type array init");
    oel_stack_pop_function(res_op_array TSRMLS_CC);
}

PHP_FUNCTION(oel_add_array_init_element) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    zend_bool  arg_is_ref= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|b", &arg_op_array, &arg_is_ref) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ARRAY_INIT)) oel_compile_error(E_ERROR, "token is not of type array init");

    znode *value= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *array= oel_stack_top_function(res_op_array TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_add_array_element(array, value, NULL, arg_is_ref TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_array_init_key_element) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    zend_bool  arg_is_ref= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|b", &arg_op_array, &arg_is_ref) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ARRAY_INIT)) oel_compile_error(E_ERROR, "token is not of type array init");

    znode *value= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *key=   oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *array= oel_stack_top_function(res_op_array TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_add_array_element(array, value, key, arg_is_ref TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_push_dim) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_push_dim without oel_add_begin_variable_parse");

    znode *key=    oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *parent= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    fetch_array_dim(result, parent, key TSRMLS_DC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_push_new_dim) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_push_new_dim without oel_add_begin_variable_parse");

    znode *key= oel_create_extvar(res_op_array TSRMLS_CC);
    SET_UNUSED(*key);
    znode *parent= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    fetch_array_dim(result, parent, key TSRMLS_DC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_begin_staticarray_init) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    zend_bool  arg_is_ref= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|b", &arg_op_array, &arg_is_ref) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);

    znode *result= oel_create_token(res_op_array, OEL_TYPE_TOKEN_ARRAY_STATIC TSRMLS_CC);

    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    result->op_type = IS_CONST;
    INIT_PZVAL(&result->u.constant);
    array_init(&result->u.constant);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_end_staticarray_init) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);

    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ARRAY_STATIC)) oel_compile_error(E_ERROR, "token is not of type array static");
    znode *result= oel_stack_pop_function(res_op_array TSRMLS_CC);
    result->u.constant.type= IS_CONSTANT_ARRAY;
}

PHP_FUNCTION(oel_add_staticarray_init_element) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    zend_bool  arg_is_ref= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|b", &arg_op_array, &arg_is_ref) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ARRAY_STATIC)) oel_compile_error(E_ERROR, "token is not of type array static");

    znode *value= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *array= oel_stack_top_function(res_op_array TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_add_static_array_element(array, NULL, value);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_staticarray_init_key_element) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    zend_bool  arg_is_ref= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|b", &arg_op_array, &arg_is_ref) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ARRAY_STATIC)) oel_compile_error(E_ERROR, "token is not of type array static");

    znode *value= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *key=   oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *array= oel_stack_top_function(res_op_array TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_add_static_array_element(array, key, value);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_begin_list) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    oel_create_token(res_op_array, OEL_TYPE_TOKEN_LIST TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_list_init(TSRMLS_C);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_end_list) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_LIST)) oel_compile_error(E_ERROR, "token is not of type list");
    oel_stack_pop_function(res_op_array TSRMLS_CC);

    znode *expr=   oel_stack_top_operand(res_op_array TSRMLS_CC);
    znode *result= oel_create_extvar(res_op_array TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_list_end(result, expr TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_begin_inner_list) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    oel_create_token(res_op_array, OEL_TYPE_TOKEN_LIST_INNER TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_new_list_begin(TSRMLS_C);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_end_inner_list) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_LIST_INNER)) oel_compile_error(E_ERROR, "token is not of type inner list");
    oel_stack_pop_function(res_op_array TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_new_list_end(TSRMLS_C);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}

PHP_FUNCTION(oel_add_list_element) {
    php_oel_op_array *res_op_array;

    /* handle parameters */
    zval      *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    PHP_OEL_FETCH_OP_ARRAY(res_op_array, arg_op_array);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_list_element without oel_add_begin_variable_parse");
    oel_stack_pop_function(res_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 2, OEL_TYPE_TOKEN_LIST, OEL_TYPE_TOKEN_LIST_INNER)) oel_compile_error(E_ERROR, "token is not of type list or inner list");

    znode *expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);

    PHP_OEL_PREPARE_ADD(res_op_array);
    zend_do_add_list_element(expr TSRMLS_CC);
    PHP_OEL_PREPARE_ADD_END(res_op_array);
}
