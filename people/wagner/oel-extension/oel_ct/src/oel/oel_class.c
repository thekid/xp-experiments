PHP_FUNCTION(oel_add_begin_class_declaration) {
    zval *arg_op_array;
    char *arg_class_name;
    int   arg_class_name_len;
    char *arg_parent_name= NULL;
    int   arg_parent_name_len= 0;
    int   arg_is_final= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs|sl", &arg_op_array, &arg_class_name, &arg_class_name_len, &arg_parent_name, &arg_parent_name_len, &arg_is_final) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *class_name= oel_create_token(res_op_array, OEL_TYPE_UNSET TSRMLS_CC);
    ZVAL_STRINGL(&class_name->u.constant, arg_class_name, arg_class_name_len, 1);
    znode *parent_class_name= oel_create_extvar(res_op_array TSRMLS_CC);
    znode *parent_class_node= oel_create_extvar(res_op_array TSRMLS_CC);
    if (arg_parent_name_len > 0) {
        ZVAL_STRINGL(&parent_class_name->u.constant, arg_parent_name, arg_parent_name_len, 1);
    } else {
        parent_class_node->op_type= IS_UNUSED;
    }
    int mod= (arg_is_final) ? ZEND_ACC_FINAL : 0x0;

    znode *class_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_CLASS TSRMLS_CC);
    class_token->u.opline_num= CG(zend_lineno);
    class_token->u.EA.type= 0;

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    if (arg_parent_name_len > 0) {
      zend_do_fetch_class(parent_class_node, parent_class_name TSRMLS_CC);
    }
    zend_do_begin_class_declaration(class_token, class_name, parent_class_node TSRMLS_CC);
    res_op_array->oel_cg.active_class_entry= CG(active_class_entry);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_class_declaration) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_CLASS)) oel_compile_error(E_ERROR, "opend token is not of type class");

    znode *class_token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *class_name=  oel_stack_pop_token(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_end_class_declaration(class_token, class_name TSRMLS_CC);
    res_op_array->oel_cg.active_class_entry= CG(active_class_entry);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_abstract_class_declaration) {
    zval *arg_op_array;
    char *arg_class_name;
    int   arg_class_name_len;
    char *arg_parent_name= NULL;
    int   arg_parent_name_len= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs|s", &arg_op_array, &arg_class_name, &arg_class_name_len, &arg_parent_name, &arg_parent_name_len) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *class_name= oel_create_token(res_op_array, OEL_TYPE_UNSET TSRMLS_CC);
    ZVAL_STRINGL(&class_name->u.constant, arg_class_name, arg_class_name_len, 1);
    znode *parent_class_name= oel_create_extvar(res_op_array TSRMLS_CC);
    if (arg_parent_name_len > 0) {
        ZVAL_STRINGL(&parent_class_name->u.constant, arg_parent_name, arg_parent_name_len, 1);
    } else {
        parent_class_name->op_type= IS_UNUSED;
    }
    znode *class_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_ACLASS TSRMLS_CC);
    class_token->u.opline_num= CG(zend_lineno);
    class_token->u.EA.type= ZEND_ACC_EXPLICIT_ABSTRACT_CLASS;

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_begin_class_declaration(class_token, class_name, parent_class_name TSRMLS_CC);
    res_op_array->oel_cg.active_class_entry= CG(active_class_entry);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_abstract_class_declaration) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ACLASS)) oel_compile_error(E_ERROR, "opend token is not of type abstract class");

    znode *class_token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *class_name=  oel_stack_pop_token(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_end_class_declaration(class_token, class_name TSRMLS_CC);
    res_op_array->oel_cg.active_class_entry= CG(active_class_entry);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_begin_interface_declaration) {
    zval *arg_op_array;
    char *arg_class_name;
    int   arg_class_name_len;
    char *arg_parent_name= NULL;
    int   arg_parent_name_len= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs|s", &arg_op_array, &arg_class_name, &arg_class_name_len, &arg_parent_name, &arg_parent_name_len) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *class_name= oel_create_token(res_op_array, OEL_TYPE_UNSET TSRMLS_CC);
    ZVAL_STRINGL(&class_name->u.constant, arg_class_name, arg_class_name_len, 1);
    znode *parent_class_name= oel_create_extvar(res_op_array TSRMLS_CC);
    if (arg_parent_name_len > 0) {
        ZVAL_STRINGL(&parent_class_name->u.constant, arg_parent_name, arg_parent_name_len, 1);
    } else {
        parent_class_name->op_type= IS_UNUSED;
    }
    znode *class_token= oel_create_token(res_op_array, OEL_TYPE_TOKEN_ICLASS TSRMLS_CC);
    class_token->u.opline_num= CG(zend_lineno);
    class_token->u.EA.type= ZEND_ACC_INTERFACE;

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_begin_class_declaration(class_token, class_name, parent_class_name TSRMLS_CC);
    res_op_array->oel_cg.active_class_entry= CG(active_class_entry);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_end_interface_declaration) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ICLASS)) oel_compile_error(E_ERROR, "opend token is not of type interface");

    znode *class_token= oel_stack_pop_token(res_op_array TSRMLS_CC);
    znode *class_name=  oel_stack_pop_token(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_end_class_declaration(class_token, class_name TSRMLS_CC);
    res_op_array->oel_cg.active_class_entry= CG(active_class_entry);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_implements_interface) {
    zval *arg_op_array;
    char *arg_iname;
    int   arg_iname_len;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs", &arg_op_array, &arg_iname, &arg_iname_len) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *interface_name= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&interface_name->u.constant, arg_iname, arg_iname_len, 1);
    znode *interface_node= oel_create_extvar(res_op_array TSRMLS_CC);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_fetch_class(interface_node, interface_name TSRMLS_CC);
    zend_do_implements_interface(interface_node TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_declare_property) {
    zval *arg_op_array;
    char *arg_name;
    int   arg_name_len;
    zval *arg_default_value= NULL;
    int   arg_stat= 0;
    int   arg_acc= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs|zll", &arg_op_array, &arg_name, &arg_name_len, &arg_default_value, &arg_stat, &arg_acc) == FAILURE) { RETURN_NULL(); }
    if (!arg_acc) arg_acc= ZEND_ACC_PUBLIC;
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 2, OEL_TYPE_TOKEN_CLASS, OEL_TYPE_TOKEN_ACLASS)) oel_compile_error(E_ERROR, "member must be declared inner a class declaration");

    znode *name= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&(name->u.constant), arg_name, arg_name_len, 1);
    znode *default_value= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_ZVAL(&(default_value->u.constant), arg_default_value, 1, 0);
    int flags= (arg_acc & ZEND_ACC_PPP_MASK) | (arg_stat ? ZEND_ACC_STATIC : 0x0);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_declare_property(name, default_value, flags TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_declare_class_constant) {
    zval *arg_op_array;
    char *arg_name;
    int   arg_name_len;
    zval *arg_value;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rsz", &arg_op_array, &arg_name, &arg_name_len, &arg_value) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);
    if(!oel_token_isa(res_op_array TSRMLS_CC, 3, OEL_TYPE_TOKEN_CLASS, OEL_TYPE_TOKEN_ACLASS, OEL_TYPE_TOKEN_ICLASS)) oel_compile_error(E_ERROR, "member must be declared inner a class or interface declaration");

    znode *name= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&(name->u.constant), arg_name, arg_name_len, 1);
    znode *value= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_ZVAL(&(value->u.constant), arg_value, 1, 0);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_declare_class_constant(name, value TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_instanceof) {
    zval *arg_op_array;
    char *arg_name;
    int   arg_name_len;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs", &arg_op_array, &arg_name, &arg_name_len) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *instance= oel_stack_top_operand(res_op_array TSRMLS_CC);
    znode *result= instance;
    znode *name= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&(name->u.constant), arg_name, arg_name_len, 1);

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_fetch_class(name, name TSRMLS_CC);
    zend_do_instanceof(result, instance, name, 0 TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_clone) {
    zval *arg_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_oel_op_array *res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_DC);

    znode *object= oel_stack_top_operand(res_op_array TSRMLS_CC);
    znode *clonee= object;

    php_oel_saved_env *env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_clone(clonee, object TSRMLS_CC);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}
