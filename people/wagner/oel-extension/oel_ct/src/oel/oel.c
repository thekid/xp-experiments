/* $Id$ */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_oel.h"

/* Global resource list id */
int le_oel_oar;
int le_oel_fun;
int le_oel_nme;
int le_oel_ame;

static function_entry oel_functions[]= {

    PHP_FE(oel_new_op_array, NULL)
    PHP_FE(oel_finalize, NULL)
    PHP_FE(oel_execute, NULL)
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
    PHP_FE(oel_add_begin_tinary_op, NULL)
    PHP_FE(oel_add_tinary_op_true, NULL)
    PHP_FE(oel_add_tinary_op_false, NULL)
    PHP_FE(oel_add_begin_logical_op, NULL)
    PHP_FE(oel_add_end_logical_op, NULL)
    PHP_FE(oel_add_cast_op, NULL)
    PHP_FE(oel_add_assign, NULL)
    PHP_FE(oel_add_empty, NULL)
    PHP_FE(oel_add_isset, NULL)

    PHP_FE(oel_add_receive_arg, NULL)
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

    PHP_FE(oel_add_begin_class_declaration, NULL)
    PHP_FE(oel_add_end_class_declaration, NULL)
    PHP_FE(oel_add_begin_abstract_class_declaration, NULL)
    PHP_FE(oel_add_end_abstract_class_declaration, NULL)
    PHP_FE(oel_add_begin_interface_declaration, NULL)
    PHP_FE(oel_add_end_interface_declaration, NULL)
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

    {NULL, NULL, NULL}
};

static int oel_stack_destroy_rec(int counter, php_oel_znode **stack_head TSRMLS_DC);
static int oel_stack_size(char *stack_name, php_oel_znode **stack_head TSRMLS_DC);
static int oel_stack_top_get_type(char *stack_name, php_oel_znode **stack_head TSRMLS_DC);
static int oel_token_isa(php_oel_op_array *res_op_array TSRMLS_DC, int type, ...);
static php_oel_op_array *oel_create_new_op_array(TSRMLS_DC);
static php_oel_op_array *oel_init_child_op_array(php_oel_op_array *parent TSRMLS_DC);
static php_oel_op_array *oel_init_oel_op_array(TSRMLS_DC);
static void oel_compile_error(int type, const char *format, ...);
static void oel_finalize_op_array(php_oel_op_array* res_op_array TSRMLS_DC);
static void oel_stack_destroy(char *stack_name, php_oel_znode **stack_head TSRMLS_DC);
static void oel_stack_destroy_silent(php_oel_znode **stack_head TSRMLS_DC);
static void oel_stack_push(char *stack_name, php_oel_znode **stack_head, znode *node TSRMLS_DC);
static void oel_stack_top_set_type(char *stack_name, php_oel_znode **stack_head, int type TSRMLS_DC);
static void php_oel_destroy_op_array(php_oel_op_array *res_op_array TSRMLS_DC);
static void php_oel_op_array_dtor(zend_rsrc_list_entry *rsrc TSRMLS_DC);
static znode *oel_create_extvar(php_oel_op_array *res_op_array TSRMLS_DC);
static znode *oel_create_token(php_oel_op_array *res_op_array, int type TSRMLS_DC);
static znode *oel_stack_pop(char *stack_name, php_oel_znode **stack_head TSRMLS_DC);
static znode *oel_stack_top(char *stack_name, php_oel_znode **stack_head TSRMLS_DC);

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
    NULL,
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
    le_oel_oar= zend_register_list_destructors_ex(php_oel_op_array_dtor, NULL, PHP_OEL_OAR_RES_NAME, module_number);
    le_oel_fun= zend_register_list_destructors_ex(NULL, NULL, PHP_OEL_FUN_RES_NAME, module_number);
    le_oel_nme= zend_register_list_destructors_ex(NULL, NULL, PHP_OEL_NME_RES_NAME, module_number);
    le_oel_ame= zend_register_list_destructors_ex(NULL, NULL, PHP_OEL_AME_RES_NAME, module_number);

    REGISTER_LONG_CONSTANT("OEL_ACC_PRIVATE",   ZEND_ACC_PRIVATE,   CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_ACC_PROTECTED", ZEND_ACC_PROTECTED, CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_ACC_PUBLIC",    ZEND_ACC_PUBLIC,    CONST_CS | CONST_PERSISTENT);

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

    REGISTER_LONG_CONSTANT("OEL_OP_TO_INT",                     IS_LONG,                   CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_TO_DOUBLE",                  IS_DOUBLE,                 CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_TO_STRING",                  IS_STRING,                 CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_TO_ARRAY",                   IS_ARRAY,                  CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_TO_OBJECT",                  IS_OBJECT,                 CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_TO_BOOL",                    IS_BOOL,                   CONST_CS | CONST_PERSISTENT);
    REGISTER_LONG_CONSTANT("OEL_OP_TO_UNSET",                   IS_NULL,                   CONST_CS | CONST_PERSISTENT);
    return SUCCESS;
}

