/*
   +----------------------------------------------------------------------+
   | PHP bcompiler Based on APC Cache                                     |
   +----------------------------------------------------------------------+
   | Copyright (c) 2000-2001 Community Connect, Inc. (apc_* functions)    |
   | Copyright (c) 1997-2003 The PHP Group (remaining code)               |
   +----------------------------------------------------------------------+
   | This source file is subject to version 2.02 of the PHP license,      |
   | that is bundled with this package in the file LICENSE, and is        |
   | available at through the world-wide-web at                           |
   | http://www.php.net/license/2_02.txt.                                 |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Authors: Alan Knowles <alan@akbkhome.com> (php module)               |
   | Daniel Cowgill <dan@mail.communityconnect.com>                       |
   | George Schlossnagle <george@lethargy.org>                            |
   | Mike Bretz <mike@metropolis-ag.de>                                   |
   +----------------------------------------------------------------------+
 */

/* $Id: php_bcompiler.h,v 1.25 2005/09/11 10:27:27 val Exp $ */

#include "ext/standard/file.h"
#ifndef PHP_BCOMPILER_H
#define PHP_BCOMPILER_H

extern zend_module_entry bcompiler_module_entry;
#define phpext_bcompiler_ptr &bcompiler_module_entry

#ifdef PHP_WIN32
#define PHP_BCOMPILER_API __declspec(dllexport)
#else
#define PHP_BCOMPILER_API
#endif

#ifdef ZTS
#include "TSRM.h"
#endif

 
PHP_MINIT_FUNCTION(bcompiler);
PHP_MSHUTDOWN_FUNCTION(bcompiler);
PHP_RINIT_FUNCTION(bcompiler);
PHP_RSHUTDOWN_FUNCTION(bcompiler);
PHP_MINFO_FUNCTION(bcompiler);



PHP_FUNCTION(bcompiler_write_class);               /* Write a class */
PHP_FUNCTION(bcompiler_write_function);            /* Write a function */
PHP_FUNCTION(bcompiler_write_constant);            /* Write a constant */
PHP_FUNCTION(bcompiler_write_functions_from_file); /* Write a bunch of functions */
PHP_FUNCTION(bcompiler_write_included_filename);   /* Add an entry to the included filename list*/
PHP_FUNCTION(bcompiler_write_header);     /* Write the header */
PHP_FUNCTION(bcompiler_write_exe_footer); /* Write the end zero byte */
PHP_FUNCTION(bcompiler_write_footer);     /* Write the tail for a exe type file*/
PHP_FUNCTION(bcompiler_read);             /* Read a file handle */
PHP_FUNCTION(bcompiler_load);             /* load a file  */
PHP_FUNCTION(bcompiler_load_exe);         /* loads an exe style file */
PHP_FUNCTION(bcompiler_parse_class);      /* callback opcodes for a class */
PHP_FUNCTION(bcompiler_write_file);       /* Write file opcodes */



/* 
  	Declare any global variables you may need between the BEGIN
	and END macros here:     
*/
ZEND_BEGIN_MODULE_GLOBALS(bcompiler)
	int enabled;                /* if true, bcompiler is enabled (defaults to true) */
    php_stream *stream;         /* output stream  */
    char* buffer;		        /* our read buffer */
    unsigned char _buf[8];      /* buffer for fixed-size data i/o */
    unsigned int buffer_size;   /* our read buffer's current size */
    zval* callback;             /* callback for parser */
    zval* callback_value;       /* callback for grouped calls */
    char* callback_key;         /* callback key for associated vals*/
    int current_version;        /* current bytecode version */
	int is_unicode;             /* reading a unicode-enabled bytecodes */
    int current_write;          /* write bytecode version */
    int current_include;        /* read file after bcompiler_write_file() */
    int parsing_error;          /* i/o error while parsing, skip file */
    const size_t *bcompiler_stdsize;  /* array of standard data sizes */
	zend_class_entry *cur_zc;   /* current class entry */
ZEND_END_MODULE_GLOBALS(bcompiler)
 
#include "zend.h"
#ifdef ZEND_ENGINE_2
#include "zend_API.h"

#endif
#include "zend_variables.h"	//  for zval_dtor() 
 
 
#ifdef ZTS
#define BCOMPILERG(v) TSRMG(bcompiler_globals_id, zend_bcompiler_globals *, v)
#else
#define BCOMPILERG(v) (bcompiler_globals.v)
#endif
 


 
/* By convention all apc_serialize_* functions serialize objects of the
 * specified type to the serialization buffer (dst). The apc_deserialize_*
 * functions deserialize objects of the specified type from the
 * deserialization buffer (src). The apc_create_* functions allocate
 * objects of the specified type, then call the appropriate deserialization
 * function. */
 
zend_op_array* bcompiler_read(TSRMLS_D);

