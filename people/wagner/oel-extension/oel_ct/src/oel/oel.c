/* $Id$ */

#ifdef HAVE_CONFIG_H
  #include "config.h"
#endif

#include "php.h"
#include "php_globals.h"
#include "ext/standard/info.h"
#include "ext/standard/php_string.h"
#include "ext/standard/basic_functions.h"
#include "zend_exceptions.h"

#include "php.h"
#include "php_oel.h"

/* Global resource list id */
int le_oel_oar;
int le_oel_fun;
int le_oel_nme;
int le_oel_ame;

zend_class_entry *php_oel_ce_opcode;
zend_class_entry *php_oel_ce_opline;
zend_class_entry *php_oel_ce_znode;
zend_class_entry *php_oel_ce_znode_unused;
zend_class_entry *php_oel_ce_znode_constant;
zend_class_entry *php_oel_ce_znode_tmpvar;
zend_class_entry *php_oel_ce_znode_variable;
zend_class_entry *php_oel_ce_znode_compiledvar;

/* {{{ Compiler overrides */
extern ZEND_API zend_op_array *(*zend_compile_file)(zend_file_handle *file_handle, int type TSRMLS_DC);
static zend_op_array *(*oel_saved_zend_compile_file)(zend_file_handle *file_handle, int type TSRMLS_DC);
static zend_op_array *oel_compile_file(zend_file_handle *file_handle, int type TSRMLS_DC);
/* }}} */

static function_entry oel_functions[]= {

    PHP_FE(oel_new_op_array, NULL)
    PHP_FE(oel_finalize, NULL)
    PHP_FE(oel_execute, NULL)
    PHP_FE(oel_set_source_file, NULL)
    PHP_FE(oel_set_source_line, NULL)
    PHP_FE(oel_add_echo, NULL)
    PHP_FE(oel_add_return, NULL)
    PHP_FE(oel_add_free, NULL)
    PHP_FE(oel_add_break, NULL)
    PHP_FE(oel_add_continue, NULL)
    PHP_FE(oel_add_exit, NULL)
    PHP_FE(oel_add_include, NULL)
    PHP_FE(oel_add_include_once, NULL)
    PHP_FE(oel_add_require, NULL)
    PHP_FE(oel_add_require_once, NULL)
    PHP_FE(oel_add_eval, NULL)
    PHP_FE(oel_add_unset, NULL)

    PHP_FE(oel_add_begin_if, NULL)
    PHP_FE(oel_add_end_if, NULL)
    PHP_FE(oel_add_begin_elseif, NULL)
    PHP_FE(oel_add_end_elseif, NULL)
    PHP_FE(oel_add_end_else, NULL)
    PHP_FE(oel_add_begin_switch, NULL)
    PHP_FE(oel_add_end_switch, NULL)
    PHP_FE(oel_add_begin_case, NULL)
    PHP_FE(oel_add_end_case, NULL)
    PHP_FE(oel_add_begin_default, NULL)
    PHP_FE(oel_add_end_default, NULL)

    PHP_FE(oel_add_begin_while, NULL)
    PHP_FE(oel_add_begin_while_body, NULL)
    PHP_FE(oel_add_end_while, NULL)
    PHP_FE(oel_add_begin_dowhile, NULL)
    PHP_FE(oel_add_end_dowhile_body, NULL)
    PHP_FE(oel_add_end_dowhile, NULL)
    PHP_FE(oel_add_begin_foreach, NULL)
    PHP_FE(oel_add_begin_foreach_body, NULL)
    PHP_FE(oel_add_end_foreach, NULL)

    PHP_FE(oel_add_unary_op, NULL)
    PHP_FE(oel_add_incdec_op, NULL)
    PHP_FE(oel_add_binary_op, NULL)
    PHP_FE(oel_add_begin_tenary_op, NULL)
    PHP_FE(oel_add_end_tenary_op_true, NULL)
    PHP_FE(oel_add_end_tenary_op_false, NULL)
    PHP_FE(oel_add_begin_logical_op, NULL)
    PHP_FE(oel_add_end_logical_op, NULL)
    PHP_FE(oel_add_cast_op, NULL)
    PHP_FE(oel_add_assign, NULL)
    PHP_FE(oel_add_empty, NULL)
    PHP_FE(oel_add_isset, NULL)

    PHP_FE(oel_add_receive_arg, NULL)
    PHP_FE(oel_add_static_variable, NULL)
    PHP_FE(oel_add_begin_variable_parse, NULL)
    PHP_FE(oel_add_end_variable_parse, NULL)
    PHP_FE(oel_push_variable, NULL)
    PHP_FE(oel_push_variable_indirect, NULL)
    PHP_FE(oel_push_property, NULL)
    PHP_FE(oel_push_value, NULL)
    PHP_FE(oel_push_constant, NULL)

    PHP_FE(oel_new_function, NULL)
    PHP_FE(oel_new_method, NULL)
    PHP_FE(oel_new_abstract_method, NULL)
    PHP_FE(oel_add_call_function, NULL)
    PHP_FE(oel_add_call_function_name, NULL)
    PHP_FE(oel_add_call_method, NULL)
    PHP_FE(oel_add_call_method_static, NULL)
    PHP_FE(oel_add_call_method_name, NULL)
    PHP_FE(oel_add_call_method_name_static, NULL)
    PHP_FE(oel_add_new_object, NULL)

    PHP_FE(oel_add_begin_new_object, NULL)
    PHP_FE(oel_add_begin_method_call, NULL)
    PHP_FE(oel_add_begin_static_method_call, NULL)
    PHP_FE(oel_add_begin_function_call, NULL)
    PHP_FE(oel_add_pass_param, NULL)
    PHP_FE(oel_add_end_new_object, NULL)
    PHP_FE(oel_add_end_method_call, NULL)
    PHP_FE(oel_add_end_static_method_call, NULL)
    PHP_FE(oel_add_end_function_call, NULL)

    PHP_FE(oel_add_begin_class_declaration, NULL)
    PHP_FE(oel_add_end_class_declaration, NULL)
    PHP_FE(oel_add_begin_abstract_class_declaration, NULL)
    PHP_FE(oel_add_end_abstract_class_declaration, NULL)
    PHP_FE(oel_add_begin_interface_declaration, NULL)
    PHP_FE(oel_add_end_interface_declaration, NULL)
    PHP_FE(oel_add_parent_interface, NULL)
    PHP_FE(oel_add_implements_interface, NULL)
    PHP_FE(oel_add_declare_property, NULL)
    PHP_FE(oel_add_declare_class_constant, NULL)
    PHP_FE(oel_add_instanceof, NULL)
    PHP_FE(oel_add_clone, NULL)

    PHP_FE(oel_add_begin_array_init, NULL)
    PHP_FE(oel_add_end_array_init, NULL)
    PHP_FE(oel_add_array_init_element, NULL)
    PHP_FE(oel_add_array_init_key_element, NULL)
    PHP_FE(oel_push_dim, NULL)
    PHP_FE(oel_push_new_dim, NULL)
    PHP_FE(oel_add_begin_staticarray_init, NULL)
    PHP_FE(oel_add_end_staticarray_init, NULL)
    PHP_FE(oel_add_staticarray_init_element, NULL)
    PHP_FE(oel_add_staticarray_init_key_element, NULL)
    PHP_FE(oel_add_begin_list, NULL)
    PHP_FE(oel_add_end_list, NULL)
    PHP_FE(oel_add_begin_inner_list, NULL)
    PHP_FE(oel_add_end_inner_list, NULL)
    PHP_FE(oel_add_list_element, NULL)

    PHP_FE(oel_add_begin_tryblock, NULL)
    PHP_FE(oel_add_begin_catchblock, NULL)
    PHP_FE(oel_add_begin_firstcatch, NULL)
    PHP_FE(oel_add_end_firstcatch, NULL)
    PHP_FE(oel_add_begin_catch, NULL)
    PHP_FE(oel_add_end_catch, NULL)
    PHP_FE(oel_add_end_catchblock, NULL)
    PHP_FE(oel_add_throw, NULL)

    PHP_FE(oel_export_op_array, NULL)
    PHP_FE(oel_get_translation_array, NULL)
    PHP_FE(oel_get_zend_api_no, NULL)
    PHP_FE(oel_get_token_stack_types, NULL)
    
    PHP_FE(oel_read_header, NULL)
    PHP_FE(oel_read_op_array, NULL)
    PHP_FE(oel_eof, NULL)
    
    PHP_FE(oel_write_header, NULL)
    PHP_FE(oel_write_op_array, NULL)
    PHP_FE(oel_write_footer, NULL)

    {NULL, NULL, NULL}
};

