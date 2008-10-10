#ifndef PHP_OEL_COMMON_H
#define PHP_OEL_COMMON_H

    #define PHP_OEL_VERSION "1.0.1"
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

    typedef struct _php_oel_znode {
        znode *ext_var;
        int    type;
        struct _php_oel_znode *next_var;
    } php_oel_znode;

    typedef struct _php_oel_op_array {
        php_oel_znode *stack_extvar;
        php_oel_znode *stack_token;
        php_oel_znode *stack_operand;
        struct _php_oel_op_array *next;
        struct _php_oel_op_array *child;
        struct _php_oel_op_array *parent;
        int merged;
        int final;
        int type;

        struct {
            zend_op_array    *active_op_array;
            zend_class_entry *active_class_entry;
            znode             implementing_class;
            int               interactive;
            zend_stack        bp_stack;
            zend_stack        switch_cond_stack;
            zend_stack        foreach_copy_stack;
            zend_stack        list_stack;
            zend_llist        list_llist;
            zend_llist        dimension_llist;
            zend_stack        function_call_stack;
            HashTable         *function_table;
            HashTable         *class_table;
        } oel_cg;
    } php_oel_op_array;

    typedef struct _php_oel_saved_env {
        zend_bool         in_compilation;
        uint              zend_lineno;
        zend_op_array    *active_op_array;
        zend_class_entry *active_class_entry;
        znode             implementing_class;
        int               interactive;
        zend_stack        bp_stack;
        zend_stack        switch_cond_stack;
        zend_stack        foreach_copy_stack;
        zend_stack        list_stack;
        zend_llist        list_llist;
        zend_llist        dimension_llist;
        zend_stack        function_call_stack;
        HashTable         *function_table;
        HashTable         *class_table;
    } php_oel_saved_env;

#endif
