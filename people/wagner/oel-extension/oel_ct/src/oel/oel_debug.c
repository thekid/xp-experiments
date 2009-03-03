#include "opcodes.20071006.c"

zval *oel_get_zval_from_znode(zend_op_array *op_array, znode node TSRMLS_DC) {
    zval *oh_znode;

    MAKE_STD_ZVAL(oh_znode);

    switch (node.op_type) {
        case IS_CONST:
        object_init_ex(oh_znode, php_oel_ce_znode_constant);
        add_property_zval(oh_znode, "value", &(node.u.constant));
        break;

        case IS_TMP_VAR:
        object_init_ex(oh_znode, php_oel_ce_znode_tmpvar);
        add_property_long(oh_znode, "index", node.u.var);
        break;

        case IS_VAR:
        object_init_ex(oh_znode, php_oel_ce_znode_variable);
        add_property_long(oh_znode, "index", node.u.var);
        add_property_long(oh_znode, "type", node.u.EA.type);
        break;

        case IS_UNUSED:
        object_init_ex(oh_znode, php_oel_ce_znode_unused);
        break;

        case IS_CV:
        object_init_ex(oh_znode, php_oel_ce_znode_compiledvar);
        add_property_stringl(oh_znode, "name", op_array->vars[node.u.var].name, op_array->vars[node.u.var].name_len, 1);
        add_property_long(oh_znode, "type", node.u.EA.type);
        break;
    }
    return oh_znode;
}

void oel_add_next_index_opline(zend_op_array *op_array, zval *result_arr, zend_op *opline TSRMLS_DC) {
    zval *oh_opline, *oh_opcode, *oh_result, *oh_op1, *oh_op2, *trans_arr, **opcode_mne;

    MAKE_STD_ZVAL(oh_opline);
    object_init_ex(oh_opline, php_oel_ce_opline);
    add_next_index_zval(result_arr, oh_opline);

    /* build opcode object */
    MAKE_STD_ZVAL(oh_opcode);
    object_init_ex(oh_opcode, php_oel_ce_opcode);
    add_property_long(oh_opcode, "op", opline->opcode);
    /* fetch mnemonic for opcode */
    MAKE_STD_ZVAL(trans_arr);
    array_init(trans_arr);
    fill_opcode_translation_array(trans_arr);
    zend_hash_index_find(Z_ARRVAL_P(trans_arr), opline->opcode, (void**)&opcode_mne);
    add_property_stringl(oh_opcode, "mne", Z_STRVAL_PP(opcode_mne), Z_STRLEN_PP(opcode_mne), 1);
    zval_dtor(trans_arr);
    efree(trans_arr);
    add_property_zval(oh_opline, "opcode", oh_opcode);
    Z_SET_REFCOUNT(*oh_opcode, 1);

    add_property_long(oh_opline, "lineno", opline->lineno);
    add_property_long(oh_opline, "extended_value", opline->extended_value);

    oh_op1= oel_get_zval_from_znode(op_array, opline->op1 TSRMLS_CC);
    add_property_zval(oh_opline, "op1", oh_op1);
    Z_SET_REFCOUNT(*oh_op1, 1);

    oh_op2= oel_get_zval_from_znode(op_array, opline->op2 TSRMLS_CC);
    add_property_zval(oh_opline, "op2", oh_op2);
    Z_SET_REFCOUNT(*oh_op2, 1);

    oh_result= oel_get_zval_from_znode(op_array, opline->result TSRMLS_CC);
    add_property_zval(oh_opline, "result", oh_result);
    Z_SET_REFCOUNT(*oh_result, 1);
}

