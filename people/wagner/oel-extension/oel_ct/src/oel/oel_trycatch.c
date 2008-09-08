PHP_FUNCTION(oel_add_begin_tryblock) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *try_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_TRY TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_try(try_token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_catchblock) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_TRY)) oel_compile_error(E_ERROR, "token is not of type try");

    znode *try_token= oel_stack_top_token(res_op_array TSRMLS_CC);
    oel_create_token(res_op_array, OEL_TYPE_TOKEN_CATCH TSRMLS_CC);
    oel_create_token(res_op_array, OEL_TYPE_TOKEN_CATCH_FIRST TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_initialize_try_catch_element(try_token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_firstcatch) {
    zval *arg_op_array;
    char *arg_class_name;
    int   arg_class_name_len;
    char *arg_var_name;
    int   arg_var_name_len;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rss", &arg_op_array, &arg_class_name, &arg_class_name_len, &arg_var_name, &arg_var_name_len) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_CATCH_FIRST)) oel_compile_error(E_ERROR, "token is not of type first catch");

    znode *first_catch_token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *catch_token=       oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *try_token=         oel_stack_top_token(res_op_array TSRMLS_CC);
    oel_stack_push_token(res_op_array, catch_token TSRMLS_CC);
    oel_stack_top_set_type_token(res_op_array, OEL_TYPE_TOKEN_CATCH TSRMLS_CC);
    oel_stack_push_token(res_op_array, first_catch_token TSRMLS_CC);
    oel_stack_top_set_type_token(res_op_array, OEL_TYPE_TOKEN_CATCH_FIRST TSRMLS_CC);
    znode *catch_var=   oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&catch_var->u.constant, arg_var_name, arg_var_name_len, 1);
    znode *catch_class= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&catch_class->u.constant, arg_class_name, arg_class_name_len, 1);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    catch_token->u.opline_num= get_next_op_number(res_op_array->oel_cg.active_op_array);
    zend_do_fetch_class(catch_class, catch_class TSRMLS_CC);
    zend_do_begin_catch(try_token, catch_class, catch_var, 1 TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_firstcatch) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_CATCH_FIRST)) oel_compile_error(E_ERROR, "token is not of type first catch");

    znode *first_catch_token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *catch_token=       oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *try_token=         oel_stack_top_token(res_op_array TSRMLS_CC);
    oel_stack_push_token(res_op_array, catch_token TSRMLS_CC);
    oel_stack_top_set_type_token(res_op_array, OEL_TYPE_TOKEN_CATCH TSRMLS_CC);
    znode *last_catch_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_CATCH_LAST TSRMLS_CC);
    oel_create_token(res_op_array, OEL_TYPE_TOKEN_CATCH_ADD TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    last_catch_token->u.opline_num= -1;
    zend_do_end_catch(try_token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_catch) {
    zval *arg_op_array;
    char *arg_class_name;
    int   arg_class_name_len;
    char *arg_var_name;
    int   arg_var_name_len;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rss", &arg_op_array, &arg_class_name, &arg_class_name_len, &arg_var_name, &arg_var_name_len) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_CATCH_FIRST)) oel_compile_error(E_ERROR, "first catch must be declared with oel_add_begin_firstcatch");
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_CATCH_ADD)) oel_compile_error(E_ERROR, "token is not of type additional catch");

    znode *add_catch_token=  oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *last_catch_token= oel_stack_top_token(res_op_array TSRMLS_CC);
    oel_stack_push_token(res_op_array, add_catch_token TSRMLS_CC);
    oel_stack_top_set_type_token(res_op_array, OEL_TYPE_TOKEN_CATCH_ADD TSRMLS_CC);
    znode *catch_var=   oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&catch_var->u.constant, arg_var_name, arg_var_name_len, 1);
    znode *catch_class= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&catch_class->u.constant, arg_class_name, arg_class_name_len, 1);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    last_catch_token->u.opline_num= get_next_op_number(CG(active_op_array));
    zend_do_fetch_class(catch_class, catch_class TSRMLS_CC);
    zend_do_begin_catch(add_catch_token, catch_class, catch_var, 0 TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_catch) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_CATCH_ADD)) oel_compile_error(E_ERROR, "token is not of type additional catch");

    znode *add_catch_token=  oel_stack_pop_token(res_op_array TSRMLS_CC);
    oel_create_token(res_op_array, OEL_TYPE_TOKEN_CATCH_ADD TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_end_catch(add_catch_token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_catchblock) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_CATCH_FIRST)) oel_compile_error(E_ERROR, "catchblock must contain at least one catch");
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_CATCH_ADD)) oel_compile_error(E_ERROR, "token is not of type catch");

    znode *add_catch_token=  oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *last_catch_token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *catch_token=      oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *try_token=        oel_stack_pop_token(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_mark_last_catch(catch_token, last_catch_token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_throw) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *expr= oel_stack_pop_operand(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_throw(expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}