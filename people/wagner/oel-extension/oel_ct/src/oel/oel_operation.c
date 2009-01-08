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
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *operand, *result;
    zend_ulong         arg_operation;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rl", &arg_op_array, &arg_operation) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!is_unary_op(arg_operation)) oel_compile_error(E_ERROR, "operation is not a unary operation");

    operand= oel_stack_top_operand(res_op_array TSRMLS_CC);
    result= operand;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_unary_op(arg_operation, result, operand TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_incdec_op) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *operand, *result;
    zend_ulong         arg_operation;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rl", &arg_op_array, &arg_operation) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "assigning op without oel_add_begin_variable_parse");
    if (!is_incdec_op(arg_operation)) oel_compile_error(E_ERROR, "operation is not an incdec operation");

    oel_stack_pop_token(res_op_array TSRMLS_CC);
    operand= oel_stack_top_operand(res_op_array TSRMLS_CC);
    result= operand;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_check_writable_variable(operand);
    zend_do_end_variable_parse(PHP_OEL_COMPAT_EVP(operand) BP_VAR_RW, 0 TSRMLS_CC);
    if (is_incdec_post_op(arg_operation)) zend_do_post_incdec(result, operand, arg_operation TSRMLS_CC);
    else zend_do_pre_incdec(result, operand, arg_operation TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_binary_op) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *lefthand, *righthand, *result;
    zend_ulong         arg_operation;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rl", &arg_op_array, &arg_operation) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!is_binary_op(arg_operation)) oel_compile_error(E_ERROR, "operation is not a binary operation");

    lefthand=  oel_stack_pop_operand(res_op_array TSRMLS_CC);
    righthand= oel_stack_top_operand(res_op_array TSRMLS_CC);
    result= righthand;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    if (is_binary_assign_op(arg_operation)) {
        if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "assigning binary op without oel_add_begin_variable_parse");
        oel_stack_pop_token(res_op_array TSRMLS_CC);
        zend_check_writable_variable(lefthand);
        zend_do_end_variable_parse(PHP_OEL_COMPAT_EVP(lefthand) BP_VAR_RW, 0 TSRMLS_CC);
        zend_do_binary_assign_op(arg_operation, result, lefthand, righthand TSRMLS_CC);
    } else {
        zend_do_binary_op(arg_operation, result, lefthand, righthand TSRMLS_CC);
    }
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_tenary_op) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *cond, *token;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    cond=  oel_stack_pop_operand(res_op_array TSRMLS_CC);
    token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_TENARY1 TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_begin_qm_op(cond, token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_tenary_op_true) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *truepart, *token1, *token2;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_TENARY1)) oel_compile_error(E_ERROR, "token is not of type trinary 1");

    truepart= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    token1=   oel_stack_top_token(res_op_array TSRMLS_CC);
    token2=   oel_create_token(res_op_array, OEL_TYPE_TOKEN_TENARY2 TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_qm_true(truepart, token1, token2 TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_tenary_op_false) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *failpart, *token1, *token2, *result;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_TENARY2)) oel_compile_error(E_ERROR, "token is not of type trinary 2");

    failpart= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    token2=   oel_stack_pop_token(res_op_array TSRMLS_CC);
    token1=   oel_stack_pop_token(res_op_array TSRMLS_CC);
    result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_qm_false(result, failpart, token1, token2 TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_logical_op) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *expr, *token;
    int                arg_operation;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rl", &arg_op_array, &arg_operation) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!is_boolean_op(arg_operation)) oel_compile_error(E_ERROR, "operation is not a boolean operation");

    expr=  oel_stack_pop_operand(res_op_array TSRMLS_CC);
    oel_stack_push_token(res_op_array, expr TSRMLS_CC);
    token= oel_create_token(res_op_array, (is_boolean_and_op(arg_operation) ? OEL_TYPE_TOKEN_LOGIC_AND : OEL_TYPE_TOKEN_LOGIC_OR) TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    if (is_boolean_and_op(arg_operation)) zend_do_boolean_and_begin(expr, token TSRMLS_CC);
    else  zend_do_boolean_or_begin(expr, token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_logical_op) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *token, *expr1, *expr2, *result;
    zend_ulong         token_type;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 2, OEL_TYPE_TOKEN_LOGIC_AND, OEL_TYPE_TOKEN_LOGIC_OR)) oel_compile_error(E_ERROR, "token type is not a logical operation");

    token_type= oel_stack_top_get_type_token(res_op_array TSRMLS_CC);
    token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    expr1= oel_stack_pop_token(res_op_array TSRMLS_CC);
    expr2= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    result= expr1;
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    if (token_type == OEL_TYPE_TOKEN_LOGIC_AND) zend_do_boolean_and_end(result, expr1, expr2, token TSRMLS_CC);
    else  zend_do_boolean_or_end(result, expr1, expr2, token TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_cast_op) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *expr, *result;
    zend_ulong         arg_operation;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rl", &arg_op_array, &arg_operation) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!is_cast_op(arg_operation)) oel_compile_error(E_ERROR, "operation is not a cast operation");

    expr= oel_stack_top_operand(res_op_array TSRMLS_CC);
    result= expr;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_cast(result, expr, arg_operation TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_assign) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *lefthand, *righthand, *result;
    zend_bool          arg_is_ref= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|b!", &arg_op_array, &arg_is_ref) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_assign without oel_add_begin_variable_parse");
    oel_stack_pop_token(res_op_array TSRMLS_CC);

    lefthand=  oel_stack_pop_operand(res_op_array TSRMLS_CC);
    righthand= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    result=    oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_check_writable_variable(lefthand);
    if (arg_is_ref) zend_do_assign_ref(result, lefthand, righthand TSRMLS_CC);
    else zend_do_assign(result, lefthand, righthand TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_empty) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *expr, *result;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_empty without oel_add_begin_variable_parse");

    oel_stack_pop_token(res_op_array TSRMLS_CC);
    expr= oel_stack_top_operand(res_op_array TSRMLS_CC);
    result= expr;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_isset_or_isempty(ZEND_ISEMPTY, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_isset) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *expr, *result;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_isset without oel_add_begin_variable_parse");

    oel_stack_pop_token(res_op_array TSRMLS_CC);
    expr= oel_stack_top_operand(res_op_array TSRMLS_CC);
    result= expr;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_isset_or_isempty(ZEND_ISSET, result, expr TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}