PHP_FUNCTION(oel_get_op_array) {
    zval              *arg_op_array;
    zend_op_array     *dump_op_array;
    zend_op           *opline, *end;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &arg_op_array) == FAILURE) { RETURN_NULL(); }

    switch (Z_TYPE_P(arg_op_array)) {
        case IS_RESOURCE: {               /* oel op code array */
            php_oel_op_array  *res_op_array;
            res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
            dump_op_array= res_op_array->oel_cg.active_op_array;
            break;
        }

        case IS_STRING: {                 /* string: lookup user function named accordingly */
            char *lcname;
            zend_function *fptr;

            lcname= zend_str_tolower_dup(Z_STRVAL_P(arg_op_array), Z_STRLEN_P(arg_op_array));
            if (zend_hash_find(EG(function_table), lcname, Z_STRLEN_P(arg_op_array) + 1, (void **)&fptr) == FAILURE) {
                efree(lcname);
                zend_error(E_WARNING, "Function %s() does not exist", Z_STRVAL_P(arg_op_array));
                RETURN_NULL();
            }
            efree(lcname);
            if (fptr->type == ZEND_INTERNAL_FUNCTION) {
                zend_error(E_WARNING, "Internal function %s() does not have an op array", Z_STRVAL_P(arg_op_array));
                RETURN_NULL();
            }

            dump_op_array= &(fptr->op_array);
            break;
        }

        case IS_ARRAY: {                  /* array(class, method): lookup user method */
            char *lcname;
            zend_function *fptr;
            zval **class_name, **method_name;
            zend_class_entry **pce;

            if (
                2 != zend_hash_num_elements(Z_ARRVAL_P(arg_op_array)) ||
                zend_hash_index_find(Z_ARRVAL_P(arg_op_array), 0, (void **) &class_name) == FAILURE ||
                zend_hash_index_find(Z_ARRVAL_P(arg_op_array), 1, (void **) &method_name) == FAILURE ||
                IS_STRING != Z_TYPE_PP(class_name) ||
                IS_STRING != Z_TYPE_PP(method_name)
            ) {
                zend_error(E_WARNING, "Expected an array(string class, string method)");
                RETURN_NULL();
            }

            if (zend_lookup_class(Z_STRVAL_PP(class_name), Z_STRLEN_PP(class_name), &pce TSRMLS_CC) == FAILURE) {
                zend_error(E_WARNING, "Class '%s' not found", Z_STRVAL_PP(class_name));
                RETURN_NULL();
            }

            if ((*pce)->type == ZEND_INTERNAL_CLASS) {
                zend_error(E_WARNING, "Internal class %s() does not have op arrays in methods", (*pce)->name);
                RETURN_NULL();
            }

            lcname= zend_str_tolower_dup(Z_STRVAL_PP(method_name), Z_STRLEN_PP(method_name));
            if (zend_hash_find(&(*pce)->function_table, lcname, Z_STRLEN_PP(method_name) + 1, (void **)&fptr) == FAILURE) {
                efree(lcname);
                zend_error(E_WARNING, "Method %s::%s() does not exist", (*pce)->name, Z_STRVAL_PP(method_name));
                RETURN_NULL();
            }
            efree(lcname);

            dump_op_array= &(fptr->op_array);
            break;
        }

        default: {
            zend_error(E_WARNING, "Expected either a resource(oel op code array) or a string");
            RETURN_NULL();
        }
    }

    opline= dump_op_array->opcodes;
    end= opline + dump_op_array->last;
    array_init(return_value);
    while (opline < end) {
        oel_add_next_index_opline(dump_op_array, return_value, opline TSRMLS_CC);
        opline++;
    }
}

PHP_FUNCTION(oel_get_translation_array) {
    array_init(return_value);
    fill_opcode_translation_array(return_value);
}

PHP_FUNCTION(oel_get_zend_api_no) {
    RETURN_LONG(ZEND_MODULE_API_NO);
}

