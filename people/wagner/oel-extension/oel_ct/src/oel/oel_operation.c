inline static int is_unary_op(int op) {
    return (
        op == ZEND_BOOL_NOT ||
        op == ZEND_BW_NOT
    );
}

inline static int is_binary_assign_op(int op) {
    return (
        op == ZEND_ASSIGN_ADD    ||
        op == ZEND_ASSIGN_SUB    ||
        op == ZEND_ASSIGN_MUL    ||
        op == ZEND_ASSIGN_DIV    ||
        op == ZEND_ASSIGN_CONCAT ||
        op == ZEND_ASSIGN_MOD    ||
        op == ZEND_ASSIGN_BW_AND ||
        op == ZEND_ASSIGN_BW_OR  ||
        op == ZEND_ASSIGN_BW_XOR ||
        op == ZEND_ASSIGN_SL     ||
        op == ZEND_ASSIGN_SR
    );
}

inline static int is_binary_op(int op) {
    return (
        op == ZEND_ASSIGN_ADD          ||
        op == ZEND_ASSIGN_SUB          ||
        op == ZEND_ASSIGN_MUL          ||
        op == ZEND_ASSIGN_DIV          ||
        op == ZEND_ASSIGN_CONCAT       ||
        op == ZEND_ASSIGN_MOD          ||
        op == ZEND_ASSIGN_BW_AND       ||
        op == ZEND_ASSIGN_BW_OR        ||
        op == ZEND_ASSIGN_BW_XOR       ||
        op == ZEND_ASSIGN_SL           ||
        op == ZEND_ASSIGN_SR           ||
        op == ZEND_BW_OR               ||
        op == ZEND_BW_AND              ||
        op == ZEND_BW_XOR              ||
        op == ZEND_CONCAT              ||
        op == ZEND_ADD                 ||
        op == ZEND_SUB                 ||
        op == ZEND_MUL                 ||
        op == ZEND_DIV                 ||
        op == ZEND_MOD                 ||
        op == ZEND_SL                  ||
        op == ZEND_SR                  ||
        op == ZEND_IS_IDENTICAL        ||
        op == ZEND_IS_NOT_IDENTICAL    ||
        op == ZEND_IS_EQUAL            ||
        op == ZEND_IS_NOT_EQUAL        ||
        op == ZEND_IS_SMALLER          ||
        op == ZEND_IS_SMALLER_OR_EQUAL ||
        op == ZEND_BOOL_XOR
    );
}

inline static int is_incdec_post_op(int op) {
    return (
        op == ZEND_POST_INC ||
        op == ZEND_POST_DEC
    );
}

inline static int is_incdec_op(int op) {
    return (
        op == ZEND_POST_INC ||
        op == ZEND_POST_DEC ||
        op == ZEND_PRE_INC  ||
        op == ZEND_PRE_DEC
    );
}

inline static int is_boolean_and_op(int op) {
    return (op == ZEND_JMPZ_EX);
}

inline static int is_boolean_op(int op) {
    return (
        op == ZEND_JMPZ_EX ||
        op == ZEND_JMPNZ_EX
    );
}

inline static int is_cast_op(int op) {
    return (
        op == IS_LONG   ||
        op == IS_DOUBLE ||
        op == IS_STRING ||
        op == IS_ARRAY  ||
        op == IS_OBJECT ||
        op == IS_BOOL   ||
        op == IS_NULL
    );
}

