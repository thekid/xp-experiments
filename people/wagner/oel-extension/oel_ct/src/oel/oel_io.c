#define SERIALIZE(value, type) \
    memset(__se_buffer, 0, sizeof(__se_buffer)); \
    *((type*)__se_buffer) = value;                \
    php_stream_write(__se_stream, __se_buffer, __se_sizes[SESI_##type]);

#define WRITE(bytes, length) \
    php_stream_write(__se_stream, (char*)bytes, length);

#define UNSERIALIZE(value, type) \
    memset(__se_buffer, 0, sizeof(__se_buffer)); \
    php_stream_read(__se_stream, __se_buffer, __se_sizes[SESI_##type]); \
    *(value) = *((type*) __se_buffer); 
    
#define READ(bytes, length) \
    php_stream_read(__se_stream, (char*)bytes, length); \

#define SERIALIZED_CLASS_ENTRY 1
#define SERIALIZED_FUNCTION_ENTRY 3
#define SERIALIZED_OP_ARRAY 9
#define SERIALIZED_OP_END 13

#define SERIALIZED_VERSION 0x0100
#define SERIALIZED_HEADER "OELMZ"
#define SERIALIZED_HEADER_LENGTH 48

enum {
    SESI_int, 
    SESI_long, 
    SESI_char, 
    SESI_double,
    SESI_size_t,
    SESI_uint, 
    SESI_ulong,
    SESI_zend_uint, 
    SESI_zend_ushort, 
    SESI_zend_bool, 
    SESI_zend_uchar
};

#ifdef __x86_64__
static const size_t __se_sizes[] = { 8, 8, 1, 8, 8, 8, 8, 8, 2, 1, 1 };
#else
static const size_t __se_sizes[] = { 4, 4, 1, 8, 4, 4, 4, 4, 2, 1, 1 };
#endif

/* {{{ serialization */
static void serialize_char(char c SERIALIZE_DC);
static void serialize_stringl(char* string, int len SERIALIZE_DC);
static void serialize_string(char* string SERIALIZE_DC);
static void serialize_arg_info(zend_arg_info *arg_info SERIALIZE_DC);
static void serialize_dtor_func(dtor_func_t p SERIALIZE_DC);
static void serialize_hashtable(HashTable* ht, void* funcptr SERIALIZE_DC);
static void serialize_zvalue_value(zvalue_value *value, int type, znode *node SERIALIZE_DC);
static void serialize_zval_ptr(zval** zval_ptr SERIALIZE_DC);
static void serialize_zval(zval *ptr, znode *node SERIALIZE_DC);
static void serialize_znode(znode *node SERIALIZE_DC);
static void serialize_op(int id, zend_op *op, zend_op_array *op_array SERIALIZE_DC);
static void serialize_op_array(zend_op_array *op_array SERIALIZE_DC);
static void serialize_zval_ptr(zval** zval_ptr SERIALIZE_DC);
static void serialize_class_entry(zend_class_entry* ce SERIALIZE_DC);
static void serialize_method(zend_function* function SERIALIZE_DC);
static void serialize_function(zend_function* function SERIALIZE_DC);
static void serialize_function_entry(zend_function_entry* entry SERIALIZE_DC);
static void serialize_property_info(zend_property_info* prop SERIALIZE_DC);

static void serialize_char(char c SERIALIZE_DC)
{
    SERIALIZE(c, char);
}

static void serialize_stringl(char* string, int len SERIALIZE_DC)
{
    if (len <= 0 || string == NULL) {
        SERIALIZE(-1, int);
        return;
    }
    SERIALIZE(len, int);
    WRITE(string, len);
}

static void serialize_string(char* string SERIALIZE_DC)
{
    if (string == NULL) {
        SERIALIZE(-1, int);
    } else {
        serialize_stringl(string, strlen(string) SERIALIZE_CC);
    }
}

static void serialize_arg_info(zend_arg_info *arg_info SERIALIZE_DC)
{
    if (arg_info == NULL) {
        SERIALIZE(0, char);
        return;
    }

    SERIALIZE(1, char);
    SERIALIZE(arg_info->name_len, int);

    serialize_stringl(arg_info->name, arg_info->name_len SERIALIZE_CC);
    SERIALIZE(arg_info->class_name_len, int);
    if (arg_info->class_name_len) {
        serialize_stringl(arg_info->class_name, arg_info->class_name_len SERIALIZE_CC);
    }
    SERIALIZE(arg_info->allow_null, char);
    SERIALIZE(arg_info->pass_by_reference, char);
    SERIALIZE(arg_info->return_reference, char);
    SERIALIZE(arg_info->required_num_args, int);
    
}

static void serialize_dtor_func(dtor_func_t p SERIALIZE_DC)
{
    if (p == ZVAL_PTR_DTOR) {
        SERIALIZE(1, ulong);
    } else if (p == ZEND_FUNCTION_DTOR) {
        SERIALIZE(2, ulong);
    } else if (p == ZEND_CLASS_DTOR) {
        SERIALIZE(3, ulong);
    } else if (p == ZEND_MODULE_DTOR) {
        SERIALIZE(4, ulong);
    } else if (p == ZEND_CONSTANT_DTOR) {
        SERIALIZE(5, ulong);
    } else if (p == (dtor_func_t)free_estring) {
        SERIALIZE(6, ulong);
    } else if (p == list_entry_destructor) {
        SERIALIZE(7, ulong);
    } else if (p == plist_entry_destructor) {
        SERIALIZE(8, ulong);
    } else {
        SERIALIZE(0, ulong);
    }
}

static void serialize_hashtable(HashTable* ht, void* funcptr SERIALIZE_DC)
{
    Bucket* p;
    void (*serialize_bucket)(void* SERIALIZE_DC);

    if (NULL == ht) {
        SERIALIZE(0, char);
        return;
    }

    serialize_bucket = (void(*)(void* SERIALIZE_DC)) funcptr;
    
    SERIALIZE(1, char);
    SERIALIZE(ht->nTableSize, uint);
    serialize_dtor_func(ht->pDestructor SERIALIZE_CC);
    SERIALIZE(ht->nNumOfElements, uint);
    SERIALIZE(ht->persistent, int);

    p = ht->pListHead;
    while (p != NULL) {
        SERIALIZE(p->h, ulong);
        SERIALIZE(p->nKeyLength,uint);
        serialize_stringl(p->arKey, p->nKeyLength SERIALIZE_CC);
        
        serialize_bucket(p->pData SERIALIZE_CC); 
        p = p->pListNext;
    }        
}

static void serialize_zvalue_value(zvalue_value *value, int type, znode *node SERIALIZE_DC)
{
    switch (type) {
        case IS_RESOURCE: case IS_BOOL: case IS_LONG: {
             SERIALIZE(value->lval, long);
             break;
        }
        
        case IS_DOUBLE: {
            SERIALIZE(value->dval, double);
            break;
        }
        
        case IS_NULL: {
            if (node) {
                SERIALIZE(node->u.EA.var, zend_uint);
                SERIALIZE(node->u.EA.type, zend_uint);
            }
            SERIALIZE(value->lval, long);
            break;
        }

        case IS_CONSTANT: case IS_STRING: {
            serialize_stringl(value->str.val, value->str.len SERIALIZE_CC);
            SERIALIZE(value->str.len, int);
            break;
        }
        
        case IS_ARRAY: case IS_CONSTANT_ARRAY: {
            serialize_hashtable(value->ht, serialize_zval_ptr SERIALIZE_CC);
            break;
        }
        
        case IS_OBJECT: {
            /** 
             * TODO:
             *   apc_serialize_zend_class_entry(zv->obj.handlers, NULL, 0, NULL, 0 TSRMLS_CC);
             *   apc_serialize_hashtable(zv->obj.properties, apc_serialize_zval_ptr TSRMLS_CC);
             */
            break;
        }
        
        default: {
            zend_error(E_RECOVERABLE_ERROR, "Could not serialize value type %d", type);
        }
    }
}

static void serialize_zval_ptr(zval** zval_ptr SERIALIZE_DC)
{
    serialize_zval(*zval_ptr, NULL SERIALIZE_CC);
}


static void serialize_zval(zval *ptr, znode *node SERIALIZE_DC)
{
    SERIALIZE(ptr->type, zend_uchar);
    serialize_zvalue_value(&ptr->value, ptr->type, node SERIALIZE_CC);
    SERIALIZE(ptr->is_ref, zend_uchar);
    SERIALIZE(ptr->refcount, zend_ushort);
}

static void serialize_znode(znode *node SERIALIZE_DC)
{
    SERIALIZE(node->op_type, int);

    switch (node->op_type) {
        case IS_CONST: {
            serialize_zval(&node->u.constant, node SERIALIZE_CC);
            break;
        }

        case IS_VAR: case IS_TMP_VAR: case IS_UNUSED: default: {
            SERIALIZE(node->u.EA.var, zend_uint);
            SERIALIZE(node->u.EA.type, zend_uint);
            break;
        }
    }
}

static void serialize_op(int id, zend_op *op, zend_op_array *op_array SERIALIZE_DC)
{
    SERIALIZE(op->opcode, zend_uchar);

    serialize_znode(&op->result SERIALIZE_CC);
    switch (op->opcode)
    {
        case ZEND_JMP: {
            op->op1.u.opline_num = op->op1.u.jmp_addr - op_array->opcodes;
            break;
        }
        
        case ZEND_JMPZ: case ZEND_JMPNZ: case ZEND_JMPZ_EX: case ZEND_JMPNZ_EX: {
            op->op2.u.opline_num = op->op2.u.jmp_addr - op_array->opcodes;
            break;
        }
    }
    serialize_znode(&op->op1 SERIALIZE_CC);
    serialize_znode(&op->op2 SERIALIZE_CC);
    SERIALIZE(op->extended_value, ulong);
    SERIALIZE(op->lineno, uint);
}

static void serialize_op_array(zend_op_array *op_array SERIALIZE_DC)
{
    int i;
    
    SERIALIZE(op_array->type, zend_uchar);
    SERIALIZE(op_array->num_args, int);
    for (i = 0; i < (int)op_array->num_args; i++) {
        serialize_arg_info(&op_array->arg_info[i] SERIALIZE_CC);
    }

    serialize_string(op_array->function_name SERIALIZE_CC);
    SERIALIZE(op_array->refcount[0], zend_uint);
    SERIALIZE(op_array->last, zend_uint);
    SERIALIZE(op_array->size, zend_uint);
    
    for (i = 0; i < (int)op_array->last; i++) {
        serialize_op(i, &op_array->opcodes[i], op_array SERIALIZE_CC);
    }

    SERIALIZE(op_array->T, zend_uint);
    SERIALIZE(op_array->last_brk_cont, zend_uint);
    SERIALIZE(op_array->current_brk_cont, zend_uint);
    
    if (op_array->brk_cont_array != NULL) {
        SERIALIZE(1, char);
        WRITE(op_array->brk_cont_array, op_array->last_brk_cont * sizeof(zend_brk_cont_element));
    } else {
        SERIALIZE(0, char);
    }
    serialize_hashtable(op_array->static_variables, serialize_zval_ptr SERIALIZE_CC);

    SERIALIZE(op_array->return_reference, zend_bool);
    SERIALIZE(op_array->done_pass_two, zend_bool);
    serialize_string(op_array->filename SERIALIZE_CC);
    serialize_string(op_array->scope ? op_array->scope->name : NULL SERIALIZE_CC);

    SERIALIZE(op_array->fn_flags, zend_uint);
    SERIALIZE(op_array->required_num_args, zend_uint);
    SERIALIZE(op_array->pass_rest_by_reference, zend_bool);
    SERIALIZE(op_array->backpatch_count, int);
    SERIALIZE(op_array->uses_this, zend_bool);


    SERIALIZE(op_array->last_var, int);
    SERIALIZE(op_array->size_var, int);
    for (i = 0; i < op_array->last_var; i++) {
        SERIALIZE(op_array->vars[i].name_len, int);
        serialize_stringl(op_array->vars[i].name, op_array->vars[i].name_len SERIALIZE_CC);
        SERIALIZE(op_array->vars[i].hash_value, ulong);
    }

    if (op_array->try_catch_array != NULL && op_array->last_try_catch > 0) {
        SERIALIZE(op_array->last_try_catch, int);
        WRITE(op_array->try_catch_array, op_array->last_try_catch * sizeof(zend_try_catch_element));
    } else {
        SERIALIZE(0, int);
    }
}

static void serialize_function_entry(zend_function_entry* entry SERIALIZE_DC)
{
    /* TODO */
}

static void serialize_property_info(zend_property_info* prop SERIALIZE_DC)
{
    SERIALIZE(prop->flags, zend_uint);
    serialize_stringl(prop->name, prop->name_length SERIALIZE_CC);
    SERIALIZE(prop->name_length, uint);
    SERIALIZE(prop->h, ulong);
}

static void serialize_method(zend_function* function SERIALIZE_DC)
{
    int special = 0;

    if (0 != strcmp(__se_class->name, function->common.scope->name)) {
        SERIALIZE(0xff, zend_uchar);    /* Inherited */
        return;
    }
    SERIALIZE(function->type, zend_uchar);
    
    if (function == __se_class->constructor) {
        special= 0x001;
    } else if (function == __se_class->destructor) {
        special= 0x002;
    } else if (function == __se_class->clone) {
        special= 0x004;
    } else if (function == __se_class->__get) {
        special= 0x008;
    } else if (function == __se_class->__set) {
        special= 0x010;
    } else if (function == __se_class->__call) {
        special= 0x020;
    } else if (function == __se_class->__unset) {
        special= 0x040;
    } else if (function == __se_class->__isset) {
        special= 0x080;
    } else if (function == __se_class->serialize_func) {
        special= 0x100;
    } else if (function == __se_class->unserialize_func) {
        special= 0x200;
    } else if (function == __se_class->__tostring) {
        special= 0x400;
    } 
    SERIALIZE(special, int);

    switch (function->type) {
        case ZEND_INTERNAL_FUNCTION: {
            /* TODO apc_serialize_zend_internal_function(&zf->internal_function TSRMLS_CC); */
            break;
        }
        
        case ZEND_USER_FUNCTION: case ZEND_EVAL_CODE: {
            serialize_op_array(&function->op_array SERIALIZE_CC);
            break;
        }
        
        default: {
            zend_error(E_RECOVERABLE_ERROR, "Could not serialize function type %d", function->type);
        }
    }
}

static void serialize_function(zend_function* function SERIALIZE_DC)
{
    SERIALIZE(function->type, zend_uchar);
    switch (function->type) {
        case ZEND_INTERNAL_FUNCTION: {
            /* TODO apc_serialize_zend_internal_function(&zf->internal_function TSRMLS_CC); */
            break;
        }
        
        case ZEND_USER_FUNCTION: case ZEND_EVAL_CODE: {
            serialize_op_array(&function->op_array SERIALIZE_CC);
            break;
        }
        
        default: {
            zend_error(E_RECOVERABLE_ERROR, "Could not serialize function type %d", function->type);
        }
    }
}


static void serialize_class_entry(zend_class_entry *ce SERIALIZE_DC) 
{
    int i, count;

    SERIALIZE(ce->type, char);
    serialize_stringl(ce->name, ce->name_length SERIALIZE_CC);
    SERIALIZE(ce->name_length, uint);
    SERIALIZE(ce->refcount, int);
    SERIALIZE(ce->constants_updated, zend_bool);
    SERIALIZE(ce->ce_flags, zend_uint);

    __se_class= ce;
    serialize_hashtable(&ce->function_table, serialize_method SERIALIZE_CC);
    serialize_hashtable(&ce->default_properties, serialize_zval_ptr SERIALIZE_CC);
    serialize_hashtable(&ce->properties_info, serialize_property_info SERIALIZE_CC);
    serialize_hashtable(&ce->default_static_members, serialize_zval_ptr SERIALIZE_CC);
    serialize_hashtable(&ce->constants_table, serialize_zval_ptr SERIALIZE_CC);

    /* Builtin fucntions */
    count = 0;
    if (ce->type == ZEND_INTERNAL_CLASS && ce->builtin_functions) {
        zend_function_entry* zfe;
        for (zfe = ce->builtin_functions; zfe->fname != NULL; zfe++) {
            count++;
        }
    }
    SERIALIZE(count, int);
    for (i = 0; i < count; i++) {
        serialize_function_entry(&ce->builtin_functions[i] SERIALIZE_CC);
    }
    
    /* Interfaces */    
    SERIALIZE(ce->num_interfaces, zend_uint);

    __se_class= NULL;
}

#define MARK_UNUSED(op)                     \
    memset(&op, 0, sizeof(znode));          \
    SET_UNUSED(op);                         \

#define NOP(opline)                         \
    opline->opcode = ZEND_NOP;              \
    MARK_UNUSED(opline->op1);               \
    MARK_UNUSED(opline->op2);               \
    SET_UNUSED(opline->result);             \

static void serialize_oel_op_array(php_oel_op_array  *oel_op_array SERIALIZE_DC) 
{
    int i;
    zend_op *opline, *orig_opcodes;
    zend_function *fe= NULL;
    zend_class_entry **ce= NULL;

    /* copy opcodes - next block will change them */
    orig_opcodes= oel_op_array->oel_cg.active_op_array->opcodes;
    oel_op_array->oel_cg.active_op_array->opcodes= (zend_op *) emalloc(sizeof(zend_op) * oel_op_array->oel_cg.active_op_array->last);
    memcpy(oel_op_array->oel_cg.active_op_array->opcodes, orig_opcodes, sizeof(zend_op) * oel_op_array->oel_cg.active_op_array->last);

    /* NOP out class and function declarations */
    for (i= 0; i < (int)oel_op_array->oel_cg.active_op_array->last; i++) {
        opline= oel_op_array->oel_cg.active_op_array->opcodes + i;
        if (opline->opcode == ZEND_DECLARE_CLASS || opline->opcode == ZEND_DECLARE_INHERITED_CLASS) {
            if (FAILURE == zend_hash_find(oel_op_array->oel_cg.class_table, opline->op1.u.constant.value.str.val, opline->op1.u.constant.value.str.len, (void **)&ce)) {
                zend_error(E_COMPILE_ERROR, "Missing class information for %s", opline->op2.u.constant.value.str.val);
                return;
            }
            SERIALIZE(SERIALIZED_CLASS_ENTRY, char);
            serialize_class_entry(*ce SERIALIZE_CC);
            serialize_stringl(opline->op1.u.constant.value.str.val, opline->op1.u.constant.value.str.len SERIALIZE_CC);
        } else if (opline->opcode == ZEND_DECLARE_FUNCTION) {
            if (FAILURE == zend_hash_find(oel_op_array->oel_cg.function_table, opline->op1.u.constant.value.str.val, opline->op1.u.constant.value.str.len, (void **)&fe)) {
                zend_error(E_COMPILE_ERROR, "Error - Can't find function %s", opline->op2.u.constant.value.str.val);
                return;
            }
            SERIALIZE(SERIALIZED_FUNCTION_ENTRY, char)
            serialize_function(fe SERIALIZE_CC);
            /* TODO: Key? */
        }
    }

    /* serialize main opcode array */
    SERIALIZE(SERIALIZED_OP_ARRAY, char);
    serialize_op_array(oel_op_array->oel_cg.active_op_array SERIALIZE_CC);
    efree(oel_op_array->oel_cg.active_op_array->opcodes);
    oel_op_array->oel_cg.active_op_array->opcodes= orig_opcodes;
    SERIALIZE(SERIALIZED_OP_END, char);
}
/* }}} */

/* {{{ deserialization */
static void unserialize_op_array(zend_op_array* op_array UNSERIALIZE_DC);
static void unserialize_arg_info(zend_arg_info* arg_info UNSERIALIZE_DC);
static void unserialize_op(int id, zend_op *op, zend_op_array *op_array UNSERIALIZE_DC);
static void unserialize_string(char **string UNSERIALIZE_DC);
static void unserialize_stringl(char **string, int *len UNSERIALIZE_DC);
static void unserialize_dtor_func(dtor_func_t* p UNSERIALIZE_DC);
static void unserialize_method_ptr(zend_function **function UNSERIALIZE_DC);
static void unserialize_method(zend_function *function UNSERIALIZE_DC);
static void unserialize_zvalue_value(zvalue_value *value, int type, znode *node UNSERIALIZE_DC);
static void unserialize_zval(zval *ptr, znode *node UNSERIALIZE_DC);
static void unserialize_zval_ptr(zval **zval_ptr UNSERIALIZE_DC);
static void unserialize_property_info(zend_property_info *prop UNSERIALIZE_DC);
static void unserialize_property_info_ptr(zend_property_info **prop_ptr UNSERIALIZE_DC);
static void unserialize_hashtable(HashTable* ht, int datasize, void* funcptr, char* name UNSERIALIZE_DC);
static void unserialize_hashtable_ptr(HashTable** ht, int datasize, void* funcptr, char* name UNSERIALIZE_DC);
static void unserialize_function_entry(zend_function_entry* entry UNSERIALIZE_DC);
static void unserialize_class_entry(zend_class_entry* ce UNSERIALIZE_DC);
static void unserialize_oel_op_array(php_oel_op_array** res_op_array UNSERIALIZE_DC);

static void unserialize_arg_info(zend_arg_info* arg_info UNSERIALIZE_DC)
{
    char exists;
    
    UNSERIALIZE(&exists, char);
    if (0 == exists) {
        arg_info = NULL;
        return;
    }
    
    UNSERIALIZE(&arg_info->name_len, int);
    unserialize_string(&arg_info->name UNSERIALIZE_CC);
    UNSERIALIZE(&arg_info->class_name_len, int);
    if (arg_info->class_name_len) {
        unserialize_string(&arg_info->class_name UNSERIALIZE_CC);
    }
    UNSERIALIZE(&arg_info->allow_null, char);
    UNSERIALIZE(&arg_info->pass_by_reference, char);
    UNSERIALIZE(&arg_info->return_reference, char);
    UNSERIALIZE(&arg_info->required_num_args, int);
}

static void unserialize_znode(znode *node UNSERIALIZE_DC)
{
    UNSERIALIZE(&node->op_type, int);

    switch (node->op_type) 
    {
        case IS_CONST: {
            unserialize_zval(&node->u.constant, node UNSERIALIZE_CC);
            break;
        }
        
        case IS_VAR: case IS_TMP_VAR: case IS_UNUSED: default: {
            UNSERIALIZE(&node->u.EA.var, zend_uint);
            UNSERIALIZE(&node->u.EA.type, zend_uint);
            break;
        }
    }
}

static void unserialize_op(int id, zend_op *op, zend_op_array *op_array UNSERIALIZE_DC)
{
    UNSERIALIZE(&op->opcode, zend_uchar);
    unserialize_znode(&op->result UNSERIALIZE_CC);
    unserialize_znode(&op->op1 UNSERIALIZE_CC);
    unserialize_znode(&op->op2 UNSERIALIZE_CC);
    ZEND_VM_SET_OPCODE_HANDLER(op);
    
    switch (op->opcode)
    {
        case ZEND_JMP: {
            op->op1.u.jmp_addr = op_array->opcodes + op->op1.u.opline_num;
            break;
        }
        
        case ZEND_JMPZ: case ZEND_JMPNZ: case ZEND_JMPZ_EX: case ZEND_JMPNZ_EX: {
            op->op2.u.jmp_addr = op_array->opcodes + op->op2.u.opline_num;
            break;
        }
    }
    
    UNSERIALIZE(&op->extended_value, ulong);
    UNSERIALIZE(&op->lineno, uint);
}

static void unserialize_op_array(zend_op_array* op_array UNSERIALIZE_DC)
{
    int i;
    char brk;
    char *scope;

    /* TBD: (un-)serialize these? */
    op_array->doc_comment = NULL;
    op_array->doc_comment_len = 0;

    op_array->line_start = 0;
    op_array->line_end = 0;

    UNSERIALIZE(&op_array->type, zend_uchar);       
    UNSERIALIZE(&op_array->num_args, int);
    op_array->arg_info = (zend_arg_info *) ecalloc(op_array->num_args, sizeof(zend_arg_info));
    for (i = 0; i < (int)op_array->num_args; i++) {
        unserialize_arg_info(&op_array->arg_info[i] UNSERIALIZE_CC);
    }
    
    unserialize_string(&op_array->function_name UNSERIALIZE_CC);
    op_array->refcount = (int*) emalloc(sizeof(zend_uint));
    UNSERIALIZE(&op_array->refcount[0], zend_uint);
    UNSERIALIZE(&op_array->last, zend_uint);
    UNSERIALIZE(&op_array->size, zend_uint);
    
    op_array->opcodes = NULL;
    if (op_array->last > 0) {
        op_array->opcodes = (zend_op*) emalloc(op_array->last * sizeof(zend_op));
        for (i = 0; i < (int)op_array->last; i++) {
            unserialize_op(i, &op_array->opcodes[i], op_array UNSERIALIZE_CC);
        }
    }
    
    UNSERIALIZE(&op_array->T, zend_uint);
    UNSERIALIZE(&op_array->last_brk_cont, zend_uint);
    UNSERIALIZE(&op_array->current_brk_cont, zend_uint);

    UNSERIALIZE(&brk, char);
    if (0 != brk) {
        op_array->brk_cont_array = (zend_brk_cont_element*)emalloc(op_array->last_brk_cont * sizeof(zend_brk_cont_element));
        READ(op_array->brk_cont_array, op_array->last_brk_cont * sizeof(zend_brk_cont_element));
    }
    unserialize_hashtable_ptr(&op_array->static_variables, sizeof(zval *), unserialize_zval_ptr, "op_array->static_variables" UNSERIALIZE_CC);

    UNSERIALIZE(&op_array->return_reference, zend_bool);
    UNSERIALIZE(&op_array->done_pass_two, zend_bool);
    unserialize_string(&op_array->filename UNSERIALIZE_CC);
    
    /* Handle op array's scope */
    unserialize_string(&scope UNSERIALIZE_CC);
    op_array->scope = NULL;
    op_array->prototype = NULL;
    if (NULL != scope) {
        zend_class_entry **pce;
         
        if (__se_class && 0 == strncmp(__se_class->name, scope, __se_class->name_length)) {
            op_array->scope= __se_class;
        } else if (zend_lookup_class(scope, strlen(scope), &pce TSRMLS_CC) == FAILURE) {
            fprintf(stderr, "Cannot find scope %s\n", scope);
        } else {
            op_array->scope= *pce;
        }
    }

    UNSERIALIZE(&op_array->fn_flags, zend_uint);
    UNSERIALIZE(&op_array->required_num_args, zend_uint);
    UNSERIALIZE(&op_array->pass_rest_by_reference, zend_bool);
    UNSERIALIZE(&op_array->backpatch_count, int);
    UNSERIALIZE(&op_array->uses_this, zend_bool);

    UNSERIALIZE(&op_array->last_var, int);
    UNSERIALIZE(&op_array->size_var, int);
    if (op_array->size_var > 0) {
        op_array->vars = emalloc(op_array->size_var * sizeof(op_array->vars[0]));
        memset(op_array->vars, 0, op_array->size_var * sizeof(op_array->vars[0]));
        for (i = 0; i < op_array->last_var; i++) {
            UNSERIALIZE(&(op_array->vars[i].name_len), int);
            unserialize_string(&(op_array->vars[i].name) UNSERIALIZE_CC);
            UNSERIALIZE(&(op_array->vars[i].hash_value), ulong);
        }
    }

    UNSERIALIZE(&op_array->last_try_catch, int);
    if (op_array->last_try_catch > 0) {
        op_array->try_catch_array = (zend_try_catch_element*) emalloc(op_array->last_try_catch * sizeof(zend_try_catch_element));
        READ(op_array->try_catch_array, op_array->last_try_catch * sizeof(zend_try_catch_element));
    }
}

static void unserialize_string(char **string UNSERIALIZE_DC)
{
    int len;

    UNSERIALIZE(&len, int);
    if (-1 == len) {
        *string = NULL;
    } else {
        *string = (char*) emalloc(len + 1);
        READ(*string, len);
        (*string)[len] = '\0';
    }
}

static void unserialize_stringl(char **string, int *len UNSERIALIZE_DC)
{
    UNSERIALIZE(len, int);
    if (-1 == *len) {
        *string = NULL;
    } else {
        *string = (char*) emalloc(*len + 1);
        READ(*string, *len);
        (*string)[*len] = '\0';
    }
}

static void unserialize_dtor_func(dtor_func_t* p UNSERIALIZE_DC)
{
    ulong h;
    
    UNSERIALIZE(&h, ulong);
    switch (h) {
        case 1: *p= ZVAL_PTR_DTOR; return;
        case 2: *p= ZEND_FUNCTION_DTOR; return;
        case 3: *p= ZEND_CLASS_DTOR; return;
        case 4: *p= ZEND_MODULE_DTOR; return;
        case 5: *p= ZEND_CONSTANT_DTOR; return;
        case 6: *p= (dtor_func_t)free_estring; return;
        case 7: *p= list_entry_destructor; return;
        case 8: *p= plist_entry_destructor; return;
    }
}

static void unserialize_method_ptr(zend_function **function UNSERIALIZE_DC)
{
    *function = (zend_function*) emalloc(sizeof(zend_function));
    memset(*function, 0, sizeof(zend_function));
    
    unserialize_method(*function UNSERIALIZE_CC);
    if (0xff == (*function)->type) {
        efree(*function);
        *function = NULL;
    }
}

static void unserialize_method(zend_function *function UNSERIALIZE_DC)
{
    int special;
    
    UNSERIALIZE(&function->type, zend_uchar);

    if (0xff == function->type) {
        return;
    }
    UNSERIALIZE(&special, int);

    switch (special) {
        case 0x001: __se_class->constructor = function; break;
        case 0x002: __se_class->destructor = function; break;
        case 0x004: __se_class->clone = function; break;
        case 0x008: __se_class->__get = function; break;
        case 0x010: __se_class->__set = function; break;
        case 0x020: __se_class->__call = function; break;
        case 0x040: __se_class->__unset = function; break;
        case 0x080: __se_class->__isset = function; break;
        case 0x100: __se_class->serialize_func = function; break;
        case 0x200: __se_class->unserialize_func = function; break;
        case 0x400: __se_class->__tostring = function; break;
    }
    
    switch (function->type) {
        case ZEND_INTERNAL_FUNCTION: {
            /* TODO apc_deserialize_zend_internal_function(&zf->internal_function TSRMLS_CC); */
            break;
        }
        
        case ZEND_USER_FUNCTION: case ZEND_EVAL_CODE: {
            unserialize_op_array(&function->op_array UNSERIALIZE_CC);
            break;
        }
        
        default: {
            zend_error(E_RECOVERABLE_ERROR, "Could not unserialize function type %d", function->type);
        }
    }
}

static void unserialize_zvalue_value(zvalue_value *value, int type, znode *node UNSERIALIZE_DC)
{
    switch (type) {
        case IS_RESOURCE: case IS_BOOL: case IS_LONG: {
             UNSERIALIZE(&value->lval, long);
             break;
        }
        
        case IS_DOUBLE: {
            UNSERIALIZE(&value->dval, double);
            break;
        }
        
        case IS_NULL: {
            if (node) {
                UNSERIALIZE(&node->u.EA.var, zend_uint);
                UNSERIALIZE(&node->u.EA.type, zend_uint);
            }
            UNSERIALIZE(&value->lval, long);
            break;
        }

        case IS_CONSTANT: case IS_STRING: {
            unserialize_string(&value->str.val UNSERIALIZE_CC);
            UNSERIALIZE(&value->str.len, int);
            break;
        }
        
        case IS_ARRAY: case IS_CONSTANT_ARRAY: {
            unserialize_hashtable_ptr(&value->ht, sizeof(void *), unserialize_zval_ptr, "(array)" UNSERIALIZE_CC);
            break;
        }
        
        case IS_OBJECT: {
            /** 
             * TODO:
             *   apc_deserialize_zend_class_entry(zv->obj.handlers, NULL, 0, NULL, 0 TSRMLS_CC);
             *   apc_deserialize_hashtable(zv->obj.properties, apc_serialize_zval_ptr TSRMLS_CC);
             */
            break;
        }
        
        default: {
            zend_error(E_RECOVERABLE_ERROR, "Could not unserialize value type %d", type);
        }
    }
}

static void unserialize_zval(zval *ptr, znode *node UNSERIALIZE_DC)
{
    UNSERIALIZE(&ptr->type, zend_uchar);
    unserialize_zvalue_value(&ptr->value, ptr->type, node UNSERIALIZE_CC);
    UNSERIALIZE(&ptr->is_ref, zend_uchar);
    UNSERIALIZE(&ptr->refcount, zend_ushort);
}

static void unserialize_zval_ptr(zval **zval_ptr UNSERIALIZE_DC)
{
    *zval_ptr = (zval*) emalloc(sizeof(zval));
    memset(*zval_ptr, 0, sizeof(zval));
    unserialize_zval(*zval_ptr, NULL UNSERIALIZE_CC);
}

static void unserialize_property_info_ptr(zend_property_info **prop_ptr UNSERIALIZE_DC)
{
    *prop_ptr = (zend_property_info*) emalloc(sizeof(zend_property_info));
    unserialize_property_info(*prop_ptr UNSERIALIZE_CC);
}

static void unserialize_property_info(zend_property_info *prop UNSERIALIZE_DC)
{
    UNSERIALIZE(&prop->flags, zend_uint);
    unserialize_string(&prop->name UNSERIALIZE_CC);
    UNSERIALIZE(&prop->name_length, uint);
    UNSERIALIZE(&prop->h, ulong);
    
    /* TBD: (un-)serialize these */
    prop->doc_comment = NULL;
    prop->doc_comment_len = 0;
}

static void unserialize_hashtable_ptr(HashTable** ht, int datasize, void* funcptr, char* name UNSERIALIZE_DC)
{
    char empty;

    UNSERIALIZE(&empty, char);

    if (0 != empty) {
        *ht = (HashTable*) emalloc(sizeof(HashTable));
        unserialize_hashtable(*ht, datasize, funcptr, name UNSERIALIZE_CC);
    } else {
        *ht= NULL;
    }
}

static void unserialize_hashtable(HashTable* ht, int datasize, void* funcptr, char* name UNSERIALIZE_DC)
{
    uint nTableSize;
    dtor_func_t pDestructor;
    uint nNumOfElements;
    int i;
    int persistent;
    void (*unserialize_bucket)(void* UNSERIALIZE_DC);

    unserialize_bucket = (void(*)(void* UNSERIALIZE_DC)) funcptr;
    UNSERIALIZE(&nTableSize, uint);
    unserialize_dtor_func(&pDestructor UNSERIALIZE_CC);
    UNSERIALIZE(&nNumOfElements, uint);
    UNSERIALIZE(&persistent, int);

    zend_hash_init(ht, nTableSize, NULL, pDestructor, persistent);
    for (i = 0; i < (int)nNumOfElements; i++) {
        ulong h;
        uint nKeyLength;
        char *arKey;
        void *pData;
        
        UNSERIALIZE(&h, ulong);
        UNSERIALIZE(&nKeyLength, uint);
        unserialize_string(&arKey UNSERIALIZE_CC);
        unserialize_bucket(&pData UNSERIALIZE_CC);
        
        if (NULL != pData) {
            if (nKeyLength != 0) {
                if (datasize == sizeof(void *)) {
                    zend_hash_add(ht, arKey, nKeyLength, &pData, datasize, NULL);
                } else {
                    zend_hash_add(ht, arKey, nKeyLength, pData, datasize, NULL);
                }
                efree(arKey);
            } else {
                if (datasize == sizeof(void *)) {
                    zend_hash_index_update(ht, h, &pData, datasize, NULL);
                } else {
                    zend_hash_index_update(ht, h, pData, datasize, NULL);
                }
            }
        } else {
            efree(arKey);
        }
    }
}

#define RETURN_IF_NOT_EXISTANT      \
    {                               \
        char exists;                \
        UNSERIALIZE(&exists, char); \
        if (exists == 0) return;    \
    }                               \

/* TODO: Don't serialize these for non-generic hashmaps - see unserialize_ce_* */
#define UNSERIALIZE_HASHTABLE_SIZE(nNumOfElements)      \
    {                                                   \
        uint nTableSize;                                \
        dtor_func_t pDtor;                              \
        int persistent;                                 \
                                                        \
        UNSERIALIZE(&nTableSize, uint);                 \
        unserialize_dtor_func(&pDtor UNSERIALIZE_CC);   \
        UNSERIALIZE(&nNumOfElements, uint);             \
        UNSERIALIZE(&persistent, int);                  \
    }
    

#define foreach(ht, nNumOfElements, element, code)      \
    {                                                   \
        int i;                                          \
        for (i = 0; i < (int)nNumOfElements; i++) {     \
            element;                                    \
            code                                        \
        }                                               \
    }                                                   \

static void unserialize_ce_function_table(zend_class_entry* ce UNSERIALIZE_DC)
{
    uint nNumOfElements;

    RETURN_IF_NOT_EXISTANT;
    
    /* Create function_table entries with zend_function * entries
     * inside - see do_bind_function() in zend_compile.c
     */
    UNSERIALIZE_HASHTABLE_SIZE(nNumOfElements);
    foreach (ce->function_table, nNumOfElements, zend_function *function, {
        ulong h;
        uint nKeyLength;
        char *arKey;

        UNSERIALIZE(&h, ulong);
        UNSERIALIZE(&nKeyLength, uint);
        unserialize_string(&arKey UNSERIALIZE_CC);
        unserialize_method_ptr(&function UNSERIALIZE_CC);
        
        if (NULL != function) {
            zend_hash_add(&ce->function_table, arKey, nKeyLength, function, sizeof(zend_function), NULL);
        }
        efree(arKey);
    })
}

static void unserialize_ce_default_properties(zend_class_entry* ce UNSERIALIZE_DC)
{
    uint nNumOfElements;

    RETURN_IF_NOT_EXISTANT;
    
    /* Create default_properties entries with zval ** entries
     * inside
     */
    UNSERIALIZE_HASHTABLE_SIZE(nNumOfElements);
    foreach (ce->default_properties, nNumOfElements, zval *property, {
        ulong h;
        uint nKeyLength;
        char *arKey;

        UNSERIALIZE(&h, ulong);
        UNSERIALIZE(&nKeyLength, uint);
        unserialize_string(&arKey UNSERIALIZE_CC);
        unserialize_zval_ptr(&property UNSERIALIZE_CC);
        
        if (NULL != property) {
            zend_hash_quick_update(&ce->default_properties, arKey, nKeyLength, h, &property, sizeof(zval *), NULL);
        }
        efree(arKey);
    })
}

static void unserialize_ce_default_static_members(zend_class_entry* ce UNSERIALIZE_DC)
{
    uint nNumOfElements;

    RETURN_IF_NOT_EXISTANT;
    
    /* Create static_members entries with zval ** entries
     * inside
     */
    UNSERIALIZE_HASHTABLE_SIZE(nNumOfElements);
    foreach (ce->default_static_members, nNumOfElements, zval *property, {
        ulong h;
        uint nKeyLength;
        char *arKey;

        UNSERIALIZE(&h, ulong);
        UNSERIALIZE(&nKeyLength, uint);
        unserialize_string(&arKey UNSERIALIZE_CC);
        unserialize_zval_ptr(&property UNSERIALIZE_CC);
        
        if (NULL != property) {
            zend_hash_quick_update(&ce->default_static_members, arKey, nKeyLength, h, &property, sizeof(zval *), NULL);
        }
        efree(arKey);
    })
}

static void unserialize_ce_property_info(zend_class_entry* ce UNSERIALIZE_DC)
{
    uint nNumOfElements;

    RETURN_IF_NOT_EXISTANT;
    
    /* Create properties_info entries with zend_property_info * entries
     * inside - see zend_declare_property_ex() in zend_compile.c
     */
    UNSERIALIZE_HASHTABLE_SIZE(nNumOfElements);
    foreach (ce->properties_info, nNumOfElements, zend_property_info *property_info, {
        ulong h;
        uint nKeyLength;
        char *arKey;

        UNSERIALIZE(&h, ulong);
        UNSERIALIZE(&nKeyLength, uint);
        unserialize_string(&arKey UNSERIALIZE_CC);
        unserialize_property_info_ptr(&property_info UNSERIALIZE_CC);
        
        if (NULL != property_info) {
            property_info->ce = ce;
            zend_hash_add(&ce->properties_info, arKey, nKeyLength, property_info, sizeof(zend_property_info), NULL);
        }
        efree(arKey);
    })
}

static void unserialize_ce_constants_table(zend_class_entry* ce UNSERIALIZE_DC)
{
    uint nNumOfElements;

    RETURN_IF_NOT_EXISTANT;
    
    /* Create static_members entries with zval ** entries
     * inside
     */
    UNSERIALIZE_HASHTABLE_SIZE(nNumOfElements);
    foreach (ce->constants_table, nNumOfElements, zval *property, {
        ulong h;
        uint nKeyLength;
        char *arKey;

        UNSERIALIZE(&h, ulong);
        UNSERIALIZE(&nKeyLength, uint);
        unserialize_string(&arKey UNSERIALIZE_CC);
        unserialize_zval_ptr(&property UNSERIALIZE_CC);
        
        if (NULL != property) {
            zend_hash_quick_update(&ce->constants_table, arKey, nKeyLength, h, &property, sizeof(zval *), NULL);
        }
        efree(arKey);
    })
}

static void unserialize_function_entry(zend_function_entry* entry UNSERIALIZE_DC)
{
    /* TODO */
}

static void unserialize_class_entry(zend_class_entry* ce UNSERIALIZE_DC)
{
    int count;

    zend_initialize_class_data(ce, 1 TSRMLS_CC);
    
    /* TODO: (un)serialize these */
    ce->filename = NULL;
    ce->line_start = 0;
    ce->line_end = 0;

    /* TBD: (un-)serialize these? */
    ce->doc_comment = NULL;
    ce->doc_comment_len = 0;
    
    UNSERIALIZE(&ce->type, char);
    unserialize_string(&ce->name UNSERIALIZE_CC);
    UNSERIALIZE(&ce->name_length, uint);

    UNSERIALIZE(&ce->refcount, int);
    UNSERIALIZE(&ce->constants_updated, zend_bool);
    UNSERIALIZE(&ce->ce_flags, zend_uint);

    __se_class= ce;
    
    unserialize_ce_function_table(ce UNSERIALIZE_CC);
    unserialize_ce_default_properties(ce UNSERIALIZE_CC);
    unserialize_ce_property_info(ce UNSERIALIZE_CC);
    unserialize_ce_default_static_members(ce UNSERIALIZE_CC);
    unserialize_ce_constants_table(ce UNSERIALIZE_CC);

    ce->static_members = &ce->default_static_members;

    UNSERIALIZE(&count, int);
    if (count > 0) {
        int i;

        ce->builtin_functions = (zend_function_entry*) emalloc((count+1) * sizeof(zend_function_entry));
        ce->builtin_functions[count].fname = NULL;
        for (i = 0; i < count; i++) {
            unserialize_function_entry(&ce->builtin_functions[i] UNSERIALIZE_CC);
        }
    } else {
        ce->builtin_functions = NULL;
    }

    UNSERIALIZE(&ce->num_interfaces, zend_uint);
    if (ce->num_interfaces) {
        ce->interfaces= (zend_class_entry **) emalloc(ce->num_interfaces * sizeof(zend_class_entry *));
    } else {
        ce->interfaces= NULL;
    }
    ce->parent= NULL;
    __se_class= NULL;
}

static void unserialize_oel_op_array(php_oel_op_array **res_op_array_ptr UNSERIALIZE_DC)
{
    php_oel_op_array *res_op_array;
    char item;
    int cont;

    res_op_array = *res_op_array_ptr;
    cont = 1;
    while (cont) {
        UNSERIALIZE(&item, char);
        switch (item) {
            case SERIALIZED_CLASS_ENTRY: {
                zend_class_entry *ce;
                char *lcname;
                int lcname_len;
              
                ce = (zend_class_entry*) emalloc(sizeof(zend_class_entry));
                unserialize_class_entry(ce UNSERIALIZE_CC);
                unserialize_stringl(&lcname, &lcname_len UNSERIALIZE_CC);

                /* Add to op array's class table */
                zend_hash_add(
                    res_op_array->oel_cg.class_table,
                    lcname, 
                    lcname_len, 
                    &ce, 
                    sizeof(zend_class_entry *),
                    NULL
                );
                efree(lcname);
                cont = 1;
                break;
            }
            
            case SERIALIZED_FUNCTION_ENTRY: {
                /* TODO */
                cont = 1;
                break;
            }
            
            case SERIALIZED_OP_ARRAY: {
                res_op_array->type= OEL_TYPE_OAR_BASE;
                res_op_array->merged = 0;
                unserialize_op_array(res_op_array->oel_cg.active_op_array UNSERIALIZE_CC);
                cont = 1;
                break;
            }
            
            case SERIALIZED_OP_END: {
                res_op_array->final = 1;
                cont = 0;
                break;
            }
            
            default: {
                fprintf(stderr, "No idea what %c(%d) is\n", item, item);
                fflush(stderr);
                php_oel_destroy_op_array(res_op_array TSRMLS_CC);
                res_op_array = NULL;
                cont = 0;
                break;
            }
        }
    }
}
/* }}} */

static int read_oel_header(php_stream *stream, zend_bool quiet TSRMLS_DC)
{
    char buf[SERIALIZED_HEADER_LENGTH]; 
    unsigned int hi, lo;

    memset(buf, 0, sizeof(buf));
    php_stream_read(stream, buf, SERIALIZED_HEADER_LENGTH);

    if (0 != strncmp(buf, SERIALIZED_HEADER, sizeof(SERIALIZED_HEADER)- 1)) {
        if (!quiet) {
            zend_error(E_WARNING, "Header mismatch, have <%s>, expecting <%s>", buf, SERIALIZED_HEADER);
        }
        return -1;
    }

    sscanf(buf, SERIALIZED_HEADER "%u.%u", &hi, &lo);
    return ((hi & 0xff) << 8) + (lo & 0xff);
}

/* {{{ proto int oel_read_header(resource stream)
   Reads an OEL header from a given stream and returns the version */
PHP_FUNCTION(oel_read_header) {
    zval              *resource;
    int               ver;
    php_stream        *stream;

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &resource) == FAILURE) { RETURN_NULL(); }
    php_stream_from_zval(stream, &resource);

    ver= read_oel_header(stream, 0 TSRMLS_CC);
    if (-1 == ver) {
        RETURN_FALSE;
    }
    
    RETVAL_LONG(ver);
}
/* }}} */

/* {{{ proto resource oel_read_op_array(resource stream)
   Reads an OEL op array from a given stream */
PHP_FUNCTION(oel_read_op_array) {
    zval              *resource;
    php_oel_op_array *res_op_array;

    php_stream        *stream;
    unsigned char     buf[8];
    zend_class_entry  *current_ce;

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &resource) == FAILURE) { RETURN_NULL(); }
    php_stream_from_zval(stream, &resource);
    
    res_op_array= oel_create_new_op_array(TSRMLS_C);
    current_ce = NULL;
    unserialize_oel_op_array(&res_op_array, current_ce, buf, stream TSRMLS_CC);
    if (NULL == res_op_array) {
        RETURN_NULL();
    }
    ZEND_REGISTER_RESOURCE(return_value, res_op_array, le_oel_oar);
}
/* }}} */

