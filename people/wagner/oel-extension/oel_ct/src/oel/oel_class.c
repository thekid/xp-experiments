PHP_FUNCTION(oel_add_begin_class_declaration) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *class_name, *parent_class_name, *parent_class_node, *class_token;
    char              *arg_class_name, *arg_parent_name= NULL;
    zend_ulong         arg_parent_name_len= 0, arg_class_name_len;
    zend_bool          arg_is_final= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs|sb", &arg_op_array, &arg_class_name, &arg_class_name_len, &arg_parent_name, &arg_parent_name_len, &arg_is_final) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    class_name= oel_create_token(res_op_array, OEL_TYPE_UNSET TSRMLS_CC);
    ZVAL_STRINGL(&class_name->u.constant, arg_class_name, arg_class_name_len, 1);
    parent_class_name= oel_create_extvar(res_op_array TSRMLS_CC);
    parent_class_node= oel_create_extvar(res_op_array TSRMLS_CC);
    if (arg_parent_name_len > 0) {
        ZVAL_STRINGL(&parent_class_name->u.constant, arg_parent_name, arg_parent_name_len, 1);
    } else {
        parent_class_node->op_type= IS_UNUSED;
    }

    class_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_CLASS TSRMLS_CC);
    class_token->u.opline_num= CG(zend_lineno);
    class_token->u.EA.type= 0;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    if (arg_parent_name_len > 0) {
      zend_do_fetch_class(parent_class_node, parent_class_name TSRMLS_CC);
    }
    zend_do_begin_class_declaration(class_token, class_name, parent_class_node TSRMLS_CC);
    res_op_array->oel_cg.active_class_entry= CG(active_class_entry);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_class_declaration) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *class_name, *class_token;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_CLASS)) oel_compile_error(E_ERROR, "opend token is not of type class");

    class_token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    class_name=  oel_stack_pop_token(res_op_array TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_end_class_declaration(class_token, class_name TSRMLS_CC);
    res_op_array->oel_cg.active_class_entry= CG(active_class_entry);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_abstract_class_declaration) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *class_name, *parent_class_name, *class_token;
    char              *arg_class_name,    *arg_parent_name= NULL;
    zend_ulong         arg_class_name_len, arg_parent_name_len= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs|s", &arg_op_array, &arg_class_name, &arg_class_name_len, &arg_parent_name, &arg_parent_name_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    class_name= oel_create_token(res_op_array, OEL_TYPE_UNSET TSRMLS_CC);
    ZVAL_STRINGL(&class_name->u.constant, arg_class_name, arg_class_name_len, 1);
    parent_class_name= oel_create_extvar(res_op_array TSRMLS_CC);
    if (arg_parent_name_len > 0) {
        ZVAL_STRINGL(&parent_class_name->u.constant, arg_parent_name, arg_parent_name_len, 1);
    } else {
        parent_class_name->op_type= IS_UNUSED;
    }
    class_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_ACLASS TSRMLS_CC);
    class_token->u.opline_num= CG(zend_lineno);
    class_token->u.EA.type= ZEND_ACC_EXPLICIT_ABSTRACT_CLASS;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_begin_class_declaration(class_token, class_name, parent_class_name TSRMLS_CC);
    res_op_array->oel_cg.active_class_entry= CG(active_class_entry);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_abstract_class_declaration) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *class_name, *class_token;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ACLASS)) oel_compile_error(E_ERROR, "opend token is not of type abstract class");

    class_token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    class_name=  oel_stack_pop_token(res_op_array TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_end_class_declaration(class_token, class_name TSRMLS_CC);
    res_op_array->oel_cg.active_class_entry= CG(active_class_entry);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_interface_declaration) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *class_name, *class_token;
    char              *arg_class_name;
    zend_ulong         arg_class_name_len;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs", &arg_op_array, &arg_class_name, &arg_class_name_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    class_name= oel_create_token(res_op_array, OEL_TYPE_UNSET TSRMLS_CC);
    ZVAL_STRINGL(&class_name->u.constant, arg_class_name, arg_class_name_len, 1);
    class_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_ICLASS TSRMLS_CC);
    class_token->u.opline_num= CG(zend_lineno);
    class_token->u.EA.type= ZEND_ACC_INTERFACE;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_begin_class_declaration(class_token, class_name, NULL TSRMLS_CC);
    res_op_array->oel_cg.active_class_entry= CG(active_class_entry);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_interface_declaration) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *class_name, *class_token;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ICLASS)) oel_compile_error(E_ERROR, "opend token is not of type interface");

    class_token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    class_name=  oel_stack_pop_token(res_op_array TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_end_class_declaration(class_token, class_name TSRMLS_CC);
    res_op_array->oel_cg.active_class_entry= CG(active_class_entry);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_parent_interface) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *interface_node;
    char              *arg_iname;
    zend_ulong         arg_iname_len;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs", &arg_op_array, &arg_iname, &arg_iname_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ICLASS)) oel_compile_error(E_ERROR, "wrong token: interface token expected");

    interface_node= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&interface_node->u.constant, arg_iname, arg_iname_len, 1);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    PHP_OEL_COMPAT_FCL(interface_node);
    zend_do_implements_interface(interface_node TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_implements_interface) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *interface_node;
    char              *arg_iname;
    zend_ulong         arg_iname_len;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs", &arg_op_array, &arg_iname, &arg_iname_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 2, OEL_TYPE_TOKEN_CLASS, OEL_TYPE_TOKEN_ACLASS)) oel_compile_error(E_ERROR, "wrong token: class or abstract class token expected");

    interface_node= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&interface_node->u.constant, arg_iname, arg_iname_len, 1);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    PHP_OEL_COMPAT_FCL(interface_node);
    zend_do_implements_interface(interface_node TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_declare_property) {
    zval              *arg_op_array, *arg_default_value= NULL;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *name, *default_value;
    char              *arg_name;
    zend_ulong         arg_name_len, arg_acc= 0, flags;
    zend_bool          arg_stat= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs|zbl", &arg_op_array, &arg_name, &arg_name_len, &arg_default_value, &arg_stat, &arg_acc) == FAILURE) { RETURN_NULL(); }
    if (!arg_acc) arg_acc= ZEND_ACC_PUBLIC;
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 2, OEL_TYPE_TOKEN_CLASS, OEL_TYPE_TOKEN_ACLASS)) oel_compile_error(E_ERROR, "member must be declared inner a class declaration");

    name= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&(name->u.constant), arg_name, arg_name_len, 1);
    default_value= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_ZVAL(&(default_value->u.constant), arg_default_value, 1, 0);
    flags= (arg_acc & ZEND_ACC_PPP_MASK) | (arg_stat ? ZEND_ACC_STATIC : 0x0);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_declare_property(name, default_value, flags TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_declare_class_constant) {
    zval              *arg_op_array, *arg_value;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *name, *value;
    char              *arg_name;
    zend_ulong         arg_name_len;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rsz", &arg_op_array, &arg_name, &arg_name_len, &arg_value) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if(!oel_token_isa(res_op_array TSRMLS_CC, 3, OEL_TYPE_TOKEN_CLASS, OEL_TYPE_TOKEN_ACLASS, OEL_TYPE_TOKEN_ICLASS)) oel_compile_error(E_ERROR, "member must be declared inner a class or interface declaration");

    name= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&(name->u.constant), arg_name, arg_name_len, 1);
    value= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_ZVAL(&(value->u.constant), arg_value, 1, 0);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_declare_class_constant(name, value TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_instanceof) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *instance, *result, *name;
    char              *arg_name;
    zend_ulong         arg_name_len;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs", &arg_op_array, &arg_name, &arg_name_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    instance= oel_stack_top_operand(res_op_array TSRMLS_CC);
    result= instance;
    name= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&(name->u.constant), arg_name, arg_name_len, 1);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_fetch_class(name, name TSRMLS_CC);
    zend_do_instanceof(result, instance, name, 0 TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_clone) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    znode             *object, *clonee;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    object= oel_stack_top_operand(res_op_array TSRMLS_CC);
    clonee= object;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_clone(clonee, object TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}