PHP_FUNCTION(oel_add_unary_op) {
    zval *arg_op_array;
    int  arg_operation;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rl", &arg_op_array, &arg_operation) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!is_unary_op(arg_operation)) oel_compile_error(E_ERROR, "operation is not a unary operation");

    znode *operand= oel_stack_top_operand(res_op_array TSRMLS_CC);
    znode *result= operand;

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_unary_op(arg_operation, result, operand TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_incdec_op) {
    zval *arg_op_array;
    int  arg_operation;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rl", &arg_op_array, &arg_operation) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "assigning op without oel_add_begin_variable_parse");
    if (!is_incdec_op(arg_operation)) oel_compile_error(E_ERROR, "operation is not an incdec operation");

    oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *operand= oel_stack_top_operand(res_op_array TSRMLS_CC);
    znode *result= operand;

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_check_writable_variable(operand);
    zend_do_end_variable_parse(BP_VAR_RW, 0 TSRMLS_CC);
    if (is_incdec_post_op(arg_operation)) zend_do_post_incdec(result, operand, arg_operation TSRMLS_CC);
    else zend_do_pre_incdec(result, operand, arg_operation TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_binary_op) {
    zval *arg_op_array;
    int  arg_operation;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rl", &arg_op_array, &arg_operation) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!is_binary_op(arg_operation)) oel_compile_error(E_ERROR, "operation is not a binary operation");

    znode *lefthand=  oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *righthand= oel_stack_top_operand(res_op_array TSRMLS_CC);
    znode *result= righthand;

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    if (is_binary_assign_op(arg_operation)) {
        if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "assigning binary op without oel_add_begin_variable_parse");
        oel_stack_pop_token(res_op_array TSRMLS_CC);
        zend_check_writable_variable(lefthand);
        zend_do_end_variable_parse(BP_VAR_RW, 0 TSRMLS_CC);
        zend_do_binary_assign_op(arg_operation, result, lefthand, righthand TSRMLS_CC);
    } else {
        zend_do_binary_op(arg_operation, result, lefthand, righthand TSRMLS_CC);
    }
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_tinary_op) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *cond=  oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_TINARY1 TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_begin_qm_op(cond, token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_tinary_op_true) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_TINARY1)) oel_compile_error(E_ERROR, "token is not of type trinary 1");

    znode *truepart= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *token1=   oel_stack_top_token(res_op_array TSRMLS_CC);
    znode *token2=   oel_create_token(res_op_array, OEL_TYPE_TOKEN_TINARY2 TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_qm_true(truepart, token1, token2 TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_tinary_op_false) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_TINARY2)) oel_compile_error(E_ERROR, "token is not of type trinary 2");

    znode *failpart= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *token2=   oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *token1=   oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_qm_false(result, failpart, token1, token2 TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_logical_op) {
    zval *arg_op_array;
    int  arg_operation;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rl", &arg_op_array, &arg_operation) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!is_boolean_op(arg_operation)) oel_compile_error(E_ERROR, "operation is not a boolean operation");

    znode *expr=  oel_stack_pop_operand(res_op_array TSRMLS_CC);
    oel_stack_push_token(res_op_array, expr TSRMLS_CC);
    znode *token= oel_create_token(res_op_array, (is_boolean_and_op(arg_operation) ? OEL_TYPE_TOKEN_LOGIC_AND : OEL_TYPE_TOKEN_LOGIC_AND) TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    if (is_boolean_and_op(arg_operation)) zend_do_boolean_and_begin(expr, token TSRMLS_CC);
    else  zend_do_boolean_or_begin(expr, token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_logical_op) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 2, OEL_TYPE_TOKEN_LOGIC_AND, OEL_TYPE_TOKEN_LOGIC_OR)) oel_compile_error(E_ERROR, "token type is not a logical operation");

    int token_type= oel_stack_top_get_type_token(res_op_array TSRMLS_CC);
    znode *token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *expr1= oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *expr2= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *result= expr1;
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    if (token_type == OEL_TYPE_TOKEN_LOGIC_AND) zend_do_boolean_and_end(result, expr1, expr2, token TSRMLS_CC);
    else  zend_do_boolean_or_end(result, expr1, expr2, token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_cast_op) {
    zval *arg_op_array;
    int   arg_operation;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rl", &arg_op_array, &arg_operation) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!is_cast_op(arg_operation)) oel_compile_error(E_ERROR, "operation is not a cast operation");

    znode *expr= oel_stack_top_operand(res_op_array TSRMLS_CC);
    znode *result= expr;

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_cast(result, expr, arg_operation TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_assign) {
    zval      *arg_op_array;
    zend_bool  arg_is_ref= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|b!", &arg_op_array, &arg_is_ref) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_assign without oel_add_begin_variable_parse");
    oel_stack_pop_token(res_op_array TSRMLS_CC);

    znode *righthand= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *lefthand=  oel_stack_pop_operand(res_op_array TSRMLS_CC);
    znode *result=    oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_check_writable_variable(lefthand);
    if (arg_is_ref) zend_do_assign_ref(result, righthand, lefthand TSRMLS_CC);
    else zend_do_assign(result, righthand, lefthand TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_empty) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_empty without oel_add_begin_variable_parse");

    oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *expr= oel_stack_top_operand(res_op_array TSRMLS_CC);
    znode *result= expr;

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_isset_or_isempty(ZEND_ISEMPTY, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_isset) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_isset without oel_add_begin_variable_parse");

    oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *expr= oel_stack_top_operand(res_op_array TSRMLS_CC);
    znode *result= expr;

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_isset_or_isempty(ZEND_ISSET, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}