/* {{{ proto bool oel_eof(resource stream)
   Returns whether we're at the end of a given stream */
PHP_FUNCTION(oel_eof) {
    zval *resource;
    php_stream *stream;

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &resource) == FAILURE) { RETURN_NULL(); }
    php_stream_from_zval(stream, &resource);

    RETVAL_BOOL(php_stream_eof(stream));
}
/* }}} */

/* {{{ proto bool oel_write_header(resource stream)
   Writes the OEL header to a given stream */
PHP_FUNCTION(oel_write_header) {
    zval              *resource;
    char              *tmp;
    int               ver, len;
    php_stream        *stream;

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &resource) == FAILURE) { RETURN_NULL(); }
    php_stream_from_zval(stream, &resource);
    
    ver = SERIALIZED_VERSION;
    len = spprintf(&tmp, SERIALIZED_HEADER_LENGTH, SERIALIZED_HEADER "%u.%u<?php __HALT_COMPILER();", (ver >> 8) & 0xff, ver & 0xff);
    memset(tmp + len, 0, SERIALIZED_HEADER_LENGTH - len);
    php_stream_write(stream, tmp, SERIALIZED_HEADER_LENGTH);

    efree(tmp);
    RETURN_TRUE;
}
/* }}} */

/* {{{ proto bool oel_write_op_array(resource stream, resource op_array)
   Writes given op array to a given stream */
PHP_FUNCTION(oel_write_op_array) {
    zval              *arg_op_array, *resource;
    php_oel_op_array  *res_op_array;

    php_stream        *stream;
    unsigned char     buf[8];
    zend_class_entry  *current_ce;

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rz", &resource, &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);
    php_stream_from_zval(stream, &resource);

    current_ce = NULL;
    serialize_oel_op_array(res_op_array, current_ce, buf, stream TSRMLS_CC);

    RETURN_TRUE;
}
/* }}} */

/* {{{ proto bool oel_write_header(resource stream)
   Writes the OEL footer to a given stream */
PHP_FUNCTION(oel_write_footer) {
    zval              *resource;

    php_stream        *stream;
    unsigned char     buf[8];
    zend_class_entry  *current_ce;

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &resource) == FAILURE) { RETURN_NULL(); }
    php_stream_from_zval(stream, &resource);
    
    current_ce = NULL;
    serialize_char(0, current_ce, buf, stream TSRMLS_CC);
    RETURN_TRUE;
}
/* }}} */