static function_entry oel_ce_opcode_functions[]=            {{NULL, NULL, NULL}};
static function_entry oel_ce_opline_functions[]=            {{NULL, NULL, NULL}};
static function_entry oel_ce_znode_functions[]=             {{NULL, NULL, NULL}};
static function_entry oel_ce_znode_unused_functions[]=      {{NULL, NULL, NULL}};
static function_entry oel_ce_znode_constant_functions[]=    {{NULL, NULL, NULL}};
static function_entry oel_ce_znode_tmpvar_functions[]=      {{NULL, NULL, NULL}};
static function_entry oel_ce_znode_variable_functions[]=    {{NULL, NULL, NULL}};
static function_entry oel_ce_znode_compiledvar_functions[]= {{NULL, NULL, NULL}};

PHP_OEL_STACK_SERVICE_FUNCTIONS_HEADER(operand);
PHP_OEL_STACK_SERVICE_FUNCTIONS_HEADER(token);
PHP_OEL_STACK_SERVICE_FUNCTIONS_HEADER(extvar);

static php_oel_op_array *oel_fetch_op_array(zval* TSRMLS_DC);
static php_oel_saved_env *oel_env_prepare(php_oel_op_array* TSRMLS_DC);
static void oel_env_restore(php_oel_op_array*, php_oel_saved_env* TSRMLS_DC);
static int oel_stack_destroy_rec(int, php_oel_znode** TSRMLS_DC);
static int oel_stack_size(char*, php_oel_znode** TSRMLS_DC);
static int oel_stack_top_get_type(char*, php_oel_znode** TSRMLS_DC);
static int oel_token_isa(php_oel_op_array* TSRMLS_DC, int, ...);
static php_oel_op_array *oel_create_new_op_array(TSRMLS_D);
static php_oel_op_array *oel_init_child_op_array(php_oel_op_array* TSRMLS_DC);
static php_oel_op_array *oel_init_oel_op_array(TSRMLS_D);
static void oel_compile_error(int, const char*, ...);
static void oel_finalize_op_array(php_oel_op_array* TSRMLS_DC);
static void oel_stack_destroy(char*, php_oel_znode** TSRMLS_DC);
static void oel_stack_destroy_silent(php_oel_znode** TSRMLS_DC);
static void oel_stack_push(char*, php_oel_znode**, znode* TSRMLS_DC);
static void oel_stack_top_set_type(char*, php_oel_znode**, int TSRMLS_DC);
static void php_oel_destroy_op_array(php_oel_op_array* TSRMLS_DC);
static void php_oel_op_array_dtor(zend_rsrc_list_entry* TSRMLS_DC);
static znode *oel_create_extvar(php_oel_op_array* TSRMLS_DC);
static znode *oel_create_token(php_oel_op_array*, int TSRMLS_DC);
static znode *oel_stack_pop(char*, php_oel_znode** TSRMLS_DC);
static znode *oel_stack_top(char*, php_oel_znode** TSRMLS_DC);