/* stack functions for stacks */
PHP_OEL_STACK_SERVICE_FUNCTIONS(operand);
PHP_OEL_STACK_SERVICE_FUNCTIONS(function);
PHP_OEL_STACK_SERVICE_FUNCTIONS(extvar);

/* common stack functions */
static void oel_stack_push(char *stack_name, php_oel_znode **stack_head, znode *node TSRMLS_DC) {
    php_oel_znode *oel_znode= (php_oel_znode *) emalloc(sizeof(php_oel_znode));
    oel_znode->ext_var= node;
    oel_znode->type= OEL_TYPE_UNSET;
    oel_znode->next_var= *stack_head;
    *stack_head= oel_znode;
}
static znode *oel_stack_pop(char *stack_name, php_oel_znode **stack_head TSRMLS_DC) {
    if (!*stack_head) oel_compile_error(E_ERROR, "try to pop empty stack (%s)", stack_name);
    znode *node= oel_stack_top(stack_name, stack_head TSRMLS_CC);
    php_oel_znode *oel_znode= *stack_head;
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
    oel_stack_push_function(res_op_array, token TSRMLS_CC);
    oel_stack_top_set_type_function(res_op_array, type TSRMLS_CC);
    ZVAL_LONG(&(token->u.constant), oel_stack_size_function(res_op_array TSRMLS_CC));
    return token;
}
/* test the top function  token to be of a cetain type */
static int oel_token_isa(php_oel_op_array *res_op_array TSRMLS_DC, int type, ...) {
    if (oel_stack_size_function(res_op_array TSRMLS_CC) < 1) return 0;

    va_list ap;
    int token_type=  oel_stack_top_get_type_function(res_op_array TSRMLS_CC);
    int i, result= 0;
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
    oel_stack_push_extvar(res_op_array, node TSRMLS_CC);
    node->op_type= IS_CONST;
    node->u.constant.refcount= 1;
    node->u.constant.is_ref= 0;
    return node;
}

/* create a new op array resource */
static php_oel_op_array *oel_init_oel_op_array(TSRMLS_DC) {
    php_oel_op_array *res_op_array= (php_oel_op_array *) emalloc(sizeof(php_oel_op_array));
    res_op_array->op_array=              NULL;
    res_op_array->stack_extvar=          NULL;
    res_op_array->stack_function=        NULL;
    res_op_array->stack_operand=         NULL;
    res_op_array->next=                  NULL;
    res_op_array->child=                 NULL;
    res_op_array->parent=                NULL;
    res_op_array->final=                 0;
    res_op_array->type=                  OEL_TYPE_OAR_BASE;
    res_op_array->cg_active_class_entry= NULL;
    return res_op_array;
}

/* create a new child op array resource */
static php_oel_op_array *oel_init_child_op_array(php_oel_op_array *parent TSRMLS_DC) {
    php_oel_op_array *func_op_array=      oel_init_oel_op_array(TSRMLS_CC);
    func_op_array->cg_active_class_entry= parent->cg_active_class_entry;
    func_op_array->parent=                parent;
    func_op_array->next=                  parent->child;
    parent->child=                        func_op_array;
    return func_op_array;
}

/* create a new op array */
static php_oel_op_array *oel_create_new_op_array(TSRMLS_DC) {
    php_oel_op_array *res_op_array= oel_init_oel_op_array(TSRMLS_CC);
    res_op_array->op_array=(zend_op_array *) emalloc(sizeof(zend_op_array));
    res_op_array->op_array->filename= "";
    zend_bool orig_interactive= CG(interactive);
    char* orig_compiled_filename= CG(compiled_filename);
    CG(compiled_filename)= (char *) emalloc(sizeof(PHP_OEL_OAR_RES_NAME) + sizeof(" (defined in )") + strlen(EG(active_op_array)->filename));
    strcpy(CG(compiled_filename), PHP_OEL_OAR_RES_NAME);
    strcpy(CG(compiled_filename) + strlen(CG(compiled_filename)), " (defined in ");
    strcpy(CG(compiled_filename) + strlen(CG(compiled_filename)), EG(active_op_array)->filename);
    strcpy(CG(compiled_filename) + strlen(CG(compiled_filename)), ")");
    CG(interactive)= 0;
    init_op_array(res_op_array->op_array, ZEND_EVAL_CODE, INITIAL_OP_ARRAY_SIZE TSRMLS_CC);
    CG(interactive)= orig_interactive;
    CG(compiled_filename)= orig_compiled_filename;
    return res_op_array;
}