/* general */
void		apc_serialize_string(char* string TSRMLS_DC);
void		apc_create_string(char** string TSRMLS_DC);
void		apc_serialize_zstring(char* string, int len TSRMLS_DC);
void		apc_create_zstring(char** string TSRMLS_DC);
void		apc_serialize_arg_types(zend_uchar* arg_types TSRMLS_DC);
void		apc_create_arg_types(zend_uchar** arg_types TSRMLS_DC);

/* pre-bcompiler routines */
void		serialize_magic(int ver TSRMLS_DC);
int		deserialize_magic(TSRMLS_D);

/* routines for handling structures from zend_llist.h */

void		apc_serialize_zend_llist(zend_llist* list TSRMLS_DC);
void		apc_deserialize_zend_llist(zend_llist* list TSRMLS_DC);
void		apc_create_zend_llist(zend_llist** list TSRMLS_DC);

/* routines for handling structures from zend_hash.h */

void		apc_serialize_hashtable(HashTable* ht, void* funcptr TSRMLS_DC);
void		apc_deserialize_hashtable(HashTable* ht, void* funcptr, void* dptr, int datasize, char exists TSRMLS_DC);
void		apc_create_hashtable(HashTable** ht, void* funcptr, void* dptr, int datasize TSRMLS_DC);

/* routines for handling structures from zend.h */

void		apc_serialize_zvalue_value(zvalue_value* zvv, int type, znode *zn TSRMLS_DC);
void		apc_deserialize_zvalue_value(zvalue_value* zvv, int type, znode *zn TSRMLS_DC);


void		apc_serialize_zval_ptr(zval** zv TSRMLS_DC);
void		apc_serialize_zval(zval* zv, znode *zn TSRMLS_DC);
void		apc_deserialize_zval(zval* zv, znode *zn TSRMLS_DC);
void		apc_create_zval(zval** zv TSRMLS_DC);

void		apc_serialize_zend_function_entry(zend_function_entry * zfe TSRMLS_DC);
void		apc_deserialize_zend_function_entry(zend_function_entry* zfe TSRMLS_DC);

#ifndef ZEND_ENGINE_2
/*  property / overload not used? */

void		apc_serialize_zend_property_reference(zend_property_reference* zpr TSRMLS_DC);
void		apc_deserialize_zend_property_reference(zend_property_reference* zpr TSRMLS_DC);

void		apc_serialize_zend_overloaded_element(zend_overloaded_element* zoe TSRMLS_DC);
void		apc_deserialize_zend_overloaded_element(zend_overloaded_element* zoe TSRMLS_DC);

#endif

void		apc_serialize_zend_class_entry(zend_class_entry* zce, char* force_parent_name, int force_parent_len, char* force_key, int force_key_len  TSRMLS_DC);
void		apc_deserialize_zend_class_entry(zend_class_entry* zce, char** key, int* key_len TSRMLS_DC);
void		apc_create_zend_class_entry(zend_class_entry** zce, char** key, int* key_len TSRMLS_DC);


/* routines for handling structures from zend_compile.h */

void		apc_serialize_znode(znode* zn TSRMLS_DC);
void		apc_deserialize_znode(znode* zn TSRMLS_DC);

void		apc_serialize_zend_op(int i, zend_op* zo, zend_op_array* zoa TSRMLS_DC);
void		apc_deserialize_zend_op(zend_op* zo, zend_op_array* zoa TSRMLS_DC);

void		apc_serialize_zend_op_array(zend_op_array* zoa TSRMLS_DC);
void		apc_deserialize_zend_op_array(zend_op_array* zoa, int master TSRMLS_DC);
void		apc_create_zend_op_array(zend_op_array** zoa TSRMLS_DC);

void		apc_serialize_zend_internal_function(zend_internal_function* zif TSRMLS_DC);
void		apc_deserialize_zend_internal_function(zend_internal_function* zif TSRMLS_DC);
/*
void		apc_serialize_zend_overloaded_function(zend_overloaded_function* zof TSRMLS_DC);
void		apc_deserialize_zend_overloaded_function(zend_overloaded_function* zof TSRMLS_DC);
*/
void		apc_serialize_zend_function(zend_function* zf TSRMLS_DC);
int			apc_deserialize_zend_function(zend_function* zf TSRMLS_DC);
void		apc_create_zend_function(zend_function** zf TSRMLS_DC);
void		apc_free_zend_function(zend_function** zf TSRMLS_DC);

 

/* functions which are not really part of APC */
 
void		apc_serialize_zend_constant(zend_constant* zc TSRMLS_DC);
void		apc_deserialize_zend_constant(zend_constant* zc TSRMLS_DC);
void		apc_create_zend_constant(zend_constant** zc TSRMLS_DC);


#endif	/* PHP_BCOMPILER_H */

 
