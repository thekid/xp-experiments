static inline php_oel_znode *oel_fetch_call_parameters(php_oel_op_array *res_op_array, int arg_parameter_count TSRMLS_DC) {
    php_oel_znode *result= NULL;
    int i;
    for (i= 1; i <= arg_parameter_count; i++) {
        php_oel_znode *node= (php_oel_znode *) emalloc(sizeof(php_oel_znode));
        node->next_var= result;
        result= node;

        result->ext_var= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    }
    return result;
}

static inline void oel_build_call_parameter_pass(php_oel_op_array *res_op_array, php_oel_znode *params TSRMLS_DC) {
    int i= 0;
    php_oel_znode *param;
    while (params) {
        param= params;
        zend_do_pass_param(param->ext_var, ZEND_SEND_VAL, ++i TSRMLS_CC);
        params= params->next_var;
        efree(param);
    }
}

PHP_FUNCTION(oel_new_function) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array, *func_op_array;
    php_oel_saved_env *env;
    znode             *func_name, *func_flags, *func_token;
    char              *arg_func_name, *new_filename, *old_filename;
    int                arg_func_name_len;
    zend_bool          arg_ref= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs|b", &arg_op_array, &arg_func_name, &arg_func_name_len, &arg_ref) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (oel_token_isa(res_op_array TSRMLS_CC, 3, OEL_TYPE_TOKEN_CLASS, OEL_TYPE_TOKEN_ACLASS, OEL_TYPE_TOKEN_ICLASS)) oel_compile_error(E_ERROR, "function must not be declared inner a class or an interface declaration (declare methods instead)");

    func_op_array= oel_init_child_op_array(res_op_array TSRMLS_CC);
    func_op_array->type= OEL_TYPE_OAR_FUNCTION;

    func_name=  oel_create_extvar(func_op_array TSRMLS_CC);
    ZVAL_STRINGL(&func_name->u.constant, arg_func_name, arg_func_name_len, 1);
    func_flags= oel_create_extvar(func_op_array TSRMLS_CC);
    ZVAL_LONG(&func_flags->u.constant, 0);
    func_token= oel_create_token(func_op_array, OEL_TYPE_OAR_FUNCTION TSRMLS_CC);
    func_token->u.opline_num= CG(zend_lineno);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_begin_function_declaration(func_token, func_name, 0, arg_ref, func_flags TSRMLS_CC);
    func_op_array->oel_cg.active_op_array= CG(active_op_array);
    oel_env_restore(res_op_array, env TSRMLS_CC);

    new_filename= (char *) emalloc(sizeof(PHP_OEL_FUN_RES_NAME) + sizeof(" (defined in )") + strlen(EG(active_op_array)->filename));
    sprintf(new_filename, "%s (defined in %s)", PHP_OEL_NME_RES_NAME, EG(active_op_array)->filename);
    old_filename= zend_get_compiled_filename(TSRMLS_C);
    func_op_array->oel_cg.active_op_array->filename= zend_set_compiled_filename(new_filename TSRMLS_CC);
    zend_restore_compiled_filename(old_filename TSRMLS_CC);
    efree(new_filename);
    ZEND_REGISTER_RESOURCE(return_value, func_op_array, le_oel_fun);
}

