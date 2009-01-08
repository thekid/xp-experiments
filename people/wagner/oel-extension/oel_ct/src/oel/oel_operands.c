PHP_FUNCTION(oel_add_receive_arg) {
    zval              *arg_op_array, *arg_initialization= NULL;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *result, *offset, *varname, *initialization, *class_type;
    zend_uchar        *arg_varname,     *arg_class= NULL;
    zend_ulong         arg_varname_len, arg_class_len= 0, arg_ref= 0, arg_offset;
    zend_uchar         op, pass_by_reference;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rls|z!sb", &arg_op_array, &arg_offset, &arg_varname, &arg_varname_len, &arg_initialization, &arg_class, &arg_class_len, &arg_ref) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    result=  oel_create_extvar(res_op_array TSRMLS_CC);
    offset= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_LONG(&(offset->u.constant), arg_offset);
    varname= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&(varname->u.constant), arg_varname, arg_varname_len, 1);
    op= (arg_initialization) ? ZEND_RECV_INIT : ZEND_RECV;
    initialization= NULL;
    if (arg_initialization) {
        initialization= oel_create_extvar(res_op_array TSRMLS_CC);
        ZVAL_ZVAL(&(initialization->u.constant), arg_initialization, 1, 0);
    }
    class_type= oel_create_extvar(res_op_array TSRMLS_CC);
    if (arg_class_len == 0) class_type->op_type= IS_UNUSED;
    else ZVAL_STRINGL(&(class_type->u.constant), arg_class, arg_class_len, 1);
    pass_by_reference= arg_ref;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    fetch_simple_variable(result, varname, 0 TSRMLS_CC);
    zend_do_receive_arg(op, result, offset, initialization, class_type, varname, pass_by_reference TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_static_variable) {
    zval              *arg_op_array, *arg_init;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *name, *init;
    zend_uchar        *arg_name;
    zend_ulong         arg_name_len;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rsz", &arg_op_array, &arg_name, &arg_name_len, &arg_init) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    name= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&(name->u.constant), arg_name, arg_name_len, 1);
    init= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_ZVAL(&(init->u.constant), arg_init, 1, 0);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_fetch_static_variable(name, init, ZEND_FETCH_STATIC TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_variable_parse) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    oel_create_token(res_op_array, OEL_TYPE_TOKEN_VARIABLE TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_begin_variable_parse(TSRMLS_C);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_variable_parse) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *variable;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_end_variable_parse without oel_add_begin_variable_parse");

    oel_stack_pop_token(res_op_array TSRMLS_CC);
    variable= oel_stack_top_operand(res_op_array TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_end_variable_parse(PHP_OEL_COMPAT_EVP(variable) BP_VAR_R, 0 TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_push_variable) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *result, *varname, *classname= NULL, *class=NULL;
    zend_uchar        *arg_varname,     *arg_classname= NULL;
    zend_ulong         arg_varname_len,  arg_classname_len= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs|s", &arg_op_array, &arg_varname, &arg_varname_len, &arg_classname, &arg_classname_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_push_variable must be inner parse variable block");

    result=  oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);
    varname= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&(varname->u.constant), arg_varname, arg_varname_len, 1);
    if (arg_classname_len) {
        class= oel_create_extvar(res_op_array TSRMLS_CC);
        classname= oel_create_extvar(res_op_array TSRMLS_CC);
        ZVAL_STRINGL(&(classname->u.constant), arg_classname, arg_classname_len, 1);
    }

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    if (arg_classname_len) {
        zend_do_fetch_class(class, classname TSRMLS_CC);
        fetch_simple_variable(result, varname, 1 TSRMLS_CC);
        zend_do_fetch_static_member(result, class TSRMLS_CC);
        result->u.EA.type= ZEND_PARSED_STATIC_MEMBER;
    } else {
        fetch_simple_variable(result, varname, 1 TSRMLS_CC);
        result->u.EA.type= ZEND_PARSED_VARIABLE;
    }
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_push_variable_indirect) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *indirections, *result, *varname, *classname= NULL, *class=NULL;
    zend_uchar        *arg_varname,     *arg_classname= NULL;
    zend_ulong         arg_varname_len,  arg_classname_len= 0, arg_indirections;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rls|s", &arg_op_array, &arg_indirections, &arg_varname, &arg_varname_len, &arg_classname, &arg_classname_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_push_variable must be inner parse variable block");

    indirections=  oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_LONG(&indirections->u.constant, arg_indirections);
    result=  oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);
    varname= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&(varname->u.constant), arg_varname, arg_varname_len, 1);
    if (arg_classname_len) {
        class= oel_create_extvar(res_op_array TSRMLS_CC);
        classname= oel_create_extvar(res_op_array TSRMLS_CC);
        ZVAL_STRINGL(&(classname->u.constant), arg_classname, arg_classname_len, 1);
    }

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    if (arg_classname_len) {
        zend_do_fetch_class(class, classname TSRMLS_CC);
        zend_do_indirect_references(result, indirections, varname TSRMLS_CC);
        zend_do_fetch_static_member(result, class TSRMLS_CC);
        result->u.EA.type= ZEND_PARSED_STATIC_MEMBER;
    } else {
        zend_do_indirect_references(result, indirections, varname TSRMLS_CC);
        result->u.EA.type= ZEND_PARSED_VARIABLE;
    }
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_push_property) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *object, *result, *property;
    zend_uchar        *arg_name;
    zend_ulong         arg_name_len;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs", &arg_op_array, &arg_name, &arg_name_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_push_property must be inner parse variable block");

    object= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);
    property= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&(property->u.constant), arg_name, arg_name_len, 1);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_fetch_property(result, object, property TSRMLS_CC);
    result->u.EA.type= ZEND_PARSED_MEMBER;
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_push_constant) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *result, *name, *classname= NULL, *class=NULL;
    zend_uchar        *arg_name,     *arg_classname= NULL;
    zend_ulong         arg_name_len,  arg_classname_len= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs|s", &arg_op_array, &arg_name, &arg_name_len, &arg_classname, &arg_classname_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);
    name= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&(name->u.constant), arg_name, arg_name_len, 1);
    if (arg_classname_len) {
        class= oel_create_extvar(res_op_array TSRMLS_CC);
        classname= oel_create_extvar(res_op_array TSRMLS_CC);
        ZVAL_STRINGL(&(classname->u.constant), arg_classname, arg_classname_len, 1);
    }

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    if (arg_classname_len) {
        zend_do_fetch_class(class, classname TSRMLS_CC);
        zend_do_fetch_constant(result, class, name, ZEND_RT PHP_OEL_COMPAT_NSC(0) TSRMLS_CC);
    } else {
        zend_do_fetch_constant(result, NULL, name, ZEND_RT PHP_OEL_COMPAT_NSC(0) TSRMLS_CC);
    }
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_push_value) {
    zval              *arg_op_array, *arg_const;
    php_oel_op_array  *res_op_array;
    znode             *const_node;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rz", &arg_op_array, &arg_const) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    const_node= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_ZVAL(&(const_node->u.constant), arg_const, 1, 0);
    oel_stack_push_operand(res_op_array, const_node TSRMLS_CC);
}
