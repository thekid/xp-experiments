#ifndef PHP_OEL_H
#define PHP_OEL_H

    #include "php_oel_common.h"

    #define OEL_TYPE_TOKEN_CLASS           6
    #define OEL_TYPE_TOKEN_ACLASS          7
    #define OEL_TYPE_TOKEN_ICLASS          8
    #define OEL_TYPE_TOKEN_IF              9
    #define OEL_TYPE_TOKEN_ELSE           10
    #define OEL_TYPE_TOKEN_ELSEIF         11
    #define OEL_TYPE_TOKEN_SWITCH         12
    #define OEL_TYPE_TOKEN_SWITCH_CASE    13
    #define OEL_TYPE_TOKEN_SWITCH_DEFAULT 14
    #define OEL_TYPE_TOKEN_LOGIC_AND      15
    #define OEL_TYPE_TOKEN_LOGIC_OR       16
    #define OEL_TYPE_TOKEN_TINARY1        17
    #define OEL_TYPE_TOKEN_TINARY2        18
    #define OEL_TYPE_TOKEN_VARIABLE       19
    #define OEL_TYPE_TOKEN_WHILE          20
    #define OEL_TYPE_TOKEN_WHILE_BODY     21
    #define OEL_TYPE_TOKEN_DOWHILE        22
    #define OEL_TYPE_TOKEN_DOWHILE_BODY   23
    #define OEL_TYPE_TOKEN_FOREACH        24
    #define OEL_TYPE_TOKEN_FOREACH_BODY   25
    #define OEL_TYPE_TOKEN_ARRAY_INIT     26
    #define OEL_TYPE_TOKEN_ARRAY_STATIC   27
    #define OEL_TYPE_TOKEN_LIST           28
    #define OEL_TYPE_TOKEN_LIST_INNER     29
    #define OEL_TYPE_TOKEN_TRY            30
    #define OEL_TYPE_TOKEN_CATCH          31
    #define OEL_TYPE_TOKEN_CATCH_FIRST    32
    #define OEL_TYPE_TOKEN_CATCH_ADD      33
    #define OEL_TYPE_TOKEN_CATCH_LAST     34

    #define PHP_OEL_STACK_SERVICE_FUNCTIONS(v)                                                                                                                                      \
    static void   oel_stack_push_##v(php_oel_op_array *res_op_array, znode *node TSRMLS_DC)      { oel_stack_push(               #v, &(res_op_array->stack_##v), node TSRMLS_CC); } \
    static znode *oel_stack_pop_##v(php_oel_op_array *res_op_array TSRMLS_DC)                    { return oel_stack_pop(         #v, &(res_op_array->stack_##v) TSRMLS_CC); }       \
    static znode *oel_stack_top_##v(php_oel_op_array *res_op_array TSRMLS_DC)                    { return oel_stack_top(         #v, &(res_op_array->stack_##v) TSRMLS_CC); }       \
    static int    oel_stack_top_get_type_##v(php_oel_op_array *res_op_array TSRMLS_DC)           { return oel_stack_top_get_type(#v, &(res_op_array->stack_##v) TSRMLS_CC); }       \
    static void   oel_stack_top_set_type_##v(php_oel_op_array *res_op_array, int type TSRMLS_DC) { oel_stack_top_set_type(       #v, &(res_op_array->stack_##v), type TSRMLS_CC); } \
    static int    oel_stack_size_##v(php_oel_op_array *res_op_array TSRMLS_DC)                   { return oel_stack_size(        #v, &(res_op_array->stack_##v) TSRMLS_CC); }       \
    static void   oel_stack_destroy_##v(php_oel_op_array *res_op_array TSRMLS_DC)                { oel_stack_destroy(            #v, &(res_op_array->stack_##v) TSRMLS_CC); }       \

    #define PHP_OEL_STACK_SERVICE_FUNCTIONS_HEADER(v)                           \
    static void   oel_stack_push_##v(php_oel_op_array*, znode* TSRMLS_DC);      \
    static znode *oel_stack_pop_##v(php_oel_op_array* TSRMLS_DC);               \
    static znode *oel_stack_top_##v(php_oel_op_array* TSRMLS_DC);               \
    static int    oel_stack_top_get_type_##v(php_oel_op_array* TSRMLS_DC);      \
    static void   oel_stack_top_set_type_##v(php_oel_op_array*, int TSRMLS_DC); \
    static int    oel_stack_size_##v(php_oel_op_array* TSRMLS_DC);              \
    static void   oel_stack_destroy_##v(php_oel_op_array* TSRMLS_DC);           \

    #define PHP_OEL_SAFE_CG(o, e, p)   (e)->p= CG(p); 
    #define PHP_OEL_SET_CG(o, e, p)    CG(p)= (o)->oel_cg.p; 
    #define PHP_OEL_RESAFE_CG(o, e, p) (o)->oel_cg.p= CG(p); 
    #define PHP_OEL_RESET_CG(o, e, p)  CG(p)= (e)->p; 

    PHP_MINIT_FUNCTION(oel);

    PHP_FUNCTION(oel_new_op_array);
    PHP_FUNCTION(oel_finalize);
    PHP_FUNCTION(oel_execute);
    PHP_FUNCTION(oel_add_echo);
    PHP_FUNCTION(oel_add_return);
    PHP_FUNCTION(oel_add_free);
    PHP_FUNCTION(oel_add_break);
    PHP_FUNCTION(oel_add_continue);
    PHP_FUNCTION(oel_add_exit);
    PHP_FUNCTION(oel_add_include);
    PHP_FUNCTION(oel_add_include_once);
    PHP_FUNCTION(oel_add_require);
    PHP_FUNCTION(oel_add_require_once);
    PHP_FUNCTION(oel_add_eval);
    PHP_FUNCTION(oel_add_unset);

    PHP_FUNCTION(oel_add_begin_if);
    PHP_FUNCTION(oel_add_end_if);
    PHP_FUNCTION(oel_add_begin_elseif);
    PHP_FUNCTION(oel_add_end_elseif);
    PHP_FUNCTION(oel_add_end_else);
    PHP_FUNCTION(oel_add_begin_switch);
    PHP_FUNCTION(oel_add_end_switch);
    PHP_FUNCTION(oel_add_begin_case);
    PHP_FUNCTION(oel_add_end_case);
    PHP_FUNCTION(oel_add_begin_default);
    PHP_FUNCTION(oel_add_end_default);

    PHP_FUNCTION(oel_add_begin_while);
    PHP_FUNCTION(oel_add_begin_while_body);
    PHP_FUNCTION(oel_add_end_while);
    PHP_FUNCTION(oel_add_begin_dowhile);
    PHP_FUNCTION(oel_add_end_dowhile_body);
    PHP_FUNCTION(oel_add_end_dowhile);
    PHP_FUNCTION(oel_add_begin_foreach);
    PHP_FUNCTION(oel_add_begin_foreach_body);
    PHP_FUNCTION(oel_add_end_foreach);

    PHP_FUNCTION(oel_add_unary_op);
    PHP_FUNCTION(oel_add_incdec_op);
    PHP_FUNCTION(oel_add_binary_op);
    PHP_FUNCTION(oel_add_begin_tinary_op);
    PHP_FUNCTION(oel_add_tinary_op_true);
    PHP_FUNCTION(oel_add_tinary_op_false);
    PHP_FUNCTION(oel_add_begin_logical_op);
    PHP_FUNCTION(oel_add_end_logical_op);
    PHP_FUNCTION(oel_add_cast_op);
    PHP_FUNCTION(oel_add_assign);
    PHP_FUNCTION(oel_add_empty);
    PHP_FUNCTION(oel_add_isset);

    PHP_FUNCTION(oel_add_receive_arg);
    PHP_FUNCTION(oel_add_static_variable);
    PHP_FUNCTION(oel_add_begin_variable_parse);
    PHP_FUNCTION(oel_add_end_variable_parse);
    PHP_FUNCTION(oel_push_variable);
    PHP_FUNCTION(oel_push_variable_indirect);
    PHP_FUNCTION(oel_push_property);
    PHP_FUNCTION(oel_push_value);
    PHP_FUNCTION(oel_push_constant);

    PHP_FUNCTION(oel_new_function);
    PHP_FUNCTION(oel_new_method);
    PHP_FUNCTION(oel_new_abstract_method);
    PHP_FUNCTION(oel_add_call_function);
    PHP_FUNCTION(oel_add_call_function_name);
    PHP_FUNCTION(oel_add_call_method);
    PHP_FUNCTION(oel_add_call_method_static);
    PHP_FUNCTION(oel_add_call_method_name);
    PHP_FUNCTION(oel_add_call_method_name_static);
    PHP_FUNCTION(oel_add_new_object);

    PHP_FUNCTION(oel_add_begin_class_declaration);
    PHP_FUNCTION(oel_add_end_class_declaration);
    PHP_FUNCTION(oel_add_begin_abstract_class_declaration);
    PHP_FUNCTION(oel_add_end_abstract_class_declaration);
    PHP_FUNCTION(oel_add_begin_interface_declaration);
    PHP_FUNCTION(oel_add_end_interface_declaration);
    PHP_FUNCTION(oel_add_implements_interface);
    PHP_FUNCTION(oel_add_declare_property);
    PHP_FUNCTION(oel_add_declare_class_constant);
    PHP_FUNCTION(oel_add_instanceof);
    PHP_FUNCTION(oel_add_clone);

    PHP_FUNCTION(oel_add_begin_array_init);
    PHP_FUNCTION(oel_add_end_array_init);
    PHP_FUNCTION(oel_add_array_init_element);
    PHP_FUNCTION(oel_add_array_init_key_element);
    PHP_FUNCTION(oel_push_dim);
    PHP_FUNCTION(oel_push_new_dim);
    PHP_FUNCTION(oel_add_begin_staticarray_init);
    PHP_FUNCTION(oel_add_end_staticarray_init);
    PHP_FUNCTION(oel_add_staticarray_init_element);
    PHP_FUNCTION(oel_add_staticarray_init_key_element);
    PHP_FUNCTION(oel_add_begin_list);
    PHP_FUNCTION(oel_add_end_list);
    PHP_FUNCTION(oel_add_begin_inner_list);
    PHP_FUNCTION(oel_add_end_inner_list);
    PHP_FUNCTION(oel_add_list_element);

    PHP_FUNCTION(oel_add_begin_tryblock);
    PHP_FUNCTION(oel_add_begin_catchblock);
    PHP_FUNCTION(oel_add_begin_firstcatch);
    PHP_FUNCTION(oel_add_end_firstcatch);
    PHP_FUNCTION(oel_add_begin_catch);
    PHP_FUNCTION(oel_add_end_catch);
    PHP_FUNCTION(oel_add_end_catchblock);
    PHP_FUNCTION(oel_add_throw);

    extern zend_module_entry oel_module_entry;
    #define phpext_oel_ptr &oel_module_entry

#endif