/* prepare for execution */
static void oel_finalize_op_array(php_oel_op_array* res_op_array TSRMLS_DC) {
    if (res_op_array->next)  oel_finalize_op_array(res_op_array->next);
    if (res_op_array->child) oel_finalize_op_array(res_op_array->child);
    if (!res_op_array->final) {
        if(res_op_array->type == OEL_TYPE_OAR_BASE) {
            PHP_OEL_PREPARE_ADD(res_op_array);
            zend_do_return(NULL, 0 TSRMLS_CC);
            zend_do_handle_exception(TSRMLS_C);
            PHP_OEL_PREPARE_ADD_END(res_op_array);
            pass_two(res_op_array->op_array TSRMLS_CC);
        } else if (res_op_array->type == OEL_TYPE_OAR_FUNCTION) {
            if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_OAR_FUNCTION)) oel_compile_error(E_ERROR, "opend token is not of type function");
            PHP_OEL_PREPARE_ADD(res_op_array);
            zend_do_end_function_declaration(oel_stack_pop_function(res_op_array TSRMLS_CC) TSRMLS_CC);
            PHP_OEL_PREPARE_ADD_END(res_op_array);
        } else if (res_op_array->type == OEL_TYPE_OAR_METHOD) {
            if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_OAR_METHOD)) oel_compile_error(E_ERROR, "opend token is not of type method");
            znode *func_token= oel_stack_pop_function(res_op_array TSRMLS_CC);
            znode *func_flags= oel_stack_pop_function(res_op_array TSRMLS_CC);
            znode *func_name=  oel_stack_pop_function(res_op_array TSRMLS_CC);

            znode *body= oel_create_extvar(res_op_array TSRMLS_CC);
            ZVAL_LONG(&body->u.constant, (ZEND_ACC_INTERFACE & res_op_array->cg_active_class_entry->ce_flags) ? ZEND_ACC_ABSTRACT : 0);

            PHP_OEL_PREPARE_ADD(res_op_array);
            zend_do_abstract_method(func_name, func_flags, body TSRMLS_CC);
            zend_do_end_function_declaration(func_token TSRMLS_CC);
            PHP_OEL_PREPARE_ADD_END(res_op_array);
        } else if (res_op_array->type == OEL_TYPE_OAR_AMETHOD) {
            if (!oel_token_isa(res_op_array TSRMLS_CC, 1, OEL_TYPE_OAR_AMETHOD)) oel_compile_error(E_ERROR, "opend token is not of type abstract method");
            znode *body=  oel_create_extvar(res_op_array TSRMLS_CC);
            ZVAL_LONG(&body->u.constant, ZEND_ACC_ABSTRACT);

            znode *func_token= oel_stack_pop_function(res_op_array TSRMLS_CC);
            znode *func_flags= oel_stack_pop_function(res_op_array TSRMLS_CC);
            znode *func_name=  oel_stack_pop_function(res_op_array TSRMLS_CC);

            PHP_OEL_PREPARE_ADD(res_op_array);
            zend_do_abstract_method(func_name, func_flags, body TSRMLS_CC);
            zend_do_end_function_declaration(func_token TSRMLS_CC);
            PHP_OEL_PREPARE_ADD_END(res_op_array);
        } else {
            oel_compile_error(E_ERROR, "opend token is not of unknown");
        }
        res_op_array->final= 1;
    }
}


/* destroy op array resource */
static void php_oel_op_array_dtor(zend_rsrc_list_entry *rsrc TSRMLS_DC) {
    php_oel_op_array *res_op_array= (php_oel_op_array *) rsrc->ptr;
    if (res_op_array) php_oel_destroy_op_array(res_op_array);
}

/* destroy op array */
static void php_oel_destroy_op_array(php_oel_op_array *res_op_array TSRMLS_DC) {
    if (res_op_array->next)  { php_oel_destroy_op_array(res_op_array->next) ; res_op_array->next=  NULL; }
    if (res_op_array->child) { php_oel_destroy_op_array(res_op_array->child); res_op_array->child= NULL; }

    if (res_op_array->stack_extvar) oel_stack_destroy_silent(&(res_op_array->stack_extvar) TSRMLS_CC);
    oel_stack_destroy_function(res_op_array TSRMLS_CC);
    oel_stack_destroy_operand(res_op_array TSRMLS_CC);
    if (res_op_array->op_array) {
        efree(res_op_array->op_array->filename);
        /* function op arrays are cleared by their parents */
        if (res_op_array->type == OEL_TYPE_OAR_BASE) {
            destroy_op_array(res_op_array->op_array TSRMLS_CC);
            efree(res_op_array->op_array);
        }
    }
    efree(res_op_array);
}

static void oel_compile_error(int type, const char *format, ...) {
    va_list arglist;
    va_start(arglist, format);
    TSRMLS_FETCH();

    char     *orig_filename=       zend_get_compiled_filename(TSRMLS_C);
    uint      orig_lineno=         zend_get_compiled_lineno(TSRMLS_C);
    zend_bool orig_in_compilation= CG(in_compilation);
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