PHP_FUNCTION(oel_get_token_stack_types) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    php_oel_znode     *stack_element;
    int                index= 0;
    char              *token_type;

    array_init(return_value);
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    stack_element= res_op_array->stack_token;
    while (stack_element) {
        switch (stack_element->type) {
            default: token_type= "unknown"; break;
            case OEL_TYPE_TOKEN_CLASS:           token_type= "OEL_TYPE_TOKEN_CLASS";          break;
            case OEL_TYPE_TOKEN_ACLASS:          token_type= "OEL_TYPE_TOKEN_ACLASS";         break;
            case OEL_TYPE_TOKEN_ICLASS:          token_type= "OEL_TYPE_TOKEN_ICLASS";         break;
            case OEL_TYPE_TOKEN_IF:              token_type= "OEL_TYPE_TOKEN_IF";             break;
            case OEL_TYPE_TOKEN_ELSE:            token_type= "OEL_TYPE_TOKEN_ELSE";           break;
            case OEL_TYPE_TOKEN_ELSEIF:          token_type= "OEL_TYPE_TOKEN_ELSEIF";         break;
            case OEL_TYPE_TOKEN_SWITCH:          token_type= "OEL_TYPE_TOKEN_SWITCH";         break;
            case OEL_TYPE_TOKEN_SWITCH_CASE:     token_type= "OEL_TYPE_TOKEN_SWITCH_CASE";    break;
            case OEL_TYPE_TOKEN_SWITCH_DEFAULT:  token_type= "OEL_TYPE_TOKEN_SWITCH_DEFAULT"; break;
            case OEL_TYPE_TOKEN_LOGIC_AND:       token_type= "OEL_TYPE_TOKEN_LOGIC_AND";      break;
            case OEL_TYPE_TOKEN_LOGIC_OR:        token_type= "OEL_TYPE_TOKEN_LOGIC_OR";       break;
            case OEL_TYPE_TOKEN_TENARY1:         token_type= "OEL_TYPE_TOKEN_TENARY1";        break;
            case OEL_TYPE_TOKEN_TENARY2:         token_type= "OEL_TYPE_TOKEN_TENARY2";        break;
            case OEL_TYPE_TOKEN_VARIABLE:        token_type= "OEL_TYPE_TOKEN_VARIABLE";       break;
            case OEL_TYPE_TOKEN_WHILE:           token_type= "OEL_TYPE_TOKEN_WHILE";          break;
            case OEL_TYPE_TOKEN_WHILE_BODY:      token_type= "OEL_TYPE_TOKEN_WHILE_BODY";     break;
            case OEL_TYPE_TOKEN_DOWHILE:         token_type= "OEL_TYPE_TOKEN_DOWHILE";        break;
            case OEL_TYPE_TOKEN_DOWHILE_BODY:    token_type= "OEL_TYPE_TOKEN_DOWHILE_BODY";   break;
            case OEL_TYPE_TOKEN_FOREACH:         token_type= "OEL_TYPE_TOKEN_FOREACH";        break;
            case OEL_TYPE_TOKEN_FOREACH_HEAD:    token_type= "OEL_TYPE_TOKEN_FOREACH_HEAD";   break;
            case OEL_TYPE_TOKEN_ARRAY_INIT:      token_type= "OEL_TYPE_TOKEN_ARRAY_INIT";     break;
            case OEL_TYPE_TOKEN_ARRAY_STATIC:    token_type= "OEL_TYPE_TOKEN_ARRAY_STATIC";   break;
            case OEL_TYPE_TOKEN_LIST:            token_type= "OEL_TYPE_TOKEN_LIST";           break;
            case OEL_TYPE_TOKEN_LIST_INNER:      token_type= "OEL_TYPE_TOKEN_LIST_INNER";     break;
            case OEL_TYPE_TOKEN_TRY:             token_type= "OEL_TYPE_TOKEN_TRY";            break;
            case OEL_TYPE_TOKEN_CATCH:           token_type= "OEL_TYPE_TOKEN_CATCH";          break;
            case OEL_TYPE_TOKEN_CATCH_FIRST:     token_type= "OEL_TYPE_TOKEN_CATCH_FIRST";    break;
            case OEL_TYPE_TOKEN_CATCH_ADD:       token_type= "OEL_TYPE_TOKEN_CATCH_ADD";      break;
            case OEL_TYPE_TOKEN_CATCH_LAST:      token_type= "OEL_TYPE_TOKEN_CATCH_LAST";     break;
        }
        add_index_string(return_value, index++, token_type, 1);
        stack_element= stack_element->next_var;
    }
}
