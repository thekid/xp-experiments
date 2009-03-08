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
	stream = php_stream_open_wrapper(filename, "rb", ENFORCE_SAFE_MODE | USE_PATH | IGNORE_URL_WIN | STREAM_OPEN_FOR_INCLUDE, &(file_handle->opened_path));
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
        php_oel_op_array *res_op_array;
        unsigned char     buf[8];
        zend_class_entry  *current_ce;

        res_op_array= oel_create_new_op_array(TSRMLS_C);
        current_ce = NULL;
        
        /* Unserialize op array, finalize it */
        unserialize_oel_op_array(&res_op_array, current_ce, buf, stream TSRMLS_CC);
        
        /* Prepare for execution */
        zend_hash_merge(EG(function_table), res_op_array->oel_cg.function_table, NULL, NULL, sizeof(zend_function),    0);
        zend_hash_merge(EG(class_table),    res_op_array->oel_cg.class_table,    NULL, NULL, sizeof(zend_class_entry), 0);

        php_stream_close(stream);
        return res_op_array->oel_cg.active_op_array;
    }
}
/* }}} */
