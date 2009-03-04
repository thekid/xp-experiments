#define SERIALIZE_DC , zend_class_entry *__se_class, unsigned char __se_buffer[8], php_stream *__se_stream TSRMLS_DC
#define SERIALIZE_CC , __se_class, __se_buffer, __se_stream TSRMLS_CC

#define UNSERIALIZE_DC , zend_class_entry *__se_class, unsigned char __se_buffer[8], php_stream *__se_stream TSRMLS_DC
#define UNSERIALIZE_CC , __se_class, __se_buffer, __se_stream TSRMLS_CC

#define SERIALIZE(value, type) \
    memset(__se_buffer, 0, sizeof(__se_buffer)); \
    *((type*)__se_buffer) = value;                \
    php_stream_write(__se_stream, __se_buffer, __se_sizes[SESI_##type]);

#define WRITE(bytes, length) \
    php_stream_write(__se_stream, (char*)bytes, length);

#define DESERIALIZE(value, type) \
    memset(__se_buffer, 0, sizeof(__se_buffer)); \
    php_stream_read(__se_stream, __se_buffer, __se_sizes[SESI_##type]); \
    *(value) = *((type*) __se_buffer); 

#define READ(bytes, length) \
    php_stream_read(__se_stream, (bytes), length); \
    (bytes)[length]= '\0';

#define SERIALIZED_CLASS_ENTRY 1
#define SERIALIZED_FUNCTION_ENTRY 3
#define SERIALIZED_OP_ARRAY 9

#define SERIALIZED_VERSION 0x000e
#define SERIALIZED_HEADER "OELMZ"

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
static void serialize_class_entry(zend_class_entry* ce, char *force_parent_name, int force_parent_len, char *force_key, int force_key_len SERIALIZE_DC);
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
        special |= 0x001;
    } else if (function == __se_class->destructor) {
        special |= 0x002;
    } else if (function == __se_class->clone) {
        special |= 0x004;
    } else if (function == __se_class->__get) {
        special |= 0x008;
    } else if (function == __se_class->__set) {
        special |= 0x010;
    } else if (function == __se_class->__call) {
        special |= 0x020;
    } else if (function == __se_class->__unset) {
        special |= 0x040;
    } else if (function == __se_class->__isset) {
        special |= 0x080;
    } else if (function == __se_class->serialize_func) {
        special |= 0x100;
    } else if (function == __se_class->unserialize_func) {
        special |= 0x200;
    } else if (function == __se_class->__tostring) {
        special |= 0x400;
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


static void serialize_class_entry(zend_class_entry *ce, char *force_parent_name, int force_parent_len, char *force_key, int force_key_len SERIALIZE_DC) 
{
    int i, count;

	SERIALIZE(ce->type, char);
    serialize_stringl(ce->name, ce->name_length SERIALIZE_CC);
	SERIALIZE(ce->name_length, uint);

    if (NULL != ce->parent) {
        SERIALIZE(1, char);
        serialize_stringl(ce->parent->name, ce->parent->name_length SERIALIZE_CC);
    } else if (force_parent_len > 0) {
        SERIALIZE(1, char);
        serialize_stringl(force_parent_name, force_parent_len SERIALIZE_CC);
    } else {
        SERIALIZE(0, char);
    }
    
    SERIALIZE(ce->refcount, int);
    SERIALIZE(ce->constants_updated, zend_bool);
	SERIALIZE(ce->ce_flags, zend_uint);

    __se_class= ce;
	serialize_hashtable(&ce->function_table, serialize_method SERIALIZE_CC);
	serialize_hashtable(&ce->default_properties, serialize_zval_ptr SERIALIZE_CC);
	serialize_hashtable(&ce->properties_info, serialize_property_info SERIALIZE_CC);
	serialize_hashtable(&ce->default_static_members, serialize_zval_ptr SERIALIZE_CC);
	serialize_hashtable(NULL, serialize_zval_ptr SERIALIZE_CC);   /* Static members */
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
    
    /* handle_function, handle_property_get, handle_property_set */
    SERIALIZE(0, ulong);
    SERIALIZE(0, ulong);
    SERIALIZE(0, ulong);

    /* Interfaces */    
    SERIALIZE(ce->num_interfaces, zend_uint);

    __se_class= NULL;
    
    if (force_key_len > 0) {
        SERIALIZE(force_key_len, char);
        serialize_stringl(force_key, force_key_len SERIALIZE_CC);
    } else {
        SERIALIZE(0, char);
    }
}

static void serialize_oel_op_array(php_oel_op_array  *oel_op_array SERIALIZE_DC) 
{
    int i;
    zend_op *opline, *orig_opcodes;
    zend_function *fe=     NULL;
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
            serialize_class_entry(*ce, NULL, 0, NULL, 0 SERIALIZE_CC);
            opline->opcode= ZEND_NOP;
        } else if (opline->opcode == ZEND_DECLARE_FUNCTION) {
            if (FAILURE == zend_hash_find(oel_op_array->oel_cg.function_table, opline->op1.u.constant.value.str.val, opline->op1.u.constant.value.str.len, (void **)&fe)) {
                zend_error(E_COMPILE_ERROR, "Error - Can't find function %s", opline->op2.u.constant.value.str.val);
                return;
            }
            SERIALIZE(SERIALIZED_FUNCTION_ENTRY, char)
            serialize_function(fe SERIALIZE_CC);
            opline->opcode= ZEND_NOP;
        }
    }
    /* serialize main opcode array */
    SERIALIZE(SERIALIZED_OP_ARRAY, char);
    serialize_op_array(oel_op_array->oel_cg.active_op_array SERIALIZE_CC);
    efree(oel_op_array->oel_cg.active_op_array->opcodes);
    oel_op_array->oel_cg.active_op_array->opcodes= orig_opcodes;
}
/* }}} */

/* {{{ deserialization */
static void unserialize_op_array(zend_op_array* op_array UNSERIALIZE_DC)
{
	int i;

    DESERIALIZE(&op_array->type, zend_uchar);       
}

static void unserialize_string(char **string UNSERIALIZE_DC)
{
    int len;

    DESERIALIZE(&len, int);
    if (-1 == len) {
        *string = NULL;
    }

    *string = (char*) emalloc(len + 1);
    READ(*string, len);
}

static void unserialize_class_entry(zend_class_entry* ce UNSERIALIZE_DC)
{
    DESERIALIZE(&ce->type, char);
    unserialize_string(&ce->name UNSERIALIZE_CC);
    DESERIALIZE(&ce->name_length, uint);
    
    fprintf(stderr, "Class named %s\n", ce->name);
}

static void unserialize_oel_op_array(php_oel_op_array* res_op_array UNSERIALIZE_DC)
{
    char item;
    int cont;

    cont = 1;
    while (cont) {
        DESERIALIZE(&item, char);
        switch (item) {
            case SERIALIZED_CLASS_ENTRY: {
                zend_class_entry *ce;
                
                ce = (zend_class_entry*) emalloc(sizeof(zend_class_entry));
                unserialize_class_entry(ce UNSERIALIZE_CC);
                cont = 1;
                break;
            }
            
            case SERIALIZED_FUNCTION_ENTRY: {
                fprintf(stderr, "FOUND A FUNCTION\n");
                /* TODO */
                cont = 1;
                break;
            }
            
            case SERIALIZED_OP_ARRAY: {
                fprintf(stderr, "FOUND <main>\n");
                unserialize_op_array(res_op_array->oel_cg.active_op_array UNSERIALIZE_CC);
                cont = 0;
                break;
            }
            
            default: {
                fprintf(stderr, "No idea what %c(%d) is\n", item, item);
                cont = 0;
                break;
            }
        }
    }
}
/* }}} */

static int read_oel_header(php_stream *stream, zend_bool quiet TSRMLS_DC)
{
    char buf[33]; 
	unsigned int hi, lo;

    memset(buf, 0, sizeof(buf));
    php_stream_read(stream, buf, sizeof(buf)- 1);

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
    unserialize_oel_op_array(res_op_array, current_ce, buf, stream TSRMLS_CC);
    ZEND_REGISTER_RESOURCE(return_value, res_op_array, le_oel_oar);
}
/* }}} */

/* {{{ proto bool oel_eof(resource stream)
   Returns whether we're at the end of a given stream */
PHP_FUNCTION(oel_eof) {
    zval *resource;
    php_stream *stream;
    php_oel_op_array *res_op_array;

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &resource) == FAILURE) { RETURN_NULL(); }
    php_stream_from_zval(stream, &resource);

    /* XXX */
    RETURN_TRUE;
}
/* }}} */

/* {{{ proto bool oel_write_header(resource stream)
   Writes the OEL header to a given stream */
PHP_FUNCTION(oel_write_header) {
    zval              *resource;
    char              *tmp;
    int               ver;
    php_stream        *stream;

    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &resource) == FAILURE) { RETURN_NULL(); }
    php_stream_from_zval(stream, &resource);
    
    ver = SERIALIZED_VERSION;
    spprintf(&tmp, 32, SERIALIZED_HEADER "%u.%u", (ver >> 8) & 0xff, ver & 0xff);
    
    php_stream_write(stream, tmp, 32);

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