PHP_FUNCTION(oel_new_method) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array, *func_op_array;
    php_oel_saved_env *env;
    znode             *func_name, *func_flags, *func_token;
    char              *arg_func_name, *new_filename, *old_filename;
    int                arg_func_name_len, arg_acc= 0, modifier= 0x0;
    zend_bool          arg_ref= 0, arg_stat= 0, arg_fin= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs|bblb", &arg_op_array, &arg_func_name, &arg_func_name_len, &arg_ref, &arg_stat, &arg_acc, &arg_fin) == FAILURE) { RETURN_NULL(); }
    if (!arg_acc) arg_acc= ZEND_ACC_PUBLIC;
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 3, OEL_TYPE_TOKEN_CLASS, OEL_TYPE_TOKEN_ACLASS, OEL_TYPE_TOKEN_ICLASS)) oel_compile_error(E_ERROR, "method must be declared inner a class or an interface declaration");
    if (oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ICLASS)) {
      if (arg_fin) oel_compile_error(E_ERROR, "interface methods must not be declared final");
      if (arg_acc & ZEND_ACC_PRIVATE) oel_compile_error(E_ERROR, "interface methods must not be declared private");
    }

    func_op_array= oel_init_child_op_array(res_op_array TSRMLS_CC);
    func_op_array->type= OEL_TYPE_OAR_METHOD;

    func_name= oel_create_token(func_op_array, OEL_TYPE_UNSET TSRMLS_CC);
    ZVAL_STRINGL(&func_name->u.constant, arg_func_name, arg_func_name_len, 1);
    modifier|= (!arg_stat) ? 0x0 : ZEND_ACC_STATIC;
    modifier|= arg_acc & (ZEND_ACC_PROTECTED | ZEND_ACC_PRIVATE | ZEND_ACC_PUBLIC);
    modifier|= (!arg_fin)  ? 0x0 : ZEND_ACC_FINAL;
    func_flags= oel_create_token(func_op_array, OEL_TYPE_UNSET TSRMLS_CC);
    ZVAL_LONG(&func_flags->u.constant, modifier);
    func_token= oel_create_token(func_op_array, OEL_TYPE_OAR_METHOD TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_begin_function_declaration(func_token, func_name, 1, arg_ref, func_flags TSRMLS_CC);
    func_op_array->oel_cg.active_op_array= CG(active_op_array);
    oel_env_restore(res_op_array, env TSRMLS_CC);

    new_filename= (char *) emalloc(sizeof(PHP_OEL_NME_RES_NAME) + sizeof(" (defined in )") + strlen(EG(active_op_array)->filename));
    sprintf(new_filename, "%s (defined in %s)", PHP_OEL_NME_RES_NAME, EG(active_op_array)->filename);
    old_filename= zend_get_compiled_filename(TSRMLS_C);
    func_op_array->oel_cg.active_op_array->filename= zend_set_compiled_filename(new_filename TSRMLS_CC);
    zend_restore_compiled_filename(old_filename TSRMLS_CC);
    efree(new_filename);
    ZEND_REGISTER_RESOURCE(return_value, func_op_array, le_oel_nme);
}

PHP_FUNCTION(oel_new_abstract_method) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array, *func_op_array;
    php_oel_saved_env *env;
    znode             *func_name, *func_flags, *func_token;
    char              *arg_func_name, *new_filename, *old_filename;
    int                arg_func_name_len, arg_acc= 0, modifier= 0x0;
    zend_bool          arg_ref= 0, arg_stat= 0;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs|bbl", &arg_op_array, &arg_func_name, &arg_func_name_len, &arg_ref, &arg_stat, &arg_acc) == FAILURE) { RETURN_NULL(); }
    if (!arg_acc) arg_acc= ZEND_ACC_PUBLIC;
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_ACLASS)) oel_compile_error(E_ERROR, "abstract method must be declared inner an abstract class declaration");
    if (arg_acc & ZEND_ACC_PRIVATE) oel_compile_error(E_ERROR, "abstract methods may not be declared private: ingnored");

    func_op_array= oel_init_child_op_array(res_op_array TSRMLS_CC);
    func_op_array->type= OEL_TYPE_OAR_AMETHOD;

    func_name= oel_create_token(func_op_array, OEL_TYPE_UNSET TSRMLS_CC);
    ZVAL_STRINGL(&func_name->u.constant, arg_func_name, arg_func_name_len, 1);
    modifier= ZEND_ACC_ABSTRACT;
    modifier|= (!arg_stat) ? 0x0 : ZEND_ACC_STATIC;
    modifier|= arg_acc & (ZEND_ACC_PROTECTED | ZEND_ACC_PUBLIC);
    func_flags= oel_create_token(func_op_array, OEL_TYPE_UNSET TSRMLS_CC);
    ZVAL_LONG(&func_flags->u.constant, modifier);
    func_token= oel_create_token(func_op_array, OEL_TYPE_OAR_AMETHOD TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_begin_function_declaration(func_token, func_name, 1, arg_ref, func_flags TSRMLS_CC);
    func_op_array->oel_cg.active_op_array= CG(active_op_array);
    oel_env_restore(res_op_array, env TSRMLS_CC);

    new_filename= (char *) emalloc(sizeof(PHP_OEL_FUN_RES_NAME) + sizeof(" (defined in )") + strlen(EG(active_op_array)->filename));
    sprintf(new_filename, "%s (defined in %s)", PHP_OEL_NME_RES_NAME, EG(active_op_array)->filename);
    old_filename= zend_get_compiled_filename(TSRMLS_C);
    func_op_array->oel_cg.active_op_array->filename= zend_set_compiled_filename(new_filename TSRMLS_CC);
    zend_restore_compiled_filename(old_filename TSRMLS_CC);
    efree(new_filename);
    ZEND_REGISTER_RESOURCE(return_value, func_op_array, le_oel_ame);
}