zend_module_entry oel_module_entry= {
#if ZEND_MODULE_API_NO >= 20010901
    STANDARD_MODULE_HEADER,
#endif
    PHP_OEL_EXTNAME,
    oel_functions,
    PHP_MINIT(oel),
    NULL,
    NULL,
    NULL,
    PHP_MINFO(oel),
#if ZEND_MODULE_API_NO >= 20010901
    PHP_OEL_VERSION,
#endif
    STANDARD_MODULE_PROPERTIES
};

#ifdef COMPILE_DL_OEL
ZEND_GET_MODULE(oel)
#endif

/* init extension */
PHP_MINIT_FUNCTION(oel) {
    zend_class_entry
      tmp_ce_opcode,
      tmp_ce_opline,
      tmp_ce_znode,
      tmp_ce_znode_unused,
      tmp_ce_znode_constant,
      tmp_ce_znode_tmpvar,
      tmp_ce_znode_variable,
      tmp_ce_znode_compiledvar
    ;
    
    INIT_CLASS_ENTRY(tmp_ce_opcode,            PHP_OEL_CN_OPCODE,            oel_ce_opcode_functions);
    INIT_CLASS_ENTRY(tmp_ce_opline,            PHP_OEL_CN_OPLINE,            oel_ce_opline_functions);
    INIT_CLASS_ENTRY(tmp_ce_znode,             PHP_OEL_CN_ZNODE,             oel_ce_znode_functions);
    INIT_CLASS_ENTRY(tmp_ce_znode_unused,      PHP_OEL_CN_ZNODE_UNUSED,      oel_ce_znode_unused_functions);
    INIT_CLASS_ENTRY(tmp_ce_znode_constant,    PHP_OEL_CN_ZNODE_CONSTANT,    oel_ce_znode_constant_functions);
    INIT_CLASS_ENTRY(tmp_ce_znode_tmpvar,      PHP_OEL_CN_ZNODE_TMPVAR,      oel_ce_znode_tmpvar_functions);
    INIT_CLASS_ENTRY(tmp_ce_znode_variable,    PHP_OEL_CN_ZNODE_VARIABLE,    oel_ce_znode_variable_functions);
    INIT_CLASS_ENTRY(tmp_ce_znode_compiledvar, PHP_OEL_CN_ZNODE_COMPILEDVAR, oel_ce_znode_compiledvar_functions);

    php_oel_ce_opcode=            zend_register_internal_class(&tmp_ce_opcode TSRMLS_CC);
    php_oel_ce_opline=            zend_register_internal_class(&tmp_ce_opline TSRMLS_CC);
    php_oel_ce_znode=             zend_register_internal_class(&tmp_ce_znode TSRMLS_CC);
    php_oel_ce_znode_unused=      zend_register_internal_class(&tmp_ce_znode_unused TSRMLS_CC);
    php_oel_ce_znode_constant=    zend_register_internal_class(&tmp_ce_znode_constant TSRMLS_CC);
    php_oel_ce_znode_tmpvar=      zend_register_internal_class(&tmp_ce_znode_tmpvar TSRMLS_CC);
    php_oel_ce_znode_variable=    zend_register_internal_class(&tmp_ce_znode_variable TSRMLS_CC);
    php_oel_ce_znode_compiledvar= zend_register_internal_class(&tmp_ce_znode_compiledvar TSRMLS_CC);

    php_oel_ce_znode_unused->parent=      php_oel_ce_znode;
    php_oel_ce_znode_constant->parent=    php_oel_ce_znode;
    php_oel_ce_znode_tmpvar->parent=      php_oel_ce_znode;
    php_oel_ce_znode_variable->parent=    php_oel_ce_znode;
    php_oel_ce_znode_compiledvar->parent= php_oel_ce_znode;

    le_oel_oar= zend_register_list_destructors_ex(php_oel_op_array_dtor, NULL, PHP_OEL_OAR_RES_NAME, module_number);
    le_oel_fun= zend_register_list_destructors_ex(NULL, NULL, PHP_OEL_FUN_RES_NAME, module_number);
    le_oel_nme= zend_register_list_destructors_ex(NULL, NULL, PHP_OEL_NME_RES_NAME, module_number);
    le_oel_ame= zend_register_list_destructors_ex(NULL, NULL, PHP_OEL_AME_RES_NAME, module_number);

    REGISTER_LONG_CONSTANT("OEL_ACC_PRIVATE",                   ZEND_ACC_PRIVATE,         CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_ACC_PROTECTED",                 ZEND_ACC_PROTECTED,       CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_ACC_PUBLIC",                    ZEND_ACC_PUBLIC,          CONST_CS | CONST_PERSISTENT);

    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_ASSIGN_ADD",          ZEND_ASSIGN_ADD,          CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_ASSIGN_SUB",          ZEND_ASSIGN_SUB,          CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_ASSIGN_MUL",          ZEND_ASSIGN_MUL,          CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_ASSIGN_DIV",          ZEND_ASSIGN_DIV,          CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_ASSIGN_CONCAT",       ZEND_ASSIGN_CONCAT,       CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_ASSIGN_MOD",          ZEND_ASSIGN_MOD,          CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_ASSIGN_BW_AND",       ZEND_ASSIGN_BW_AND,       CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_ASSIGN_BW_OR",        ZEND_ASSIGN_BW_OR,        CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_ASSIGN_BW_XOR",       ZEND_ASSIGN_BW_XOR,       CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_ASSIGN_SHIFTL",       ZEND_ASSIGN_SL,           CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_ASSIGN_SHIFTR",       ZEND_ASSIGN_SR,           CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_BW_OR",               ZEND_BW_OR,               CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_BW_AND",              ZEND_BW_AND,              CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_BW_XOR",              ZEND_BW_XOR,              CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_CONCAT",              ZEND_CONCAT,              CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_ADD",                 ZEND_ADD,                 CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_SUB",                 ZEND_SUB,                 CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_MUL",                 ZEND_MUL,                 CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_DIV",                 ZEND_DIV,                 CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_MOD",                 ZEND_MOD,                 CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_SHIFTL",              ZEND_SL,                  CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_SHIFTR",              ZEND_SR,                  CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_IS_IDENTICAL",        ZEND_IS_IDENTICAL,        CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_IS_NOT_IDENTICAL",    ZEND_IS_NOT_IDENTICAL,    CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_IS_EQUAL",            ZEND_IS_EQUAL,            CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_IS_NOT_EQUAL",        ZEND_IS_NOT_EQUAL,        CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_IS_SMALLER",          ZEND_IS_SMALLER,          CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_IS_SMALLER_OR_EQUAL", ZEND_IS_SMALLER_OR_EQUAL, CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_BINARY_OP_BOOL_XOR",            ZEND_BOOL_XOR,            CONST_CS | CONST_PERSISTENT);

    REGISTER_LONG_CONSTANT("OEL_UNARY_OP_BOOL_NOT",             ZEND_BOOL_NOT,            CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_UNARY_OP_BW_NOT",               ZEND_BW_NOT,              CONST_CS | CONST_PERSISTENT);

    REGISTER_LONG_CONSTANT("OEL_OP_POST_INC",                   ZEND_POST_INC,            CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_POST_DEC",                   ZEND_POST_DEC,            CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_PRE_INC",                    ZEND_PRE_INC,             CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_PRE_DEC",                    ZEND_PRE_DEC,             CONST_CS | CONST_PERSISTENT);

    REGISTER_LONG_CONSTANT("OEL_OP_BOOL_AND",                   ZEND_JMPZ_EX,             CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_BOOL_OR",                    ZEND_JMPNZ_EX,            CONST_CS | CONST_PERSISTENT);

    REGISTER_LONG_CONSTANT("OEL_OP_TO_INT",                     IS_LONG,                  CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_TO_DOUBLE",                  IS_DOUBLE,                CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_TO_STRING",                  IS_STRING,                CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_TO_ARRAY",                   IS_ARRAY,                 CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_TO_OBJECT",                  IS_OBJECT,                CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_TO_BOOL",                    IS_BOOL,                  CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_TO_UNSET",                   IS_NULL,                  CONST_CS | CONST_PERSISTENT);

    /* Register us with the Zend compiler */
    oel_saved_zend_compile_file = zend_compile_file;
    zend_compile_file = oel_compile_file;

    return SUCCESS;
}

PHP_MINFO_FUNCTION(oel) {
  php_info_print_table_start();
  php_info_print_table_row(2, "OEL Extension support", "enabled");
  php_info_print_table_row(2, "OEL version", PHP_OEL_VERSION);
  php_info_print_table_end();
}

/* stack functions for stacks */
PHP_OEL_STACK_SERVICE_FUNCTIONS(operand);
PHP_OEL_STACK_SERVICE_FUNCTIONS(token);
PHP_OEL_STACK_SERVICE_FUNCTIONS(extvar);

static php_oel_op_array *oel_fetch_op_array(zval *arg_op_array TSRMLS_DC) {
    php_oel_op_array *oel_op_array= (php_oel_op_array *) zend_fetch_resource(&arg_op_array TSRMLS_CC, -1, "", NULL, 4, le_oel_oar, le_oel_fun, le_oel_nme, le_oel_ame);
    if (!oel_op_array) oel_compile_error(E_ERROR, "resource must be of type <%s>, <%s>, <%s> or <%s>", PHP_OEL_OAR_RES_NAME, PHP_OEL_FUN_RES_NAME, PHP_OEL_NME_RES_NAME, PHP_OEL_AME_RES_NAME);
    return oel_op_array;
}

/* enviroment */
static php_oel_saved_env *oel_env_prepare(php_oel_op_array *res_op_array TSRMLS_DC) {
    php_oel_saved_env *env= (php_oel_saved_env *) emalloc(sizeof(php_oel_saved_env));
    /* Save enviroment */
    env->zend_lineno= zend_get_compiled_lineno(TSRMLS_C);
    PHP_OEL_SAFE_CG(res_op_array, env, active_class_entry);
    PHP_OEL_SAFE_CG(res_op_array, env, active_op_array);
    PHP_OEL_SAFE_CG(res_op_array, env, in_compilation);
    PHP_OEL_SAFE_CG(res_op_array, env, implementing_class);
    PHP_OEL_SAFE_CG(res_op_array, env, interactive);
    PHP_OEL_SAFE_CG(res_op_array, env, bp_stack);
    PHP_OEL_SAFE_CG(res_op_array, env, switch_cond_stack);
    PHP_OEL_SAFE_CG(res_op_array, env, foreach_copy_stack);
    PHP_OEL_SAFE_CG(res_op_array, env, list_stack);
    PHP_OEL_SAFE_CG(res_op_array, env, list_llist);
    PHP_OEL_SAFE_CG(res_op_array, env, dimension_llist);
    PHP_OEL_SAFE_CG(res_op_array, env, function_call_stack);
    PHP_OEL_SAFE_CG(res_op_array, env, function_table);
    PHP_OEL_SAFE_CG(res_op_array, env, class_table);

    /*  prepare enviroment */
    CG(in_compilation)= 1;
    CG(zend_lineno)= res_op_array->is_custom_source ? res_op_array->lineno : zend_get_executed_lineno(TSRMLS_C);
    PHP_OEL_SET_CG(res_op_array, env, active_op_array);
    PHP_OEL_SET_CG(res_op_array, env, active_class_entry);
    PHP_OEL_SET_CG(res_op_array, env, implementing_class);
    PHP_OEL_SET_CG(res_op_array, env, interactive);
    PHP_OEL_SET_CG(res_op_array, env, bp_stack);
    PHP_OEL_SET_CG(res_op_array, env, switch_cond_stack);
    PHP_OEL_SET_CG(res_op_array, env, foreach_copy_stack);
    PHP_OEL_SET_CG(res_op_array, env, list_stack);
    PHP_OEL_SET_CG(res_op_array, env, list_llist);
    PHP_OEL_SET_CG(res_op_array, env, dimension_llist);
    PHP_OEL_SET_CG(res_op_array, env, function_call_stack);
    PHP_OEL_SET_CG(res_op_array, env, function_table);
    PHP_OEL_SET_CG(res_op_array, env, class_table);
    return env;
}

static void oel_env_restore(php_oel_op_array *res_op_array, php_oel_saved_env *env TSRMLS_DC) {
    PHP_OEL_RESAFE_CG(res_op_array, env, implementing_class);
    PHP_OEL_RESAFE_CG(res_op_array, env, interactive);
    PHP_OEL_RESAFE_CG(res_op_array, env, bp_stack);
    PHP_OEL_RESAFE_CG(res_op_array, env, switch_cond_stack);
    PHP_OEL_RESAFE_CG(res_op_array, env, foreach_copy_stack);
    PHP_OEL_RESAFE_CG(res_op_array, env, list_stack);
    PHP_OEL_RESAFE_CG(res_op_array, env, list_llist);
    PHP_OEL_RESAFE_CG(res_op_array, env, dimension_llist);
    PHP_OEL_RESAFE_CG(res_op_array, env, function_call_stack);
    PHP_OEL_RESAFE_CG(res_op_array, env, function_table);
    PHP_OEL_RESAFE_CG(res_op_array, env, class_table);

    PHP_OEL_RESET_CG(res_op_array, env, class_table);
    PHP_OEL_RESET_CG(res_op_array, env, function_table);
    PHP_OEL_RESET_CG(res_op_array, env, function_call_stack);
    PHP_OEL_RESET_CG(res_op_array, env, dimension_llist);
    PHP_OEL_RESET_CG(res_op_array, env, list_llist);
    PHP_OEL_RESET_CG(res_op_array, env, list_stack);
    PHP_OEL_RESET_CG(res_op_array, env, foreach_copy_stack);
    PHP_OEL_RESET_CG(res_op_array, env, switch_cond_stack);
    PHP_OEL_RESET_CG(res_op_array, env, bp_stack);
    PHP_OEL_RESET_CG(res_op_array, env, interactive);
    PHP_OEL_RESET_CG(res_op_array, env, implementing_class);
    PHP_OEL_RESET_CG(res_op_array, env, active_class_entry);
    PHP_OEL_RESET_CG(res_op_array, env, active_op_array);
    PHP_OEL_RESET_CG(res_op_array, env, in_compilation);
    CG(zend_lineno)= env->zend_lineno;
    efree(env);
}

/* common stack functions */
static void oel_stack_push(char *stack_name, php_oel_znode **stack_head, znode *node TSRMLS_DC) {
    php_oel_znode *oel_znode;
    oel_znode= (php_oel_znode *) emalloc(sizeof(php_oel_znode));
    oel_znode->ext_var= node;
    oel_znode->type= OEL_TYPE_UNSET;
    oel_znode->next_var= *stack_head;
    *stack_head= oel_znode;
}
static znode *oel_stack_pop(char *stack_name, php_oel_znode **stack_head TSRMLS_DC) {
    znode *node;
    php_oel_znode *oel_znode;
    if (!*stack_head) oel_compile_error(E_ERROR, "try to pop empty stack (%s)", stack_name);
    node= oel_stack_top(stack_name, stack_head TSRMLS_CC);
    oel_znode= *stack_head;
    *stack_head= oel_znode->next_var;
    efree(oel_znode);
    return node;
}
static znode *oel_stack_top(char *stack_name, php_oel_znode **stack_head TSRMLS_DC) {
    if (!*stack_head) oel_compile_error(E_ERROR, "try to top empty stack (%s)", stack_name);
    return (*stack_head)->ext_var;
}
static int oel_stack_top_get_type(char *stack_name, php_oel_znode **stack_head TSRMLS_DC) {
    if (!*stack_head) oel_compile_error(E_ERROR, "try to get type from empty stack (%s)", stack_name);
    return (*stack_head)->type;
}
static int oel_stack_size(char *stack_name, php_oel_znode **stack_head TSRMLS_DC) {
    int size= 0;
    php_oel_znode *curr_node= *stack_head;
    while (NULL != curr_node) { size++; curr_node= curr_node->next_var; }
    return size;
}
static void oel_stack_top_set_type(char *stack_name, php_oel_znode **stack_head, int type TSRMLS_DC) {
    if (!*stack_head) oel_compile_error(E_ERROR, "try to set type to empty stack (%s)", stack_name);
    (*stack_head)->type= type;
}
static int oel_stack_destroy_rec(int counter, php_oel_znode **stack_head TSRMLS_DC) {
    if ((*stack_head)->next_var) counter= oel_stack_destroy_rec(counter, &((*stack_head)->next_var) TSRMLS_CC);
    efree((*stack_head));
    return ++counter;
}
static void oel_stack_destroy(char *stack_name, php_oel_znode **stack_head TSRMLS_DC) {
    int i= 0; if (*stack_head) i= oel_stack_destroy_rec(i, stack_head TSRMLS_CC);
    if (i > 0) zend_error(E_ERROR, "%i elements left on stack(%s)", i, stack_name);
}
/* destroy stack silently */
static void oel_stack_destroy_silent(php_oel_znode **stack_head TSRMLS_DC) {
    if ((*stack_head)->next_var) oel_stack_destroy_silent(&((*stack_head)->next_var) TSRMLS_CC);
    efree((*stack_head)->ext_var); efree((*stack_head));
}

/* create a function stack token for an op_array */
static znode *oel_create_token(php_oel_op_array *res_op_array, int type TSRMLS_DC) {
    znode *token= oel_create_extvar(res_op_array TSRMLS_CC);
    oel_stack_push_token(res_op_array, token TSRMLS_CC);
    oel_stack_top_set_type_token(res_op_array, type TSRMLS_CC);
    ZVAL_LONG(&(token->u.constant), oel_stack_size_token(res_op_array TSRMLS_CC));
    return token;
}
/* test the top token to be of a cetain type */
static int oel_token_isa(php_oel_op_array *res_op_array TSRMLS_DC, int type, ...) {
    va_list ap;
    int token_type;
    int i, result= 0;

    if (oel_stack_size_token(res_op_array TSRMLS_CC) < 1) return 0;
    token_type=  oel_stack_top_get_type_token(res_op_array TSRMLS_CC);
    va_start(ap, type);
    for (i= 0; i < type; i++) {
      result= (token_type == va_arg(ap, int)) || result;
    }
    va_end(ap);
    return result;
}
/* create a new znode for an op_array */
static znode *oel_create_extvar(php_oel_op_array *res_op_array TSRMLS_DC) {
    znode *node= (znode *) emalloc(sizeof(znode));
    memset(node, '\0', sizeof(znode));
    oel_stack_push_extvar(res_op_array, node TSRMLS_CC);
    node->op_type= IS_CONST;
    Z_SET_REFCOUNT(node->u.constant, 1);
    Z_SET_ISREF_TO(node->u.constant, 0);
    node->u.EA.type= 0;
    return node;
}

/* create a new op array resource */
static php_oel_op_array *oel_init_oel_op_array(TSRMLS_D) {
    php_oel_op_array *res_op_array= (php_oel_op_array *) emalloc(sizeof(php_oel_op_array));
    memset(res_op_array, '\0', sizeof(php_oel_op_array));
    res_op_array->final= 0;
    res_op_array->type=  OEL_TYPE_OAR_BASE;
    res_op_array->oel_cg.interactive= CG(interactive);
    zend_stack_init(&(res_op_array->oel_cg.foreach_copy_stack));
    zend_stack_init(&(res_op_array->oel_cg.switch_cond_stack));
    zend_stack_init(&(res_op_array->oel_cg.bp_stack));
    zend_stack_init(&(res_op_array->oel_cg.list_stack));
    zend_llist_init(&(res_op_array->oel_cg.list_llist), sizeof(list_llist_element), NULL, 0);
    zend_llist_init(&(res_op_array->oel_cg.dimension_llist), sizeof(int), NULL, 0);
    zend_stack_init(&(res_op_array->oel_cg.function_call_stack));
    return res_op_array;
}

/* create a new child op array resource */
static php_oel_op_array *oel_init_child_op_array(php_oel_op_array *parent TSRMLS_DC) {
    php_oel_op_array *func_op_array=          oel_init_oel_op_array(TSRMLS_C);
    func_op_array->oel_cg.active_class_entry= parent->oel_cg.active_class_entry;
    func_op_array->oel_cg.implementing_class= parent->oel_cg.implementing_class;
    func_op_array->oel_cg.interactive=        parent->oel_cg.interactive;
    func_op_array->oel_cg.function_table=     parent->oel_cg.function_table;
    func_op_array->oel_cg.class_table=        parent->oel_cg.class_table;
    func_op_array->parent=                    parent;
    func_op_array->next=                      parent->child;
    parent->child=                            func_op_array;
    return func_op_array;
}

/* create a new op array */
static php_oel_op_array *oel_create_new_op_array(TSRMLS_D) {
    char *orig_compiled_filename;
    char *new_compiled_filename;
    php_oel_op_array *res_op_array;
    zend_bool orig_interactive;

    res_op_array= oel_init_oel_op_array(TSRMLS_C);
    res_op_array->oel_cg.active_op_array=(zend_op_array *) emalloc(sizeof(zend_op_array));
    memset(res_op_array->oel_cg.active_op_array, '\0', sizeof(zend_op_array));

    res_op_array->oel_cg.function_table = (HashTable *) malloc(sizeof(HashTable));
    zend_hash_init_ex(res_op_array->oel_cg.function_table, 100, NULL, ZEND_FUNCTION_DTOR, 1, 0);

    res_op_array->oel_cg.class_table = (HashTable *) malloc(sizeof(HashTable));
    zend_hash_init_ex(res_op_array->oel_cg.class_table, 10, NULL, ZEND_CLASS_DTOR, 1, 0);

    res_op_array->oel_cg.active_op_array->filename= NULL;
    new_compiled_filename= (char *) emalloc(sizeof(PHP_OEL_OAR_RES_NAME) + sizeof(" (defined in )") + strlen(EG(active_op_array)->filename));
    sprintf(new_compiled_filename, "%s (defined in %s)", PHP_OEL_OAR_RES_NAME, EG(active_op_array)->filename);

    orig_interactive= CG(interactive);
    orig_compiled_filename= zend_get_compiled_filename(TSRMLS_C);

    zend_set_compiled_filename(new_compiled_filename TSRMLS_CC);
    CG(interactive)= 0;
    init_op_array(res_op_array->oel_cg.active_op_array, ZEND_EVAL_CODE, INITIAL_OP_ARRAY_SIZE TSRMLS_CC);
    CG(interactive)= orig_interactive;
    zend_restore_compiled_filename(orig_compiled_filename TSRMLS_CC);
    efree(new_compiled_filename);
    return res_op_array;
}

/* prepare for execution */
static void oel_finalize_op_array(php_oel_op_array *res_op_array TSRMLS_DC) {
    php_oel_saved_env *env;
    znode *func_token;
    znode *func_flags;
    znode *func_name;
    znode *body;

    if (res_op_array->next)  oel_finalize_op_array(res_op_array->next TSRMLS_CC);
    if (res_op_array->child) oel_finalize_op_array(res_op_array->child TSRMLS_CC);
    if (!res_op_array->final) {
        if(res_op_array->type == OEL_TYPE_OAR_BASE) {
            env= oel_env_prepare(res_op_array TSRMLS_CC);
            zend_do_return(NULL, 0 TSRMLS_CC);
            zend_do_handle_exception(TSRMLS_C);
            oel_env_restore(res_op_array, env TSRMLS_CC);
            pass_two(res_op_array->oel_cg.active_op_array TSRMLS_CC);
        } else if (res_op_array->type == OEL_TYPE_OAR_FUNCTION) {
            if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_OAR_FUNCTION)) oel_compile_error(E_ERROR, "opend token is not of type function");
            env= oel_env_prepare(res_op_array TSRMLS_CC);
            zend_do_end_function_declaration(oel_stack_pop_token(res_op_array TSRMLS_CC) TSRMLS_CC);
            oel_env_restore(res_op_array, env TSRMLS_CC);
        } else if (res_op_array->type == OEL_TYPE_OAR_METHOD) {
            if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_OAR_METHOD)) oel_compile_error(E_ERROR, "opend token is not of type method");
            func_token= oel_stack_pop_token(res_op_array TSRMLS_CC);
            func_flags= oel_stack_pop_token(res_op_array TSRMLS_CC);
            func_name=  oel_stack_pop_token(res_op_array TSRMLS_CC);

            body= oel_create_extvar(res_op_array TSRMLS_CC);
            ZVAL_LONG(&body->u.constant, (ZEND_ACC_INTERFACE & res_op_array->oel_cg.active_class_entry->ce_flags) ? ZEND_ACC_ABSTRACT : 0);

            env= oel_env_prepare(res_op_array TSRMLS_CC);
            zend_do_abstract_method(func_name, func_flags, body TSRMLS_CC);
            zend_do_end_function_declaration(func_token TSRMLS_CC);
            oel_env_restore(res_op_array, env TSRMLS_CC);
        } else if (res_op_array->type == OEL_TYPE_OAR_AMETHOD) {
            if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_OAR_AMETHOD)) oel_compile_error(E_ERROR, "opend token is not of type abstract method");
            func_token= oel_stack_pop_token(res_op_array TSRMLS_CC);
            func_flags= oel_stack_pop_token(res_op_array TSRMLS_CC);
            func_name=  oel_stack_pop_token(res_op_array TSRMLS_CC);

            body=  oel_create_extvar(res_op_array TSRMLS_CC);
            ZVAL_LONG(&body->u.constant, ZEND_ACC_ABSTRACT);

            env= oel_env_prepare(res_op_array TSRMLS_CC);
            zend_do_abstract_method(func_name, func_flags, body TSRMLS_CC);
            zend_do_end_function_declaration(func_token TSRMLS_CC);
            oel_env_restore(res_op_array, env TSRMLS_CC);
        } else {
            oel_compile_error(E_ERROR, "opend token is not of unknown");
        }
        res_op_array->final= 1;
    }
}


