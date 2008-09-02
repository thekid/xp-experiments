#ifndef PHP_OEL_H
#define PHP_OEL_H 1

#define PHP_OEL_VERSION "0.9.0"
#define PHP_OEL_EXTNAME "oel"
#define PHP_OEL_OAR_RES_NAME "oel op code array"
#define PHP_OEL_FUN_RES_NAME "oel function op code array"
#define PHP_OEL_NME_RES_NAME "oel method op code array"
#define PHP_OEL_AME_RES_NAME "oel abstract method op code array"

#define OEL_TYPE_UNSET                 0
#define OEL_TYPE_OAR_BASE              1
#define OEL_TYPE_OAR_FUNCTION          2
#define OEL_TYPE_OAR_METHOD            4
#define OEL_TYPE_OAR_AMETHOD           5
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

#define PHP_OEL_PREPARE_ADD(v)                                                     \
    /* Save state */                                                               \
    zend_bool         orig_in_compilation=     CG(in_compilation);                 \
    zend_op_array    *orig_op_array=           CG(active_op_array);                \
    zend_class_entry *orig_active_class_entry= CG(active_class_entry);             \
    uint              orig_lineno=             zend_get_compiled_lineno(TSRMLS_C); \
                                                                                   \
    /*  prepare enviroment */                                                      \
    CG(in_compilation)=     1;                                                     \
    CG(active_op_array)=    (v)->op_array;                                         \
    CG(active_class_entry)= (v)->cg_active_class_entry;                            \
    CG(zend_lineno)=        zend_get_executed_lineno(TSRMLS_C);                    \

#define PHP_OEL_PREPARE_ADD_END(v)                                     \
    /* Restore state */                                                \
    CG(zend_lineno)=            orig_lineno;                           \
    CG(active_class_entry)=     orig_active_class_entry;               \
    CG(active_op_array)=        orig_op_array;                         \
    CG(in_compilation)=         orig_in_compilation;                   \

#define PHP_OEL_FETCH_OP_ARRAY(ma_op_array, ma_arg)                                                                                 \
    (ma_op_array)= (php_oel_op_array *) zend_fetch_resource(&(ma_arg), -1, NULL, NULL, 1, le_oel_oar);                              \
    if (!(ma_op_array)) (ma_op_array)= (php_oel_op_array *) zend_fetch_resource(&(ma_arg), -1, NULL, NULL, 1, le_oel_fun);          \
    if (!(ma_op_array)) (ma_op_array)= (php_oel_op_array *) zend_fetch_resource(&(ma_arg), -1, NULL, NULL, 1, le_oel_nme);          \
    if (!(ma_op_array)) (ma_op_array)= (php_oel_op_array *) zend_fetch_resource(&(ma_arg), -1, NULL, NULL, 1, le_oel_ame);          \
    if (!(ma_op_array)) oel_compile_error(E_ERROR, "resource must be of type <%s>, <%s>, <%s> or <%s>", PHP_OEL_OAR_RES_NAME, PHP_OEL_FUN_RES_NAME, PHP_OEL_NME_RES_NAME, PHP_OEL_AME_RES_NAME); \

#define PHP_OEL_STACK_SERVICE_FUNCTIONS(v)                                                                                                                               \
static void oel_stack_push_##v(php_oel_op_array *res_op_array, znode *node TSRMLS_DC)        { return oel_stack_push(        #v, &(res_op_array->stack_##v), node TSRMLS_CC); } \
static znode *oel_stack_pop_##v(php_oel_op_array *res_op_array TSRMLS_DC)                    { return oel_stack_pop(         #v, &(res_op_array->stack_##v) TSRMLS_CC); }       \
static znode *oel_stack_top_##v(php_oel_op_array *res_op_array TSRMLS_DC)                    { return oel_stack_top(         #v, &(res_op_array->stack_##v) TSRMLS_CC); }       \
static int    oel_stack_top_get_type_##v(php_oel_op_array *res_op_array TSRMLS_DC)           { return oel_stack_top_get_type(#v, &(res_op_array->stack_##v) TSRMLS_CC); }       \
static void   oel_stack_top_set_type_##v(php_oel_op_array *res_op_array, int type TSRMLS_DC) { oel_stack_top_set_type(       #v, &(res_op_array->stack_##v), type TSRMLS_CC); } \
static int    oel_stack_size_##v(php_oel_op_array *res_op_array TSRMLS_DC)                   { return oel_stack_size(        #v, &(res_op_array->stack_##v) TSRMLS_CC); }       \
static void   oel_stack_destroy_##v(php_oel_op_array *res_op_array TSRMLS_DC)                { oel_stack_destroy(            #v, &(res_op_array->stack_##v) TSRMLS_CC); }       \

typedef struct _php_oel_znode {
    znode *ext_var;
    int    type;
    struct _php_oel_znode *next_var;
} php_oel_znode;

typedef struct _php_oel_op_array {
    zend_op_array *op_array;
    php_oel_znode *stack_extvar;
    php_oel_znode *stack_function;
    php_oel_znode *stack_operand;
    struct _php_oel_op_array *next;
    struct _php_oel_op_array *child;
    struct _php_oel_op_array *parent;
    int final;
    int type;

    zend_class_entry *cg_active_class_entry;
} php_oel_op_array;

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

extern zend_module_entry oel_entry;
#define phpext_oel_ptr &oel_entry

#define ZNODE_DUMP(v)                                                                                 \
  printf(", %s: ", #v);                                                                               \
  if (!v) {                                                                                           \
    printf("<NULL>");                                                                                 \
  } else {                                                                                            \
    switch (v->op_type) {                                                                             \
      case IS_CONST:                                                                                  \
      printf("<const(");                                                                              \
      switch (v->u.constant.type) {                                                                   \
        case IS_NULL:     printf("NULL)>"); break;                                                    \
        case IS_LONG:     printf("long): %li>", v->u.constant.value.lval); break;                     \
        case IS_DOUBLE:   printf("double): %f>", v->u.constant.value.dval); break;                    \
        case IS_BOOL:     printf("bool): %s>", (v->u.constant.value.lval ? "true" : "false")); break; \
        case IS_ARRAY:    printf("array)>"); break;                                                   \
        case IS_OBJECT:   printf("object)>"); break;                                                  \
        case IS_STRING:   printf("string): %s>", v->u.constant.value.str.val); break;                 \
        case IS_RESOURCE: printf("resource)>"); break;                                                \
        case IS_CONSTANT: printf("const)>"); break;                                                   \
        case IS_CONSTANT_ARRAY: printf("const array)>"); break;                                       \
      }                                                                                               \
      break;                                                                                          \
      case IS_TMP_VAR: printf("<temp variable>"); break;                                              \
      case IS_VAR:     printf("<variable>"); break;                                                   \
      case IS_UNUSED:  printf("<unused>"); break;                                                     \
      case IS_CV:      printf("<compiled variable>"); break;                                          \
      default: printf("<unknowen op_type %i>", v->op_type);                                           \
    }                                                                                                 \
  }                                                                                                   \

#endif