PHP_FUNCTION(oel_add_call_function) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    php_oel_znode     *params;
    znode             *parameter_count, *func_name, *result;
    char              *arg_func_name;
    int                arg_func_name_len, arg_parameter_count, is_dynamic;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rls", &arg_op_array, &arg_parameter_count, &arg_func_name, &arg_func_name_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    parameter_count= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_LONG(&parameter_count->u.constant, arg_parameter_count);
    params= oel_fetch_call_parameters(res_op_array, arg_parameter_count TSRMLS_CC);
    func_name= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&func_name->u.constant, arg_func_name, arg_func_name_len, 1);
    result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    is_dynamic= zend_do_begin_function_call(func_name PHP_OEL_COMPAT_NSC(0) TSRMLS_CC);
    oel_build_call_parameter_pass(res_op_array, params TSRMLS_CC);
    zend_do_end_function_call(func_name, result, parameter_count, 0, is_dynamic TSRMLS_CC);
    zend_do_extended_fcall_end(TSRMLS_C);
    result->u.EA.type= ZEND_PARSED_FUNCTION_CALL;
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_call_function_name) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    php_oel_znode     *params;
    znode             *parameter_count, *func_name, *result;
    int                arg_parameter_count;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rl", &arg_op_array, &arg_parameter_count) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    parameter_count= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_LONG(&parameter_count->u.constant, arg_parameter_count);
    params= oel_fetch_call_parameters(res_op_array, arg_parameter_count TSRMLS_CC);
    func_name= oel_stack_top_operand(res_op_array TSRMLS_CC);
    result= func_name;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_begin_dynamic_function_call(func_name PHP_OEL_COMPAT_NSC(0) TSRMLS_CC);
    oel_build_call_parameter_pass(res_op_array, params TSRMLS_CC);
    zend_do_end_function_call(func_name, result, parameter_count, 0, 1 TSRMLS_CC);
    zend_do_extended_fcall_end(TSRMLS_C);
    result->u.EA.type= ZEND_PARSED_FUNCTION_CALL;
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_call_method) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    php_oel_znode     *params;
    znode             *parameter_count, *object, *method, *result;
    char              *arg_func_name;
    int                arg_func_name_len, arg_parameter_count;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rls", &arg_op_array, &arg_parameter_count, &arg_func_name, &arg_func_name_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_call_method op without oel_add_begin_variable_parse");

    oel_stack_pop_token(res_op_array TSRMLS_CC);
    parameter_count= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_LONG(&parameter_count->u.constant, arg_parameter_count);
    params= oel_fetch_call_parameters(res_op_array, arg_parameter_count TSRMLS_CC);
    object= oel_stack_top_operand(res_op_array TSRMLS_CC);
    method= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&method->u.constant, arg_func_name, arg_func_name_len, 1);
    result= object;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_fetch_property(method, object, method TSRMLS_CC);
    zend_do_begin_method_call(method TSRMLS_CC);
    oel_build_call_parameter_pass(res_op_array, params TSRMLS_CC);
    zend_do_end_function_call(method, result, parameter_count, 1, 1 TSRMLS_CC);
    zend_do_extended_fcall_end(TSRMLS_C);
    result->u.EA.type= ZEND_PARSED_METHOD_CALL;
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_call_method_static) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    php_oel_znode     *params;
    znode             *parameter_count, *func_name, *class, *result;
    char              *arg_func_name,     *arg_class_name;
    int                arg_func_name_len,  arg_class_name_len,  arg_parameter_count;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rlss", &arg_op_array, &arg_parameter_count, &arg_func_name, &arg_func_name_len, &arg_class_name, &arg_class_name_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    parameter_count= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_LONG(&parameter_count->u.constant, arg_parameter_count);
    params= oel_fetch_call_parameters(res_op_array, arg_parameter_count TSRMLS_CC);
    func_name=  oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&func_name->u.constant, arg_func_name, arg_func_name_len, 1);
    class= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&class->u.constant, arg_class_name, arg_class_name_len, 1);
    result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_fetch_class(class, class TSRMLS_CC);
    zend_do_begin_class_member_function_call(class, func_name TSRMLS_CC);
    oel_build_call_parameter_pass(res_op_array, params TSRMLS_CC);
    zend_do_end_function_call(NULL, result, parameter_count, 1, 1 TSRMLS_CC);
    zend_do_extended_fcall_end(TSRMLS_C);
    result->u.EA.type= ZEND_PARSED_FUNCTION_CALL;
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_call_method_name) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    php_oel_znode     *params;
    znode             *parameter_count, *method, *object, *result;
    int                arg_parameter_count;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rl", &arg_op_array, &arg_parameter_count) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_TOKEN_VARIABLE)) oel_compile_error(E_ERROR, "oel_add_call_method op without oel_add_begin_variable_parse");

    oel_stack_pop_token(res_op_array TSRMLS_CC);
    parameter_count= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_LONG(&parameter_count->u.constant, arg_parameter_count);
    params= oel_fetch_call_parameters(res_op_array, arg_parameter_count TSRMLS_CC);
    method= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    object= oel_stack_top_operand(res_op_array TSRMLS_CC);
    result= object;

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_fetch_property(method, object, method TSRMLS_CC);
    zend_do_begin_method_call(method TSRMLS_CC);
    oel_build_call_parameter_pass(res_op_array, params TSRMLS_CC);
    zend_do_end_function_call(method, result, parameter_count, 1, 1 TSRMLS_CC);
    zend_do_extended_fcall_end(TSRMLS_C);
    result->u.EA.type= ZEND_PARSED_METHOD_CALL;
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_call_method_name_static) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    php_oel_znode     *params;
    znode             *parameter_count, *func_name, *class, *result;
    char              *arg_class_name;
    int                arg_class_name_len,  arg_parameter_count;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rls", &arg_op_array, &arg_parameter_count, &arg_class_name, &arg_class_name_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    parameter_count= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_LONG(&parameter_count->u.constant, arg_parameter_count);
    params= oel_fetch_call_parameters(res_op_array, arg_parameter_count TSRMLS_CC);
    func_name= oel_stack_pop_operand(res_op_array TSRMLS_CC);
    class= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&class->u.constant, arg_class_name, arg_class_name_len, 1);
    result= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_fetch_class(class, class TSRMLS_CC);
    zend_do_begin_class_member_function_call(class, func_name TSRMLS_CC);
    oel_build_call_parameter_pass(res_op_array, params TSRMLS_CC);
    zend_do_end_function_call(NULL, result, parameter_count, 1, 1 TSRMLS_CC);
    zend_do_extended_fcall_end(TSRMLS_C);
    result->u.EA.type= ZEND_PARSED_FUNCTION_CALL;
    oel_env_restore(res_op_array, env TSRMLS_CC);
}