/* destroy op array resource */
static void php_oel_op_array_dtor(zend_rsrc_list_entry *rsrc TSRMLS_DC) {
    php_oel_op_array *res_op_array= (php_oel_op_array *) rsrc->ptr;
    if (res_op_array) php_oel_destroy_op_array(res_op_array TSRMLS_CC);
}

/* destroy op array */
static void php_oel_destroy_op_array(php_oel_op_array *res_op_array TSRMLS_DC) {
    if (res_op_array->next)  { php_oel_destroy_op_array(res_op_array->next  TSRMLS_CC) ; res_op_array->next=  NULL; }
    if (res_op_array->child) { php_oel_destroy_op_array(res_op_array->child TSRMLS_CC); res_op_array->child= NULL; }

    if (res_op_array->stack_extvar) oel_stack_destroy_silent(&(res_op_array->stack_extvar) TSRMLS_CC);
    oel_stack_destroy_token(res_op_array TSRMLS_CC);
    oel_stack_destroy_operand(res_op_array TSRMLS_CC);
    if (res_op_array->oel_cg.active_op_array) {
        zend_stack_destroy(&(res_op_array->oel_cg.bp_stack));
        zend_stack_destroy(&(res_op_array->oel_cg.switch_cond_stack));
        zend_stack_destroy(&(res_op_array->oel_cg.foreach_copy_stack));
        zend_stack_destroy(&(res_op_array->oel_cg.list_stack));
        zend_llist_destroy(&(res_op_array->oel_cg.list_llist));
        zend_llist_destroy(&(res_op_array->oel_cg.dimension_llist));
        zend_stack_destroy(&(res_op_array->oel_cg.function_call_stack));
        /* function and method op arrays are cleared by their parents */
        if (res_op_array->type == OEL_TYPE_OAR_BASE) {
            destroy_op_array(res_op_array->oel_cg.active_op_array TSRMLS_CC);
            efree(res_op_array->oel_cg.active_op_array);
        }
    }
    efree(res_op_array);
}

