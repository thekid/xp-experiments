/* Forward declarations */
static void unserialize_oel_op_array(php_oel_op_array** res_op_array UNSERIALIZE_DC);
static int read_oel_header(php_stream *stream, zend_bool quiet TSRMLS_DC);

/* {{{ include() override */
static zend_op_array *oel_compile_file(zend_file_handle *file_handle, int type TSRMLS_DC)
{
    char *filename= NULL;
    php_stream *stream= NULL;
     
    if (file_handle->opened_path) {
        filename = file_handle->opened_path;
    } else { 
        filename = file_handle->filename;
    }

    /* Open file */    
    stream = php_stream_open_wrapper(filename, "rb", ENFORCE_SAFE_MODE | USE_PATH | IGNORE_URL_WIN | STREAM_OPEN_FOR_INCLUDE, NULL);
    if (!stream) {
        return NULL;
    }

    /* Check whether this is an OEL executable */
    if (- 1 == read_oel_header(stream, 1 TSRMLS_CC)) {
        zend_op_array *op_array = NULL;

        php_stream_rewind(stream);
        op_array = oel_saved_zend_compile_file(file_handle, type TSRMLS_CC);
        php_stream_close(stream);
        return op_array;
    } else {
        zend_op_array *op_array = (zend_op_array *) emalloc(sizeof(zend_op_array));
        zend_op_array *original_oel_op_array;
    
        php_oel_op_array *res_op_array;
        unsigned char     buf[8];
        zend_class_entry  *current_ce;

        init_op_array(op_array, ZEND_USER_FUNCTION, INITIAL_OP_ARRAY_SIZE TSRMLS_CC);

        /* Create OEL op array, but replace op_array by the one created here */
        res_op_array= oel_create_new_op_array(TSRMLS_C);
        original_oel_op_array = res_op_array->oel_cg.active_op_array; 
        res_op_array->oel_cg.active_op_array = op_array;
        current_ce = NULL;
        
        /* Unserialize op array */
        unserialize_oel_op_array(&res_op_array, current_ce, buf, stream TSRMLS_CC);
        php_stream_close(stream);
        
        if (NULL == res_op_array) {
            return NULL;
        }
        
        /* Merge class and function table */
        zend_hash_merge(EG(function_table), res_op_array->oel_cg.function_table, NULL, NULL, sizeof(zend_function),    0);
        zend_hash_merge(EG(class_table),    res_op_array->oel_cg.class_table,    NULL, NULL, sizeof(zend_class_entry), 0);
        
        /* Free OEL op array */
        res_op_array->oel_cg.active_op_array = original_oel_op_array;
        php_oel_destroy_op_array(res_op_array TSRMLS_CC);
        
        /* Verify consistency - every opcode array ends with RETURN @-2, HANDLE_EXCEPTION @-1 */
        if (op_array->last < 2 || op_array->opcodes[op_array->last- 2].opcode != ZEND_RETURN) {
            zend_error(E_COMPILE_ERROR, "Malformed opcode array read");
            return NULL;
        }

        /* Create a return 1; */
        op_array->opcodes[op_array->last- 2].op1.op_type = IS_CONST;
        op_array->opcodes[op_array->last- 2].op1.u.constant.type = IS_LONG;
        op_array->opcodes[op_array->last- 2].op1.u.constant.value.lval = 1;
        Z_SET_ISREF_TO(op_array->opcodes[op_array->last- 2].op1.u.constant, 0);
        Z_SET_REFCOUNT(op_array->opcodes[op_array->last- 2].op1.u.constant, 1);
        
        return op_array;
    }
}
/* }}} */