PHP_FUNCTION(oel_add_new_object) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_saved_env *env;
    php_oel_znode     *params;
    znode             *parameter_count, *class_name, *class, *result, *token;
    char              *arg_class_name;
    int                arg_class_name_len,  arg_parameter_count;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rls", &arg_op_array, &arg_parameter_count, &arg_class_name, &arg_class_name_len) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    parameter_count= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_LONG(&parameter_count->u.constant, arg_parameter_count);
    params= oel_fetch_call_parameters(res_op_array, arg_parameter_count TSRMLS_CC);
    class_name= oel_create_extvar(res_op_array TSRMLS_CC);
    ZVAL_STRINGL(&(class_name->u.constant), arg_class_name, arg_class_name_len, 1);
    result= class= class_name;
    oel_stack_push_operand(res_op_array, result TSRMLS_CC);
    token= oel_create_extvar(res_op_array TSRMLS_CC);

    env= oel_env_prepare(res_op_array TSRMLS_CC);
    zend_do_fetch_class(class, class_name TSRMLS_CC);
    zend_do_extended_fcall_begin(TSRMLS_C);
    zend_do_begin_new_object(token, class TSRMLS_CC);
    oel_build_call_parameter_pass(res_op_array, params TSRMLS_CC);
    zend_do_end_new_object(result, token, parameter_count TSRMLS_CC);
    zend_do_extended_fcall_end(TSRMLS_C);
    oel_env_restore(res_op_array, env TSRMLS_CC);
}