static void oel_compile_error(int type, const char *format, ...) {
    char *orig_filename;
    uint  orig_lineno;
    va_list arglist;
    zend_bool orig_in_compilation;
    TSRMLS_FETCH();

    va_start(arglist, format);
    orig_filename= zend_get_compiled_filename(TSRMLS_C);
    orig_lineno=   zend_get_compiled_lineno(TSRMLS_C);

    orig_in_compilation= CG(in_compilation);
    CG(compiled_filename)= zend_get_executed_filename(TSRMLS_C);
    CG(zend_lineno)=       zend_get_executed_lineno(TSRMLS_C);
    CG(in_compilation)=    1;
    zend_error(type, format, arglist);
    CG(in_compilation)=    orig_in_compilation;
    CG(zend_lineno)=       orig_lineno;
    CG(compiled_filename)= orig_filename;
    va_end(arglist);
}

/**
 * -------------- userland functions -------------------
 */
#include "oel_core.c"
#include "oel_array.c"
#include "oel_class.c"
#include "oel_control.c"
#include "oel_loop.c"
#include "oel_operands.c"
#include "oel_operation.c"
#include "oel_procedure.c"
#include "oel_trycatch.c"
#include "oel_debug.c"
#include "oel_io.c"
#include "oel_compile.c"
