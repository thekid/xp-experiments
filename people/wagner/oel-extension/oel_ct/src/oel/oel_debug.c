#include "opcodes.20071006.c"

void oel_add_next_index_opline(zval *result_arr, zend_op *opline TSRMLS_DC) {
    zval *oh_opline, *oh_opcode, *trans_arr, **opcode_mne;

    MAKE_STD_ZVAL(oh_opcode);
    MAKE_STD_ZVAL(oh_opline);
    MAKE_STD_ZVAL(trans_arr);

    array_init(trans_arr);
    fill_opcode_translation_array(trans_arr);
    zend_hash_index_find(Z_ARRVAL_P(trans_arr), opline->opcode, (void**)&opcode_mne);

    add_next_index_zval(result_arr, oh_opline);

    object_init_ex(oh_opline, php_oel_ce_opline);
    add_property_zval(oh_opline, "opcode", oh_opcode);
    Z_SET_REFCOUNT(*oh_opcode, 1);

    object_init_ex(oh_opcode, php_oel_ce_opcode);
    add_property_long(oh_opcode, "op", opline->opcode);
    add_property_stringl(oh_opcode, "mne", Z_STRVAL_PP(opcode_mne), Z_STRLEN_PP(opcode_mne), 1);

    zval_dtor(trans_arr);
    efree(trans_arr);
}

PHP_FUNCTION(oel_get_op_array) {
    zval              *arg_op_array;
    php_oel_op_array  *res_op_array;
    zend_op           *opline, *end;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &arg_op_array) == FAILURE) { RETURN_NULL(); }
    res_op_array= oel_fetch_op_array(arg_op_array TSRMLS_CC);

    array_init(return_value);

    opline= res_op_array->oel_cg.active_op_array->opcodes;
    end = opline + res_op_array->oel_cg.active_op_array->last;
    while (opline < end) {
        oel_add_next_index_opline(return_value, opline TSRMLS_CC);
        opline++;
    }
}

PHP_FUNCTION(oel_get_translation_array) {
    array_init(return_value);
    fill_opcode_translation_array(return_value);
}

