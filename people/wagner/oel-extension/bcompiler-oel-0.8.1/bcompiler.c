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
   |          val khokhlov <val@php.net> (php module)                     |
   |          Daniel Cowgill <dan@mail.communityconnect.com>              |
   |          George Schlossnagle <george@lethargy.org>                   |
   |          Mike Bretz <mike@metropolis-ag.de>                          |
   +----------------------------------------------------------------------+
 */
/* $Id$ */
 
#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "ext/standard/file.h"
#include "zend.h"
#include "zend_extensions.h"
#if (PHP_MAJOR_VERSION == 5 && PHP_MINOR_VERSION >= 1) || PHP_MAJOR_VERSION >= 6
#define ZEND_ENGINE_2_1
#include "zend_vm.h"
#endif
#include "php_bcompiler.h"

#include <stdlib.h>
#ifndef PHP_WIN32
#include <bzlib.h>
#endif

/* OEL */
#include "../oel/php_oel_common.h"
PHP_FUNCTION(bcompiler_write_oel_oparray);

int le_oel_oar;
/* END OEL */

/* this should be in php.h #include <assert.h> */

/* defines if this module is built with zend sources */
#if !defined(PHP_WIN32) || defined(VK_DEBUG_BUILD)
#define BUILD_WITH_ZEND
#endif

#if PHP_MAJOR_VERSION >= 6
# define ZS2S(zstr) ((zstr).s)
#else
# define ZS2S(zstr) (zstr)
#endif

/* Define the header & version */

#define BCOMPILER_VERSION "0.8"
#define BCOMPILER_STREAMS "s"
#define BCOMPILER_UNICODE "u"
#ifndef PHP_HAVE_STREAMS
# error You lose - you must have stream support in your PHP
#endif
#define BCOMPILER_MAGIC_START "bcompiler v"
#define BCOMPILER_MAGIC_HEADER BCOMPILER_MAGIC_START  BCOMPILER_VERSION  BCOMPILER_STREAMS

/* Bytecode version parameters */
#if PHP_MAJOR_VERSION >= 6
#define BCOMPILER_CUR_VER  0x000f /* current bytecode version: 0.15 */
#define BCOMPILER_CAN_READ 10, 15     /* can read bytecodes: 0.10, 0.15 */
#elif defined(ZEND_ENGINE_2_1)
#define BCOMPILER_CUR_VER  0x000e /* current bytecode version: 0.14 */
#define BCOMPILER_CAN_READ 7, 9, 11, 12, 14 /* can read bytecodes: 0.7, 0.9, 0.11, 0.12, 0.14 */
#elif defined(ZEND_ENGINE_2)
#define BCOMPILER_CUR_VER  0x000d /* current bytecode version: 0.13 */
#define BCOMPILER_CAN_READ 4, 6, 8, 13 /* can read bytecodes: 0.4, 0.6, 0.8, 0.13 */
#else
#define BCOMPILER_CUR_VER  0x0005 /* current bytecode version: 0.5 */
#define BCOMPILER_CAN_READ 3, 5 /* can read bytecodes: 0.3, 0.5 */
#endif

/* Debugging */

/* define BCOMPILER_DEBUG_FILE to log debug info into file */
#define BCOMPILER_DEBUG_FILE "bcompiler.log"
#define BCOMPILER_DEBUG_ON 0
#define BCOMPILER_DEBUGFULL_ON 0

#if BCOMPILER_DEBUG_ON
#define BCOMPILER_DEBUG(args)  bcompiler_debug args
#else
#define BCOMPILER_DEBUG(args)  
#endif
#if BCOMPILER_DEBUGFULL_ON
#define BCOMPILER_DEBUGFULL(args)  bcompiler_debug args
#define BCOMPILER_DUMPFULL bcompiler_dump
#else
#define BCOMPILER_DEBUGFULL(args)  
#define BCOMPILER_DUMPFULL(string,len)
#endif

#if BCOMPILER_DEBUG_ON || BCOMPULER_DEBUGFULL_ON
static FILE *DF = NULL;

void bcompiler_debug(const char *s, ...) {
  va_list va;

#ifdef BCOMPILER_DEBUG_FILE
  if (!DF) DF = fopen(BCOMPILER_DEBUG_FILE, "w");
#else
  if (!DF) DF = stderr;
#endif
  if (s && DF) {
    va_start(va, s);
    fputs("[DEBUG] ", DF);
    vfprintf(DF, s, va);
    va_end(va);
  }
#ifdef BCOMPILER_DEBUG_FILE
  if (DF) { if (!s) fclose(DF); else fflush(DF); }
#endif
}

void bcompiler_dump(const char *s, size_t n) {
  size_t i = 0, k;
  char t[17], x[49];

  if (!DF) return;
  while (i < n) {
    fputs("[DEBUG] DUMP: ", DF);
    memset(x, ' ', 48);
    k = 0;
    while (k < 16 && i < n) {
      t[k] = (s[i] != 0 && s[i] != '\n' ? s[i] : '.');
      sprintf(x + 3*k, "%02X", s[i]);
      x[3*k + 2] = ' ';
      i++; k++;
    }
    t[k] = x[48] = '\0';
    fputs(x, DF);
    fputs(t, DF);
    fputs("\n", DF);
  }
}
#endif

/* we use globals */
ZEND_DECLARE_MODULE_GLOBALS(bcompiler)

extern ZEND_API zend_op_array *(*zend_compile_file)(zend_file_handle *file_handle, int type TSRMLS_DC);
static zend_op_array *(*bcompiler_saved_zend_compile_file)(zend_file_handle *file_handle, int type TSRMLS_DC);
static void* (*apc_hook)(void *) = NULL;

static int bcompiler_can_read[] = { BCOMPILER_CAN_READ }; /* can read array */

/* {{{ bcompiler_functions[]
 *
 * All the functions in bcompiler
 */
function_entry bcompiler_functions[] = {
	PHP_FE(bcompiler_write_header,              NULL)
	PHP_FE(bcompiler_write_class,               NULL)
	PHP_FE(bcompiler_write_function,            NULL)
	PHP_FE(bcompiler_write_constant,            NULL)
	PHP_FE(bcompiler_write_functions_from_file, NULL)
	PHP_FE(bcompiler_write_included_filename,   NULL)
	PHP_FE(bcompiler_write_footer,              NULL)
	PHP_FE(bcompiler_write_exe_footer,          NULL)
	PHP_FE(bcompiler_read,                      NULL)
	PHP_FE(bcompiler_load,                      NULL)
	PHP_FE(bcompiler_load_exe,                  NULL)
	PHP_FE(bcompiler_parse_class,               NULL)
	PHP_FE(bcompiler_write_file,                NULL)
    /* OEL */
	PHP_FE(bcompiler_write_oel_oparray,         NULL)
    /* END OEL */
	{NULL, NULL, NULL} 
};
/* }}} */

/* {{{ bcompiler_module_entry
 */
zend_module_entry bcompiler_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
	STANDARD_MODULE_HEADER,
#endif
	"bcompiler",
	bcompiler_functions,
	PHP_MINIT(bcompiler),
	PHP_MSHUTDOWN(bcompiler),
	PHP_RINIT(bcompiler),        
	PHP_RSHUTDOWN(bcompiler),    
	PHP_MINFO(bcompiler),
#if ZEND_MODULE_API_NO >= 20010901
	BCOMPILER_VERSION  BCOMPILER_STREAMS, /* Replace with version number for your extension */
#endif
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_BCOMPILER
ZEND_GET_MODULE(bcompiler)
#endif

/* ran out of other ideas on how to make these work */
 

ZEND_DLEXPORT int bcompiler_zend_startup(zend_extension *extension)
{
	return zend_startup_module(&bcompiler_module_entry);
}

ZEND_DLEXPORT void bcompiler_zend_shutdown(zend_extension *extension)
{

}

#ifndef ZEND_EXT_API
#define ZEND_EXT_API      ZEND_DLEXPORT
#endif
ZEND_EXTENSION();

ZEND_DLEXPORT zend_extension zend_extension_entry = {
	"bcompiler",
	BCOMPILER_VERSION,
	"Alan Knowles and val khokhlov (php_module), Dan Cowgill and George Schlossnagle",
	"http://apc.communityconnect.com, http://www.php.net", 
	"Copyright (c) 2000-2001 Community Connect Inc. (apc_* functions), 1997-2002 The PHP Group (remaining code)",
	bcompiler_zend_startup,
	bcompiler_zend_shutdown,
	NULL, /* activate_func_t */
	NULL, /* deactivate_func_t */
	NULL, /* message_handler_func_t */
	NULL, /* op_array_handler_func_t */
	NULL, /* statement_handler_func_t */
	NULL, /* fcall_begin_handler_func_t */
	NULL, /* fcall_end_handler_func_t */
	NULL, /* op_array_ctor_func_t */
	NULL, /* op_array_dtor_func_t */
#ifdef COMPAT_ZEND_EXTENSION_PROPERTIES
	NULL, /* api_no_check */
	COMPAT_ZEND_EXTENSION_PROPERTIES
#else
	STANDARD_ZEND_EXTENSION_PROPERTIES
#endif
};

/* {{{ 
 */
zend_op_array *dummy_op_array(TSRMLS_D) {
	zval *zstring = NULL;
	char *eval_desc = NULL;
	zend_op_array *result = NULL;
	zend_op_array *original_active_op_array = CG(active_op_array);
	zend_bool original_in_compilation = CG(in_compilation);
	char *compiled_filename = CG(compiled_filename);
//	TSRMLS_FETCH();

	CG(in_compilation) = 1;
	CG(active_op_array) = result;
	CG(compiled_filename) = "bcompiler code";

	MAKE_STD_ZVAL(zstring);
	ZVAL_STRING(zstring, "return true;", 1); 
	eval_desc = zend_make_compiled_string_description("compiled code" TSRMLS_CC);
	result = compile_string(zstring, eval_desc TSRMLS_CC);
	efree(eval_desc);
	zval_dtor(zstring);
	FREE_ZVAL(zstring);

	CG(in_compilation) = original_in_compilation;
	CG(active_op_array) = original_active_op_array;
	CG(compiled_filename) = compiled_filename;

	return result;
}
/* }}} */

static int is_valid_file_name(char *filename)
{
int len = strlen(filename);

	if (len == 0) { // empty filenames are invalid
		return 0;
	}
	if (strncasecmp(filename, "http://", 7) == 0) {
		return 0;
	}
	if (strncmp(filename + len - 1, "-", 1) == 0) {
		return 0;
 	}
	return 1;
}

static inline int has_gzip_stream_support(TSRMLS_D)
{
	return php_stream_locate_url_wrapper("compress.zlib://", NULL, STREAM_LOCATE_WRAPPERS_ONLY TSRMLS_CC) != NULL;
}
static inline int has_bzip2_stream_support(TSRMLS_D)
{
	return php_stream_locate_url_wrapper("compress.bzip2://", NULL, STREAM_LOCATE_WRAPPERS_ONLY TSRMLS_CC) != NULL;
}

static php_stream *bz2_aware_stream_open(char *file_name, int use_bz, char **opened_path TSRMLS_DC)
{
	php_stream *stream;
       	char *path_to_open;
	unsigned char magic[2];
	static int has_gz = -1, has_bz = -1;

	if (has_gz == -1) has_gz = has_gzip_stream_support(TSRMLS_C);
	if (has_bz == -1) has_bz = has_bzip2_stream_support(TSRMLS_C);

	/* try to read magic */
	stream = php_stream_open_wrapper(file_name, "rb", ENFORCE_SAFE_MODE|USE_PATH|IGNORE_URL_WIN|STREAM_OPEN_FOR_INCLUDE, opened_path);
	if (!stream) {
		BCOMPILER_DEBUG(("error opening file '%s'..\n", file_name));
		return stream;
	}
	php_stream_read(stream, magic, sizeof(magic));
	BCOMPILER_DEBUG(("read magic: %02x %02x..\n", magic[0], magic[1]));

	/* it's a bzip2 compressed file */
	if (magic[0] == 'B' && magic[1] == 'Z') {
		php_stream_close(stream);
		if (!has_bz || !use_bz) {
			BCOMPILERG(parsing_error) = 1;
			BCOMPILER_DEBUG(("no bz2 support, giving up..\n"));
			return NULL; 
		}

		BCOMPILER_DEBUG(("got bz2 support - opening '%s'\n", file_name));
		spprintf(&path_to_open, 0, "compress.bzip2://%s", file_name);
		stream = php_stream_open_wrapper(path_to_open, "rb", ENFORCE_SAFE_MODE | REPORT_ERRORS, NULL);
		efree(path_to_open);
		BCOMPILER_DEBUG(("returning stream (%p)..\n", stream));
		return stream;
	}
	/* it's a gzip compressed file */
	if (magic[0] == 0x1f && magic[1] == 0x8b) {
		php_stream_close(stream);
		if (!has_gz || !use_bz) {
			BCOMPILERG(parsing_error) = 1;
			BCOMPILER_DEBUG(("no gzip support, giving up..\n"));
			return NULL; 
		}

		BCOMPILER_DEBUG(("got gzip support - opening '%s'\n", file_name));
		spprintf(&path_to_open, 0, "compress.zlib://%s", file_name);
		stream = php_stream_open_wrapper(path_to_open, "rb", ENFORCE_SAFE_MODE | REPORT_ERRORS, NULL);
		efree(path_to_open);
		BCOMPILER_DEBUG(("returning stream (%p)..\n", stream));
		return stream;
	}
	/* uncompressed file */
	php_stream_rewind(stream);
	return stream;
}

/*
	type
	ZEND_EVAL           1<<0
	ZEND_INCLUDE        1<<1
	ZEND_INCLUDE_ONCE   1<<2
	ZEND_REQUIRE        1<<3
	ZEND_REQUIRE_ONCE   1<<4
*/
zend_op_array *bcompiler_compile_file(zend_file_handle *file_handle, int type TSRMLS_DC)
{
	int test = -1;
	php_stream *stream = NULL;
	zend_op_array *op_array = NULL;
	char *filename = NULL;
	 
	if (!BCOMPILERG(enabled)) {
		BCOMPILER_DEBUGFULL(("bcompiler disabled - passing through\n"));
		return bcompiler_saved_zend_compile_file(file_handle, type TSRMLS_CC);
	}

	test = -1; BCOMPILERG(parsing_error) = 0;
#if 0 /* val: it seems type doesn't matter */
	switch(file_handle->type)
	{
	case ZEND_HANDLE_FILENAME: /* 0 */
	case ZEND_HANDLE_FD: /* 1 */
	case ZEND_HANDLE_FP: /* 2 */
#endif
		if(file_handle->opened_path) {
			filename = file_handle->opened_path;
		} else { 
			filename = file_handle->filename;
		}
		if (is_valid_file_name(filename)) {
			stream = bz2_aware_stream_open(filename, 1, &(file_handle->opened_path) TSRMLS_CC);
		}
#if 0 /* val: it seems type doesn't matter */
		break;

	case ZEND_HANDLE_STDIOSTREAM: /* 3 */
		break;

	case ZEND_HANDLE_FSTREAM: /* 4 */
		break;
	}
#endif
	/* stream is ok */
	if (stream) {
		BCOMPILERG(stream) = stream;
		test = deserialize_magic(TSRMLS_C);
	}
	/* compressed stream and no decompression supported */
	else if (BCOMPILERG(parsing_error)) {
		php_error(E_WARNING, "bcompiler: Unable to open or can't decompress stream"); 
		return op_array;
	}
	/* we can't handle this type, so use fallback */
	else {
		BCOMPILER_DEBUGFULL((" *** error opening file, using fallback zend_compile_file()\n"));
		op_array = bcompiler_saved_zend_compile_file(file_handle, type TSRMLS_CC);
		return op_array;
	}
	/* can parse bytecodes */
	if (test == 0) {
		/* add file_handle to open_file so that zend will free it */
		if ( !(file_handle->type == ZEND_HANDLE_FP && file_handle->handle.fp == stdin) &&
		     !(file_handle->type == ZEND_HANDLE_FD && file_handle->handle.fd == STDIN_FILENO) 
		   ) zend_llist_add_element(&CG(open_files), file_handle);
		/* to make APC happy */
		if (!file_handle->opened_path)
			file_handle->opened_path = estrdup(file_handle->filename);
		/* read bytecodes */
		BCOMPILERG(current_include) = 1;
		op_array = bcompiler_read(TSRMLS_C);
		if (!op_array) op_array = dummy_op_array(TSRMLS_C);
#if 0 /* val: buffer allocation changed, so it can't be used anymore */
		BCOMPILERG(buffer) = (char *) emalloc(1); /* avoid 1 byte memory leak */
#endif
#if PHP_MAJOR_VERSION >= 6
	/* unicode modes don't match */
	} else if (test == -2) {
		php_error(E_WARNING, "bcompiler: Can't parse bytecodes created in %sunicode mode", UG(unicode) ? "non-" : ""); 
		op_array = dummy_op_array(TSRMLS_C);
#endif
	/* no bcompiler magic - just pass it to zend... */
	} else {
		op_array = bcompiler_saved_zend_compile_file(file_handle, type TSRMLS_CC);
	}

	if(stream) {
		php_stream_close(stream);
	}
	return op_array;
}
 

#ifdef ZEND_ENGINE_2
#define OnUpdateInt OnUpdateLong
#endif
/* {{{ PHP_INI */
PHP_INI_BEGIN()
STD_PHP_INI_BOOLEAN("bcompiler.enabled", "1", PHP_INI_ALL, OnUpdateInt, enabled, zend_bcompiler_globals, bcompiler_globals)
PHP_INI_END()
/* }}} */


/* Standard scalar type sizes and debug format */

#define BCSD_int	"%08x"
#define BCSD_long	"%08x"
#define BCSD_char	"%02x"
#define BCSD_double	"%d"
#define BCSD_size_t	"%08x"

#define BCSD_uint	"%08x"
#define BCSD_ulong	"%08x"

#define BCSD_zend_uint	"%08x"
#define BCSD_zend_ushort "%04x"
#define BCSD_zend_bool	"%d"
#define BCSD_zend_uchar	"%02x"

enum {
	BCSI_int, BCSI_long, BCSI_char, BCSI_double, BCSI_size_t,
	BCSI_uint, BCSI_ulong,
	BCSI_zend_uint, BCSI_zend_ushort, BCSI_zend_bool, BCSI_zend_uchar
     };
static const size_t bcompiler_stdsize_03[] = {4,4,4,8,4, 4,4, 4,4,4,4};
#ifdef __x86_64__
static const size_t bcompiler_stdsize_05[] = {8,8,1,8,8, 8,8, 8,2,1,1};
#else
static const size_t bcompiler_stdsize_05[] = {4,4,1,8,4, 4,4, 4,2,1,1};
#endif


/* {{{ php_bcompiler_init_globals
 */
static void php_bcompiler_init_globals(zend_bcompiler_globals *bcompiler_globals)
{
	
#if 0 /* val: buffer allocation changed, so it can't be used anymore */
	bcompiler_globals->buffer = (char*) emalloc(1);
#endif
	bcompiler_globals->stream = NULL;
	bcompiler_globals->callback = NULL;
	bcompiler_globals->callback_value = NULL;
	bcompiler_globals->callback_key = "NONE";
	bcompiler_globals->current_version = BCOMPILER_CUR_VER;
	bcompiler_globals->is_unicode = 0;
	bcompiler_globals->current_write   = BCOMPILER_CUR_VER;
	bcompiler_globals->current_include = 0;
	bcompiler_globals->parsing_error   = 0;
	bcompiler_globals->bcompiler_stdsize = bcompiler_stdsize_05;
	bcompiler_globals->cur_zc = NULL;
}

/* }}} */

/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(bcompiler)
{
	zend_module_entry *apc_lookup;
	zend_constant *apc_magic;
	 
	ZEND_INIT_MODULE_GLOBALS(bcompiler, php_bcompiler_init_globals, NULL);
    REGISTER_INI_ENTRIES();

	if (BCOMPILERG(enabled)) {
		if (zend_hash_find(&module_registry, "apc", sizeof("apc"), (void**)&apc_lookup) != FAILURE &&
			zend_hash_find(EG(zend_constants), "\000apc_magic", 11, (void**)&apc_magic) != FAILURE) {
			apc_hook = (void* (*)(void*))apc_magic->value.value.lval;
			bcompiler_saved_zend_compile_file = apc_hook(NULL);
			apc_hook(bcompiler_compile_file);
		} else {
			bcompiler_saved_zend_compile_file = zend_compile_file;
			zend_compile_file = bcompiler_compile_file;
		}
	}
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MSHUTDOWN_FUNCTION
 */
PHP_MSHUTDOWN_FUNCTION(bcompiler)
{
	if (BCOMPILERG(enabled)) {
		if (apc_hook)
			apc_hook(bcompiler_saved_zend_compile_file);
		else
			zend_compile_file = bcompiler_saved_zend_compile_file;
#if BCOMPILER_DEBUG_ON || BCOMPILER_DEBUGFULL_ON
		/* close debug log */
		bcompiler_debug(NULL);
#endif
	}
    UNREGISTER_INI_ENTRIES();
	return SUCCESS;
}
/* }}} */


/* {{{ PHP_RINIT_FUNCTION
 */
PHP_RINIT_FUNCTION(bcompiler)
{
	if (BCOMPILERG(enabled)) {
		/* looks like init_globals is supposed to do this, but it's not? */
		BCOMPILERG(buffer_size) = 1024;
		BCOMPILERG(buffer) = (char*) emalloc( BCOMPILERG(buffer_size) );
	}
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_RSHUTDOWN_FUNCTION
 */
PHP_RSHUTDOWN_FUNCTION(bcompiler)
{
	if (BCOMPILERG(enabled)) {
		efree(BCOMPILERG(buffer));
	}
	return SUCCESS;
}
/* }}} */

/* convert binary version to string; always dup returned value !! */
char *_bcompiler_vers(int v) {
	static char tmp[8];

	snprintf(tmp, 8, "%u.%u", (v >> 8) & 0xff, v & 0xff);
	tmp[7] = 0;
	return tmp;
}

/* {{{ PHP_MINFO_FUNCTION
 */
PHP_MINFO_FUNCTION(bcompiler)
{
	char *tmp;
	int i, n;

	php_info_print_table_start();
	php_info_print_table_header(2, "bcompiler support", BCOMPILERG(enabled) ? "enabled" : "disabled");
	php_info_print_table_row(2, "bcompiler version", BCOMPILER_VERSION BCOMPILER_STREAMS);
	tmp = _bcompiler_vers(BCOMPILER_CUR_VER);
	php_info_print_table_row(2, "current bytecode version", tmp);
	n = sizeof(bcompiler_can_read)/sizeof(bcompiler_can_read[0]);
	tmp = emalloc(10 * n); tmp[0] = 0;
	for (i = 0; i < n; i++) {
		strcat(tmp, _bcompiler_vers(bcompiler_can_read[i]));
		if (i < n - 1) strcat(tmp, ", ");
	}
	php_info_print_table_row(2, "can parse bytecode version", tmp);
	efree(tmp);
	php_info_print_table_end();

}
/* }}} */




/* ---------------------------------------------------------------------------- 
*
*  MAJOR DEFINES
*
*
* ---------------------------------------------------------------------------- 
*/

/*
These are flags that define start points in the decompile code..
*/
/* start of a class */
#define BCOMPILER_CLASS_ENTRY  1
/* list of included files */
#define BCOMPILER_INCTABLE_ENTRY  2 
/* a function definition */
#define BCOMPILER_FUNCTION_ENTRY  3 
/* a constant definition */
#define BCOMPILER_CONSTANT        4 
/* raw opcodes array */
#define BCOMPILER_OP_ARRAY        9


/* Definitions that output stuff.  */

/* SERIALIZE_SCALAR: write a scalar value to dst */
#define SERIALIZE_SCALAR(x, type) {                        \
	if (BCOMPILERG(stream)  != NULL) {                     \
		BCOMPILER_DEBUGFULL(( "     scalar: " BCSD_##type " (size: %d, name: %s)\n", x, BCOMPILERG(bcompiler_stdsize)[BCSI_##type], #x ));  \
		memset(BCOMPILERG(_buf), 0, sizeof(BCOMPILERG(_buf))); \
		*((type*)BCOMPILERG(_buf)) = x;                        \
		php_stream_write(BCOMPILERG(stream), BCOMPILERG(_buf), BCOMPILERG(bcompiler_stdsize)[BCSI_##type]); \
	}                                                      \
}
/* DESERIALIZE_SCALAR: read a scalar value from src */
#define DESERIALIZE_SCALAR_X(xp, type, stype, dtype, code) {             \
	size_t act;                                                          \
	if (BCOMPILERG(parsing_error)) code;                                 \
	memset(BCOMPILERG(_buf), 0, sizeof(BCOMPILERG(_buf)));               \
	act = php_stream_read(BCOMPILERG(stream), BCOMPILERG(_buf), stype);  \
	if (act != stype) {                                                  \
		if (!BCOMPILERG(parsing_error)) php_error(E_WARNING, "bcompiler: Bad bytecode file format at %08x", (unsigned)php_stream_tell(BCOMPILERG(stream))); \
		BCOMPILERG(parsing_error) = 1;                                   \
		code;                                                            \
	}                                                                    \
	BCOMPILER_DEBUGFULL(( "     scalar: " dtype " (size: %d, name: %s)\n", *((type*)BCOMPILERG(_buf)), stype, #xp ));  \
	*(xp) = *((type*) BCOMPILERG(_buf));                                 \
	BCOMPILER_DEBUGFULL(( "     read : %i \n",(type) *(xp) ));           \
}
#define DESERIALIZE_SCALAR(xp, type)      DESERIALIZE_SCALAR_X(xp, type, BCOMPILERG(bcompiler_stdsize)[BCSI_##type], BCSD_##type, return)
#define DESERIALIZE_SCALAR_V(xp, type, v) DESERIALIZE_SCALAR_X(xp, type, BCOMPILERG(bcompiler_stdsize)[BCSI_##type], BCSD_##type, return v)


/* DESERIALIZE_VOID: skip a scalar value from src */
#define DESERIALIZE_VOID(type) {                                       \
	php_stream_read(BCOMPILERG(stream), BCOMPILERG(_buf), BCOMPILERG(bcompiler_stdsize)[BCSI_##type]); \
}


/* STORE_BYTES: memcpy wrapper, writes to dst buffer */
#define STORE_BYTES(bytes, n) {                         \
	if (BCOMPILERG(stream)  != NULL) {     \
	BCOMPILER_DEBUGFULL(("      STORE: [%s] (size: %d, name: %s) \n", bytes, n, #bytes));           \
	BCOMPILER_DUMPFULL((char*)bytes, n); \
	php_stream_write(BCOMPILERG(stream) , (char *)bytes, n);   \
	}       \
}

	
/* LOAD_BYTES: memcpy wrapper, reads from src buffer */
#define LOAD_BYTES_X(bytes, n, code) {                                   \
	size_t act;                                                          \
	if (BCOMPILERG(parsing_error)) code;                                 \
	if (BCOMPILERG(buffer_size) < n + 1) {                               \
		BCOMPILER_DEBUGFULL((" *** realloc buffer from %d to %d bytes\n", BCOMPILERG(buffer_size), n + 1)); \
		BCOMPILERG(buffer_size) = n + 1;                                 \
		BCOMPILERG(buffer) = (char*) erealloc(BCOMPILERG(buffer),  n + 1); \
	}                                                                    \
	act = php_stream_read(BCOMPILERG(stream), BCOMPILERG(buffer), n);    \
	if (act != n) {                                                      \
		if (!BCOMPILERG(parsing_error)) php_error(E_WARNING, "bcompiler: Bad bytecode file format at %08x", (unsigned)php_stream_tell(BCOMPILERG(stream))); \
		BCOMPILERG(parsing_error) = 1;                                   \
		code;                                                            \
	}                                                                    \
	memcpy((char*)bytes, BCOMPILERG(buffer), n); 	                     \
	BCOMPILERG(buffer)[n] = '\0';                                        \
	BCOMPILER_DEBUGFULL(("      LOAD: [%s] (size: %d, name: %s) \n", (char*)BCOMPILERG(buffer), n, #bytes));           \
	BCOMPILER_DUMPFULL((char*)bytes, n); \
}
#define LOAD_BYTES(bytes, n)   LOAD_BYTES_X(bytes, n, return)
#define LOAD_BYTES_V(bytes, n, v) LOAD_BYTES_X(bytes, n, return v)


/* ------------------- All the public php functions ------------------------*/

/* OEL */
static void apc_serialize_oel_op_array(php_oel_op_array *oel_op_array TSRMLS_DC) {
    int i;
    zend_op *opline, *orig_opcodes;
    zend_function *fe=     NULL;
    zend_class_entry **ce= NULL;

    /* copy opcodes - next block will change them */
    orig_opcodes= oel_op_array->oel_cg.active_op_array->opcodes;
    oel_op_array->oel_cg.active_op_array->opcodes= (zend_op *) emalloc(sizeof(zend_op) * oel_op_array->oel_cg.active_op_array->last);
    memcpy(oel_op_array->oel_cg.active_op_array->opcodes, orig_opcodes, sizeof(zend_op) * oel_op_array->oel_cg.active_op_array->last);

    /* NOP out class and function declarations - binding will be done by apc_deserialize_zend_[class_entry|function] */
    for (i= 0; i < oel_op_array->oel_cg.active_op_array->last; i++) {
        opline= oel_op_array->oel_cg.active_op_array->opcodes + i;
        if (opline->opcode == ZEND_DECLARE_CLASS || opline->opcode == ZEND_DECLARE_INHERITED_CLASS) {
            if (FAILURE == zend_hash_find(oel_op_array->oel_cg.class_table, opline->op1.u.constant.value.str.val, opline->op1.u.constant.value.str.len, (void **)&ce)) {
                zend_error(E_COMPILE_ERROR, "OEL and Bcompiler Error - Missing class information for %s", opline->op2.u.constant.value.str.val);
                return;
            }
            SERIALIZE_SCALAR(BCOMPILER_CLASS_ENTRY, char);
            apc_serialize_zend_class_entry(*ce, NULL, 0, NULL, 0 TSRMLS_CC);
            opline->opcode= ZEND_NOP;
        } else if (opline->opcode == ZEND_DECLARE_FUNCTION) {
            if (FAILURE == zend_hash_find(oel_op_array->oel_cg.function_table, opline->op1.u.constant.value.str.val, opline->op1.u.constant.value.str.len, (void **)&fe)) {
                zend_error(E_COMPILE_ERROR, "OEL and Bcompiler Error - Can't find function %s", opline->op2.u.constant.value.str.val);
                return;
            }
            SERIALIZE_SCALAR(BCOMPILER_FUNCTION_ENTRY, char)
            apc_serialize_zend_function(fe TSRMLS_CC);
            opline->opcode= ZEND_NOP;
        }
    }
    /* serialize main opcode array */
    SERIALIZE_SCALAR(BCOMPILER_OP_ARRAY, char);
    apc_serialize_zend_op_array(oel_op_array->oel_cg.active_op_array TSRMLS_CC);
    efree(oel_op_array->oel_cg.active_op_array->opcodes);
    oel_op_array->oel_cg.active_op_array->opcodes= orig_opcodes;
}

PHP_FUNCTION(bcompiler_write_oel_oparray)
{
    zval             *rsrc;
    php_stream       *stream;
    zval             *arg_op_array;
    php_oel_op_array *oel_op_array;
    if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rr", &rsrc, &arg_op_array) == FAILURE) { RETURN_NULL(); }
    php_stream_from_zval(stream, &rsrc);
    ZEND_FETCH_RESOURCE(oel_op_array, php_oel_op_array*, &arg_op_array, -1, PHP_OEL_OAR_RES_NAME, le_oel_oar);

    BCOMPILERG(stream)  = stream; 
    BCOMPILERG(callback) = NULL;
    apc_serialize_oel_op_array(oel_op_array TSRMLS_CC);
    RETURN_TRUE;
}
/* END OEL */







/* {{{ proto boolean bcompiler_write_class(stream out | filehandle, string class_name [, string extends] )
   Writes compiled data to stream*/
PHP_FUNCTION(bcompiler_write_class)
{
	char *class_name = NULL;
	char *extends_name = NULL;
	int class_len,extends_len = 0;
#ifdef ZEND_ENGINE_2
	zend_class_entry **pce = NULL;
#endif
	zend_class_entry *ce = NULL;
	zend_class_entry *cee = NULL;
	zval *rsrc;
	php_stream *stream;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs|s", 
			&rsrc, &class_name, &class_len,&extends_name, &extends_len) 
					== FAILURE) {
		return;
	}
	php_stream_from_zval(stream, &rsrc);
	
	/* DANGER! This modifies the class_name string passed by the script */
#ifdef ZEND_ENGINE_2
	if (FAILURE == zend_lookup_class(class_name, class_len, &pce TSRMLS_CC))
#else
	zend_str_tolower(class_name, class_len);
	if (SUCCESS != zend_hash_find(EG(class_table), class_name, class_len+1, (void **)&ce))
#endif
	{
		php_error(E_WARNING, "Could not find class %s", class_name);
		RETURN_NULL();
	}
	BCOMPILER_DEBUG(("EXTENDS LEN: %d",extends_len)); 
	if (extends_len > 0) {
		zend_str_tolower(extends_name, extends_len);
		if (SUCCESS != zend_hash_find(EG(class_table), extends_name, extends_len+1, (void **)&cee)) {
			php_error(E_WARNING, "Could not find extended class");
			RETURN_NULL();
		}
	}
	
	
	BCOMPILERG(stream)  = stream; 
	BCOMPILERG(callback) = NULL;
	
	SERIALIZE_SCALAR(BCOMPILER_CLASS_ENTRY, char)
#ifdef ZEND_ENGINE_2
	ce = *pce;
#endif
	apc_serialize_zend_class_entry(ce, extends_name, extends_len, NULL, 0 TSRMLS_CC);
	
	RETURN_TRUE;
}
/* }}} */

 

/* {{{ proto boolean bcompiler_write_included_filename(stream out | filehandle, string filename)
   Writes compiled data to stream*/
PHP_FUNCTION(bcompiler_write_included_filename)
{
	char *file_name = NULL;
	int file_len;
	zval *rsrc;
	php_stream *stream;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs", &rsrc,&file_name, &file_len) == FAILURE) {
		return;
	}
	php_stream_from_zval(stream, &rsrc);
	
	BCOMPILERG(stream)  = stream; 
	BCOMPILERG(callback) = NULL;
	SERIALIZE_SCALAR(BCOMPILER_INCTABLE_ENTRY, char);
	apc_serialize_string(file_name TSRMLS_CC);
	RETURN_TRUE;
}
/* }}} */



/* {{{ proto boolean bcompiler_write_function(stream out | filehandle, string function_name)
   Writes compiled data to stream*/
PHP_FUNCTION(bcompiler_write_function)
{
	char *function_name = NULL;
	int function_len;
	zend_function *fe = NULL;
	zval *rsrc;
	php_stream *stream;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs", &rsrc, &function_name, &function_len) == FAILURE) {
		return;
	}
	php_stream_from_zval(stream, &rsrc);
	 
	/* DANGER! modifies function_name */
	zend_str_tolower(function_name, function_len);
	zend_hash_find(CG(function_table), function_name, function_len+1, (void **)&fe);
	if (!fe) {
		php_error(E_WARNING, "Could not find function");
		RETURN_NULL();
	}
	BCOMPILERG(stream)  = stream; 
	BCOMPILERG(callback) = NULL;

	SERIALIZE_SCALAR(BCOMPILER_FUNCTION_ENTRY, char)
 
	apc_serialize_zend_function(fe TSRMLS_CC);
	
	RETURN_TRUE;
}
/* }}} */



/* {{{ proto boolean bcompiler_write_constant(stream out | filehandle, string constant)
   Writes compiled data to stream*/
PHP_FUNCTION(bcompiler_write_constant)
{
	char *constant_name = NULL;
	int constant_len;
	zend_constant *zc = NULL;
	zval *rsrc;
	php_stream *stream;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs", &rsrc, &constant_name, &constant_len) == FAILURE) {
		return;
	}
	php_stream_from_zval(stream, &rsrc);

	zend_hash_find(EG(zend_constants), constant_name, constant_len + 1, (void **)&zc);
	if (!zc) {
		php_error(E_WARNING, "Could not find constant");
		RETURN_NULL();
	}
	BCOMPILERG(stream)  = stream; 
	BCOMPILERG(callback) = NULL;

	SERIALIZE_SCALAR(BCOMPILER_CONSTANT, char)
 
	apc_serialize_zend_constant(zc TSRMLS_CC);
	
	RETURN_TRUE;
}
/* }}} */
 


/* write functions defined in file `real_path' to stream */
static void _bcompiler_write_functions_from_file(char *real_path TSRMLS_DC)
{
	zend_function *zf = NULL;
	HashPosition   pos;
	
	/* Cycle through the functions HashTable looking for user defined functions */
	zend_hash_internal_pointer_reset_ex(EG(function_table), &pos);
	while (zend_hash_get_current_data_ex(EG(function_table), (void **)&zf, &pos) == SUCCESS)
	{
		if (zf->type == ZEND_USER_FUNCTION) {
			if (strcmp(zf->op_array.filename, real_path) == 0) {
				SERIALIZE_SCALAR(BCOMPILER_FUNCTION_ENTRY, char)
				apc_serialize_zend_function(zf TSRMLS_CC);
			}
		}
		zend_hash_move_forward_ex(EG(function_table), &pos);
	}
}

/* {{{ proto boolean bcompiler_write_functions_from_file(stream out | filehandle, string filename)
   Writes compiled data from procedural code to stream */
PHP_FUNCTION(bcompiler_write_functions_from_file)
{
	zval *rsrc;
	char *filename = NULL;
	int filename_length;
	char *real_path = NULL;
	php_stream *stream;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs", &rsrc, &filename, &filename_length) == FAILURE) {
		return;
	}
	php_stream_from_zval(stream, &rsrc);

	BCOMPILERG(stream)  = stream; 
	BCOMPILERG(callback) = NULL;

	real_path = expand_filepath(filename, NULL TSRMLS_CC);
	if (!real_path) {
		RETURN_FALSE;
	}

	_bcompiler_write_functions_from_file(real_path TSRMLS_CC);

	efree(real_path);
	RETURN_TRUE;
}
/* }}} */





/* {{{ proto boolean bcompiler_write_file(stream out | filehandle, string filename)
   Writes compiled file data to stream */
PHP_FUNCTION(bcompiler_write_file)
{
	zend_file_handle file_handle = {0};
	zval *rsrc;
	char *filename = NULL;
	int filename_length;
	char *real_path = NULL;
	php_stream *stream;
	zend_op_array *op_array = NULL;
#ifndef ZEND_ENGINE_2
	int i = 0;
	int n_old_class;
#endif
	HashPosition pos;
	zend_class_entry *zc;
	zend_function *zf = NULL;
	
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rs", &rsrc, &filename, &filename_length) == FAILURE) {
		return;
	}
	php_stream_from_zval(stream, &rsrc);
	
	BCOMPILERG(stream)  = stream; 
	BCOMPILERG(callback) = NULL;
	
	real_path = expand_filepath(filename, NULL TSRMLS_CC);
	if (!real_path) {
		RETURN_FALSE;
	}
	
	file_handle.filename = real_path;
	file_handle.free_filename = 0;
	file_handle.type = ZEND_HANDLE_FILENAME;
	file_handle.opened_path = NULL;
#ifndef ZEND_ENGINE_2
	n_old_class = zend_hash_num_elements(CG(class_table));
#endif	
	/* compile (as include) */
	op_array = bcompiler_saved_zend_compile_file(&file_handle, ZEND_INCLUDE/*type*/ TSRMLS_CC);
	zend_destroy_file_handle(&file_handle TSRMLS_CC);
	/* check for errors */
	if (!op_array) {
		efree(real_path);
		RETURN_FALSE; 
	}
	/* following line will execute just compiled script */
	/*zend_execute(op_array TSRMLS_CC);*/
	
	/* write classes */
	zend_hash_internal_pointer_reset_ex(CG(class_table), &pos);
	while (zend_hash_get_current_data_ex(CG(class_table), (void **)&zc, &pos) == SUCCESS)
	{
#ifdef ZEND_ENGINE_2
		zc = *((zend_class_entry**)zc);
#else
		i++;
#endif
		if (zc->type == ZEND_USER_CLASS) {
#ifndef ZEND_ENGINE_2
			if (i > n_old_class)
#else
			if (zc->filename && strcmp(zc->filename, real_path) == 0)
#endif
			{
				SERIALIZE_SCALAR(BCOMPILER_CLASS_ENTRY, char)
#if PHP_MAJOR_VERSION >= 6
				apc_serialize_zend_class_entry(zc, NULL, 0, pos->key.arKey.s, pos->key.type == IS_UNICODE ? -pos->nKeyLength : pos->nKeyLength TSRMLS_CC);
#else
				apc_serialize_zend_class_entry(zc, NULL, 0, pos->arKey, pos->nKeyLength TSRMLS_CC);
#endif
			}
		}
		zend_hash_move_forward_ex(CG(class_table), &pos);
	}
	/* write functions */
	_bcompiler_write_functions_from_file(real_path TSRMLS_CC);
	/* write script body opcodes */
	SERIALIZE_SCALAR(BCOMPILER_OP_ARRAY, char);
	apc_serialize_zend_op_array(op_array TSRMLS_CC);

	/* free opcode array */
#ifdef ZEND_ENGINE_2
	destroy_op_array(op_array TSRMLS_CC);
#else
	destroy_op_array(op_array);
#endif
	efree(op_array);
	/* clean-up created functions */
	zend_hash_internal_pointer_reset_ex(CG(function_table), &pos);
	while (zend_hash_get_current_data_ex(CG(function_table), (void **)&zf, &pos) == SUCCESS)
	{
		if (zf->type == ZEND_USER_FUNCTION) {
			if (strcmp(zf->op_array.filename, real_path) == 0) {
#if PHP_MAJOR_VERSION >= 6
				zend_u_hash_del(CG(function_table), pos->key.type, ZSTR(pos->key.arKey.s), pos->nKeyLength);
#else
				zend_hash_del(CG(function_table), pos->arKey, pos->nKeyLength);
#endif
			}
		}
		zend_hash_move_forward_ex(CG(function_table), &pos);
	}
	/* clean-up created classes */
#ifndef ZEND_ENGINE_2
	i = 0;
#endif
	zend_hash_internal_pointer_reset_ex(CG(class_table), &pos);
	while (zend_hash_get_current_data_ex(CG(class_table), (void **)&zc, &pos) == SUCCESS)
	{
#ifdef ZEND_ENGINE_2
		zc = *((zend_class_entry**)zc);
#else
		i++;
#endif
		if (zc->type == ZEND_USER_CLASS) {
#ifndef ZEND_ENGINE_2
			if (i > n_old_class)
#else
			if (zc->filename && strcmp(zc->filename, real_path) == 0)
#endif
			{
#if PHP_MAJOR_VERSION >= 6
				zend_u_hash_del(CG(class_table), pos->key.type, ZSTR(pos->key.arKey.s), pos->nKeyLength);
#else
				zend_hash_del(CG(class_table), pos->arKey, pos->nKeyLength);
#endif
			}
		}
		zend_hash_move_forward_ex(CG(class_table), &pos);
	}

	efree(real_path);
	RETURN_TRUE;
}
/* }}} */





/* {{{ proto boolean bcompiler_parse_class(callback, string class_name)
   Writes compiled data to g*/
PHP_FUNCTION(bcompiler_parse_class)
{
	char *class_name = NULL;
	int class_len;
	zend_class_entry *ce = NULL;
	
	zval *callback = NULL;
	
	
	
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "zs",   &callback, &class_name, &class_len) == FAILURE) {
		return;
	}
	
	
	 
	
	zend_str_tolower(class_name, class_len);
	zend_hash_find(EG(class_table), class_name, class_len+1, (void **)&ce);
	if (!ce) {
		RETURN_NULL();
	}
	 
	BCOMPILERG(callback) = callback;
	BCOMPILERG(stream) = NULL;
	  
	apc_serialize_zend_class_entry(ce, NULL, 0, NULL, 0 TSRMLS_CC);
	
	RETURN_TRUE;
}
/* }}} */





/* {{{ proto boolean bcompiler_write_header(stream out[, string write_ver])
   Writes the start flag*/
PHP_FUNCTION(bcompiler_write_header)
{
	zval *rsrc;
	char *s = NULL;
	int slen = 0, ver = BCOMPILER_CUR_VER;
	php_stream *stream;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r|s", &rsrc, &s, &slen) == FAILURE) {
		return;
	}
	   
	php_stream_from_zval(stream, &rsrc);
	/* check desired bytecode version */
	if (s) {
		unsigned int rc, hi, lo, i, n;
		rc = sscanf(s, "%u.%u", &hi, &lo);
		if (rc == 2) {
			ver = ((hi & 0xff) << 8) + (lo & 0xff);
			n = sizeof(bcompiler_can_read) / sizeof(bcompiler_can_read[0]);
			for (i = 0; i < n; i++)
				if (ver == bcompiler_can_read[i]) break;
			if (i == n) {
				zend_error(E_WARNING, "unsupported version, using defaults");
				ver = BCOMPILER_CUR_VER;
			}
		}
	}
	BCOMPILERG(current_write) = ver;
	if (ver < 0x0005) BCOMPILERG(bcompiler_stdsize) = bcompiler_stdsize_03;
	  else BCOMPILERG(bcompiler_stdsize) = bcompiler_stdsize_05;

	BCOMPILERG(stream)  = stream; 
	serialize_magic(ver TSRMLS_CC);
	
	RETURN_TRUE;
}
/* }}} */




/* {{{ proto boolean bcompiler_write_footer(stream out)
   Writes the end zero*/
PHP_FUNCTION(bcompiler_write_footer)
{
	zval *rsrc;
	php_stream *stream;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &rsrc) == FAILURE) {
		return;
	}
	   
	php_stream_from_zval(stream, &rsrc);
	BCOMPILERG(stream)  = stream; 
	
	SERIALIZE_SCALAR(0, char);
	RETURN_TRUE;
}
/* }}} */




/* {{{ proto boolean bcompiler_write_exe_footer(stream out, int start_pos)
   Writes compiled data to stream*/
PHP_FUNCTION(bcompiler_write_exe_footer)
{
	zval *rsrc;
	int start;
	php_stream *stream;
	
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "rl", &rsrc, &start) == FAILURE) {
		return;
	}
	   
	php_stream_from_zval(stream, &rsrc);
	BCOMPILERG(stream)  = stream; 
	
	SERIALIZE_SCALAR(start, int);
	serialize_magic(0 TSRMLS_CC);
	
	RETURN_TRUE;
}
/* }}} */




/* {{{ proto boolean bcompiler_read(stream in)
   Reads compiled data from stream*/
PHP_FUNCTION(bcompiler_read)
{
	zval *rsrc;
	int test =0;
	php_stream *stream;
	 
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "r", &rsrc) == FAILURE) {
		return;
	}
	   
	php_stream_from_zval(stream, &rsrc);
	  
	BCOMPILERG(stream)  = stream; 
	
	
	test = deserialize_magic(TSRMLS_C);
	
	if (test != 0) {
		php_error(E_WARNING, "Could not find Magic header in stream");
		return;
	
	}
	BCOMPILERG(current_include) = 0;
	bcompiler_read( TSRMLS_C);     
	
	
	
	RETURN_TRUE;
}
/* }}} */






/* {{{ proto boolean bcompiler_load(string bziped_file)
   Reads compiled data bziped file*/
PHP_FUNCTION(bcompiler_load)
{
	int test =0;
	char *filename;
	int filename_len;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s",  &filename,&filename_len) == FAILURE) {
		return;
	}
	  
	BCOMPILERG(stream)  = bz2_aware_stream_open(filename, 1, NULL TSRMLS_CC);
	
	if (!BCOMPILERG(stream)) {
		php_error(E_WARNING, "Could not open stream");
	}
	
	test = deserialize_magic(TSRMLS_C);
	
	if (test != 0) {
		php_error(E_WARNING, "Could not find Magic header in stream");
		return;
	}
	 
	BCOMPILERG(current_include) = 0;
	bcompiler_read( TSRMLS_C);
	php_stream_close( BCOMPILERG(stream) ); 

	RETURN_TRUE;
}
/* }}} */

/* since bz2 is not built into php on windows - forget about trying to get this to work! */

#ifdef PHP_WIN32
#else
#ifdef DISABLED
/* copied from bz2.c */
extern php_stream_ops php_stream_bz2io_ops;

struct bcompiler_bz2_stream_data_t {
	BZFILE *bz_file;
	php_stream *stream;
};


php_stream *bcompiler_stream_bz2open_from_BZFILE(BZFILE *bz, 
			const char *mode, 
			php_stream *innerstream 
			STREAMS_DC TSRMLS_DC)
{
	struct bcompiler_bz2_stream_data_t *self;
	
	self = emalloc(sizeof(*self));

	self->stream = innerstream;
	self->bz_file = bz;

	return php_stream_alloc_rel(&php_stream_bz2io_ops, (void *)self, (const char*) 0, mode);
}

#endif

#endif


/* {{{ proto boolean bcompiler_load_exe(string bziped_file)
   Reads compiled data bziped file*/
PHP_FUNCTION(bcompiler_load_exe)
{
	
	php_stream *stream = NULL;
	int test =0;
	int seekreturn = 0;
	char *filename;
	int filename_len;
	long pos;       /* offset to use */

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s",  &filename,&filename_len) == FAILURE) {
		return;
	}
	
	
	stream = bz2_aware_stream_open(filename, 0, NULL TSRMLS_CC);
	
	if (!stream) {
		BCOMPILER_DEBUG(("could not open stream: %s\n", filename));
		php_error(E_WARNING, "Failed to open %s",filename);
		return;
	}
	pos = (long) ((strlen(BCOMPILER_MAGIC_HEADER)+4) * -1); // +4 cause we need to read the string size 
	BCOMPILER_DEBUG(("move to start: %d\n", pos));

	php_stream_seek(stream, pos , SEEK_END);
	BCOMPILER_DEBUG(("done seek - try deserialize\n"));
	BCOMPILERG(stream)  = stream; 
	test = deserialize_magic(TSRMLS_C);
#if DISABLED_EXE	
	if (test != 0) {
		BCOMPILER_DEBUG(("No magic header found\n")); 
		php_error(E_WARNING, "Could not find Magic header in stream");
		php_stream_close(stream); 
		return;
	}
#endif DISABLED_EXE
	// now read the length 
	pos = pos - 4; 
	BCOMPILER_DEBUG(("move to start: %d\n", pos));
	   
	php_stream_seek(stream, pos , SEEK_END);
	
	DESERIALIZE_SCALAR(&pos, int);
	BCOMPILER_DEBUG(("move to start: %d\n", pos)); 
	seekreturn = php_stream_seek(stream, pos , SEEK_SET);
	
	if (seekreturn != 0) {
		php_error(E_WARNING, "Failed to seek to stored position");
		php_stream_close(stream); 
		return;
	}
#ifdef PHP_WIN32
#else
#ifdef DISABLED
	/* disable bzip2 for the time being */
	if (has_bzip2_stream_support(TSRMLS_C)) {
		BZFILE   *bz;     // The compressed file stream 
		int fd;
 
		if (FAILURE == php_stream_cast(stream, PHP_STREAM_AS_FD, (void *) &fd, REPORT_ERRORS)) {
						php_stream_close(stream); 
                        RETURN_FALSE;
                }
		
		bz = BZ2_bzdopen(fd, "rb");
                stream = bcompiler_stream_bz2open_from_BZFILE(bz, "rb", stream STREAMS_CC TSRMLS_CC);
		 
	}
#endif	 
#endif	 
	
	
	BCOMPILERG(stream)  = stream; 
	
	test = deserialize_magic(TSRMLS_C);
	
	if (test != 0) {

		php_error(E_ERROR, "Could not find Magic header in stream");
		php_stream_close(stream); 
		return;
	
	}
	BCOMPILERG(current_include) = 0;
	bcompiler_read( TSRMLS_C);
	   
	php_stream_close(stream); 
	RETURN_TRUE;
}
/* }}} */






/* {{{ bcompiler_read - the real reading method.*/

#define BCOMPILER_READ_RESULT (BCOMPILERG(parsing_error) ? dummy_op_array(TSRMLS_C) : op_array)
zend_op_array* bcompiler_read(TSRMLS_D) {
	char item;
	zend_class_entry* zc = NULL;
	zend_class_entry *ce = NULL;
	zend_function *zf;
	zend_function *zf2 = NULL;
	zend_constant *zconst = NULL;
	zend_op_array *op_array = NULL;
	char *key;
	int key_len;

	BCOMPILERG(parsing_error) = 0;	

	DESERIALIZE_SCALAR_V(&item, char, BCOMPILER_READ_RESULT);
	
	while (item) {
	   
		switch (item) {
	
		case BCOMPILER_CLASS_ENTRY:
			BCOMPILER_DEBUG(("STARTING CLASS\n"));
			apc_create_zend_class_entry(&zc, &key, &key_len TSRMLS_CC); 
			if (BCOMPILERG(parsing_error)) break;
			if (!key) { 
				key = ZS2S(zc->name); 
				key_len = zc->name_length+1; 
			}
			/* is it in the class table already? */
		
#if PHP_MAJOR_VERSION >= 6
			zend_u_hash_find(EG(class_table), BCOMPILERG(is_unicode) ? IS_UNICODE : IS_STRING, ZSTR(key), key_len, (void **)&ce);
#else
			zend_hash_find(EG(class_table), key, key_len, (void **)&ce);
#endif
			if (ce) {
				php_error(E_WARNING, "Could not redefine class %s", zc->name);
				efree(zc);
			} else {
#ifdef ZEND_ENGINE_2
//				zc->refcount++;
#else
//				(*zc->refcount)++;
#endif
				BCOMPILER_DEBUG(("ADDING %s [%c%s]\n", zc->name, *key, key_len>1 ? key+1 : ""));
#if PHP_MAJOR_VERSION >= 6
				if (zend_u_hash_add(EG(class_table), BCOMPILERG(is_unicode) ? IS_UNICODE : IS_STRING, ZSTR(key), key_len, &zc, sizeof(zend_class_entry*), NULL) == FAILURE) { 
//					zc->refcount--;
#elif defined(ZEND_ENGINE_2)
				if (zend_hash_add(EG(class_table), key, key_len, &zc, sizeof(zend_class_entry*), NULL) == FAILURE) { 
//					zc->refcount--;
#else
				if (zend_hash_add(EG(class_table), key, key_len, zc, sizeof(zend_class_entry), NULL) == FAILURE) { 
//					(*zc->refcount)--;
#endif
					zend_hash_destroy(&zc->function_table);
					zend_hash_destroy(&zc->default_properties);       
					php_error(E_ERROR, "bcompiler: Read Past End of File");
				}
#ifndef ZEND_ENGINE_2
				else { efree(zc); } /* we don't need it */
#endif
			}
			if (key != ZS2S(zc->name)) efree(key);
			break;
		case BCOMPILER_INCTABLE_ENTRY:
			BCOMPILER_DEBUG(("STARTING INC FILE ENTRY\n"));
			{
				char *file_name;
				int dummy = 1;
				apc_create_string(&file_name TSRMLS_CC);
				zend_hash_add(&EG(included_files), file_name, strlen(file_name)+1, (void *)&dummy, sizeof(int), NULL);
			}
			break;
		
		case BCOMPILER_FUNCTION_ENTRY:
			BCOMPILER_DEBUG(("STARTING FUNCTION\n"));
			{
#if PHP_MAJOR_VERSION >= 6
				zstr fname;
				int fname_len;
#else
				char *fname;
#endif

				apc_create_zend_function(&zf TSRMLS_CC);
				if (BCOMPILERG(parsing_error)) break;
#if PHP_MAJOR_VERSION >= 6
				fname = zend_u_str_case_fold(BCOMPILERG(is_unicode) ? IS_UNICODE : IS_STRING, zf->op_array.function_name, BCOMPILERG(is_unicode) ? u_strlen(zf->op_array.function_name.u) : strlen(zf->op_array.function_name.s), 0, &fname_len);
#elif defined(ZEND_ENGINE_2)
				fname = zend_str_tolower_dup(zf->op_array.function_name, strlen(zf->internal_function.function_name));
#else
				fname = zf->op_array.function_name;
#endif
				/* Is it in the functions table already? */
#if PHP_MAJOR_VERSION >= 6
				if (zend_u_hash_find(EG(function_table), BCOMPILERG(is_unicode) ? IS_UNICODE : IS_STRING, fname, fname_len + 1, (void **)&zf2) == SUCCESS)
#else
				if (zend_hash_find(EG(function_table), fname, strlen(zf->op_array.function_name) + 1, (void **)&zf2) == SUCCESS)
#endif
				{
					php_error(E_WARNING, "Could not redefine function %s", zf->op_array.function_name);
					efree(zf);
				} else {
					BCOMPILER_DEBUG(("ADDING FUNCTION %s \n", zf->op_array.function_name));
#if PHP_MAJOR_VERSION >= 6
					zend_u_hash_add(EG(function_table), BCOMPILERG(is_unicode) ? IS_UNICODE : IS_STRING, fname, fname_len + 1, zf, sizeof(zend_function), NULL);
#else
					zend_hash_add(EG(function_table), fname, strlen(zf->op_array.function_name) + 1, zf, sizeof(zend_function), NULL);
#endif
				}

				apc_free_zend_function(&zf TSRMLS_CC);
				efree(ZS2S(fname));
			}
			break;
		case BCOMPILER_CONSTANT:
			BCOMPILER_DEBUG(("STARTING CONSTANT\n"));
			apc_create_zend_constant(&zconst TSRMLS_CC);
#if PHP_MAJOR_VERSION >= 6
			zend_register_constant(zconst TSRMLS_CC);
#else
			switch(zconst->value.type)
			{
				case IS_LONG:
			        zend_register_long_constant(zconst->name, zconst->name_len, zconst->value.value.lval, zconst->flags, 0 TSRMLS_CC);
					break;
			    case IS_STRING:
				    zend_register_stringl_constant(zconst->name, zconst->name_len, zconst->value.value.str.val, zconst->value.value.str.len, zconst->flags, 0 TSRMLS_CC);
					break;
				case IS_DOUBLE:
			        zend_register_double_constant(zconst->name, zconst->name_len, zconst->value.value.dval, zconst->flags, 0 TSRMLS_CC);
					break;
			}
#endif
			break;

		case BCOMPILER_OP_ARRAY:
			BCOMPILER_DEBUG(("STARTING OP_ARRAY\n"));
			apc_create_zend_op_array(&op_array TSRMLS_CC);
			break;
		}
		DESERIALIZE_SCALAR_V(&item, char, BCOMPILER_READ_RESULT);
	}
	return BCOMPILER_READ_RESULT;
}
/* }}} */






/* ---------------------------------------------------------------------------- 
*
*  from apc_lib.h -- GENERALLY STUFF that doesnt need GLOBALS!

*
*
* ---------------------------------------------------------------------------- 
*/



  

char* apclib_estrdup(const char* s)
{
	int len;
	char* dup;

	if (s == NULL) {
		return NULL;
	}
	len = strlen(s);
	dup = (char*) malloc(len+1);
	if (dup == NULL) {
		php_error(E_ERROR, "apclib_estrdup: malloc failed to allocate %u bytes:", len+1);
	}
	memcpy(dup, s, len);
	dup[len] = '\0';
	return dup;
}


void* apclib_erealloc(void* p, size_t n)
{
	p = realloc(p, n);
	if (p == NULL) {
		php_error(E_ERROR, "apclib_erealloc: realloc failed to allocate %u bytes:", n);
	}
	return p;
}

/* type: string (null-terminated) */

void apclib_free_string(char **string) 
{
	if (*string == NULL) {
		return;
	}
	efree(*string);
	*string = NULL;
}

 




/*   NO IDEA WHAT THIS STUFF IS ABOUT - probably needs sorting out...

-- it's only used in defered class declarations - which shouldnt really be supported */

/* namearray_t is used to record deferred inheritance relationships */

typedef struct namearray_t namearray_t;

struct namearray_t {
	char* strings;  /* array of null-terminated names */
	int length;     /* logical size of strings */
	int size;       /* physical size of strings */
};

 






/* ---------------------------------------------------------------------------- 
*
*  The name stuff is only really usefull for debugging....
*
*
* ---------------------------------------------------------------------------- 
*/



#if BCOMPILER_DEBUG_ON
static const char* opcodes[] = {
	"NOP", /*  0 */
	"ADD", /*  1 */
	"SUB", /*  2 */
	"MUL", /*  3 */
	"DIV", /*  4 */
	"MOD", /*  5 */
	"SL", /*  6 */
	"SR", /*  7 */
	"CONCAT", /*  8 */
	"BW_OR", /*  9 */
	"BW_AND", /*  10 */
	"BW_XOR", /*  11 */
	"BW_NOT", /*  12 */
	"BOOL_NOT", /*  13 */
	"BOOL_XOR", /*  14 */
	"IS_IDENTICAL", /*  15 */
	"IS_NOT_IDENTICAL", /*  16 */
	"IS_EQUAL", /*  17 */
	"IS_NOT_EQUAL", /*  18 */
	"IS_SMALLER", /*  19 */
	"IS_SMALLER_OR_EQUAL", /*  20 */
	"CAST", /*  21 */
	"QM_ASSIGN", /*  22 */
	"ASSIGN_ADD", /*  23 */
	"ASSIGN_SUB", /*  24 */
	"ASSIGN_MUL", /*  25 */
	"ASSIGN_DIV", /*  26 */
	"ASSIGN_MOD", /*  27 */
	"ASSIGN_SL", /*  28 */
	"ASSIGN_SR", /*  29 */
	"ASSIGN_CONCAT", /*  30 */
	"ASSIGN_BW_OR", /*  31 */
	"ASSIGN_BW_AND", /*  32 */
	"ASSIGN_BW_XOR", /*  33 */
	"PRE_INC", /*  34 */
	"PRE_DEC", /*  35 */
	"POST_INC", /*  36 */
	"POST_DEC", /*  37 */
	"ASSIGN", /*  38 */
	"ASSIGN_REF", /*  39 */
	"ECHO", /*  40 */
	"PRINT", /*  41 */
	"JMP", /*  42 */
	"JMPZ", /*  43 */
	"JMPNZ", /*  44 */
	"JMPZNZ", /*  45 */
	"JMPZ_EX", /*  46 */
	"JMPNZ_EX", /*  47 */
	"CASE", /*  48 */
	"SWITCH_FREE", /*  49 */
	"BRK", /*  50 */
	"CONT", /*  51 */
	"BOOL", /*  52 */
	"INIT_STRING", /*  53 */
	"ADD_CHAR", /*  54 */
	"ADD_STRING", /*  55 */
	"ADD_VAR", /*  56 */
	"BEGIN_SILENCE", /*  57 */
	"END_SILENCE", /*  58 */
	"INIT_FCALL_BY_NAME", /*  59 */
	"DO_FCALL", /*  60 */
	"DO_FCALL_BY_NAME", /*  61 */
	"RETURN", /*  62 */
	"RECV", /*  63 */
	"RECV_INIT", /*  64 */
	"SEND_VAL", /*  65 */
	"SEND_VAR", /*  66 */
	"SEND_REF", /*  67 */
	"NEW", /*  68 */
	"JMP_NO_CTOR", /*  69 */
	"FREE", /*  70 */
	"INIT_ARRAY", /*  71 */
	"ADD_ARRAY_ELEMENT", /*  72 */
	"INCLUDE_OR_EVAL", /*  73 */
	"UNSET_VAR", /*  74 */
	"UNSET_DIM_OBJ", /*  75 */
	"ISSET_ISEMPTY", /*  76 */
	"FE_RESET", /*  77 */
	"FE_FETCH", /*  78 */
	"EXIT", /*  79 */
	"FETCH_R", /*  80 */
	"FETCH_DIM_R", /*  81 */
	"FETCH_OBJ_R", /*  82 */
	"FETCH_W", /*  83 */
	"FETCH_DIM_W", /*  84 */
	"FETCH_OBJ_W", /*  85 */
	"FETCH_RW", /*  86 */
	"FETCH_DIM_RW", /*  87 */
	"FETCH_OBJ_RW", /*  88 */
	"FETCH_IS", /*  89 */
	"FETCH_DIM_IS", /*  90 */
	"FETCH_OBJ_IS", /*  91 */
	"FETCH_FUNC_ARG", /*  92 */
	"FETCH_DIM_FUNC_ARG", /*  93 */
	"FETCH_OBJ_FUNC_ARG", /*  94 */
	"FETCH_UNSET", /*  95 */
	"FETCH_DIM_UNSET", /*  96 */
	"FETCH_OBJ_UNSET", /*  97 */
	"FETCH_DIM_TMP_VAR", /*  98 */
	"FETCH_CONSTANT", /*  99 */
	"DECLARE_FUNCTION_OR_CLASS", /*  100 */
	"EXT_STMT", /*  101 */
	"EXT_FCALL_BEGIN", /*  102 */
	"EXT_FCALL_END", /*  103 */
	"EXT_NOP", /*  104 */
	"TICKS", /*  105 */
	"SEND_VAR_NO_REF", /*  106 */
	  
	"ZEND_CATCH", /*                        107 */
	"ZEND_THROW", /*                        108 */
	"ZEND_FETCH_CLASS", /*                  109 */
	"ZEND_CLONE", /*                        110 */
	"ZEND_INIT_CTOR_CALL", /*               111 */
	"ZEND_INIT_METHOD_CALL", /*             112 */
	"ZEND_INIT_STATIC_METHOD_CALL", /*      113 */
	"ZEND_ISSET_ISEMPTY_VAR", /*            114 */
	"ZEND_ISSET_ISEMPTY_DIM_OBJ", /*        115 */
	"ZEND_IMPORT_FUNCTION", /*              116 */
	"ZEND_IMPORT_CLASS", /*                 117 */
	"ZEND_IMPORT_CONST", /*                 118 */
	
	"**UNKNOWN**", /*                 119 */
	"**UNKNOWN**", /*                 120 */
	
	"ZEND_ASSIGN_ADD_OBJ", /*               121 */
	"ZEND_ASSIGN_SUB_OBJ", /*               122 */
	"ZEND_ASSIGN_MUL_OBJ", /*               123 */
	"ZEND_ASSIGN_DIV_OBJ", /*               124 */
	"ZEND_ASSIGN_MOD_OBJ", /*               125 */
	"ZEND_ASSIGN_SL_OBJ", /*                126 */
	"ZEND_ASSIGN_SR_OBJ", /*                127 */
	"ZEND_ASSIGN_CONCAT_OBJ", /*            128 */
	"ZEND_ASSIGN_BW_OR_OBJ", /*             129 */
	"END_ASSIGN_BW_AND_OBJ", /*             130 */
	"END_ASSIGN_BW_XOR_OBJ", /*             131 */
	"ZEND_PRE_INC_OBJ", /*                  132 */
	"ZEND_PRE_DEC_OBJ", /*                  133 */
	"ZEND_POST_INC_OBJ", /*                 134 */
	"ZEND_POST_DEC_OBJ", /*                 135 */
	"ZEND_ASSIGN_OBJ", /*                   136 */
#ifndef ZEND_ENGINE_2
	"ZEND_OP_DATA",	/*			137 */
	"BEGIN_HASH_DEF", /*			138 */
	"OPCODE_ARRAY"  /*			139 */
#else
	"ZEND_MAKE_VAR", /*                     137 */
	"ZEND_INSTANCEOF", /*			138 */
	"ZEND_DECLARE_CLASS", /*		139 */
	"ZEND_DECLARE_INHERITED_CLASS", /*	140 */
	"ZEND_DECLARE_FUNCTION", /*		141 */
	"ZEND_RAISE_ABSTRACT_ERROR", /*		142 */
	"**UNKNOWN**", /*                 143 */
	"ZEND_ADD_INTERFACE", /*		144 */
	"**UNKNOWN**", /*                 145 */
	"ZEND_VERIFY_ABSTRACT_CLASS", /*	146 */
	"ZEND_ASSIGN_DIM", /*			147 */
	"ZEND_ISSET_ISEMPTY_PROP_OBJ", /*	148 */
	"ZEND_HANDLE_EXCEPTION" /*		149 */
#endif   
};
 

static const int NUM_OPCODES = sizeof(opcodes) / sizeof(opcodes[0]);


#define getOpcodeName(op) \
	(op < NUM_OPCODES ? opcodes[op] : "(unknown)")


#endif

#ifndef ZEND_ENGINE_2
/* copy of zend_do_inheritance */
void bcompiler_do_inheritance(zend_class_entry *ce, zend_class_entry *parent_ce)
{
	zend_function tmp_zend_function;
	zval *tmp;
 
	/* Perform inheritance */
	zend_hash_merge(&ce->default_properties, &parent_ce->default_properties, (void (*)(void *)) zval_add_ref, (void *) &tmp, sizeof(zval *), 0);
	zend_hash_merge(&ce->function_table, &parent_ce->function_table, (void (*)(void *)) function_add_ref, &tmp_zend_function, sizeof(zend_function), 0);
	ce->parent = parent_ce;
	if (!ce->handle_property_get)
	   ce->handle_property_get      = parent_ce->handle_property_get;
	if (!ce->handle_property_set)
		ce->handle_property_set = parent_ce->handle_property_set;
	if (!ce->handle_function_call)
		ce->handle_function_call = parent_ce->handle_function_call;
	/* leave this out for the time being? - inherit constructor.. */
	/* do_inherit_parent_constructor(ce); */
	
}
#endif

 /* inherit: recursively inherit methods from base to all the children
 * of parent, the children of parent's children, and so on */
static void bcompiler_inherit(zend_class_entry* base  TSRMLS_DC)
{
	
	 
	zend_class_entry* child;
	BCOMPILER_DEBUG(("parent class: %s\n", base->name));
	 
	if (!base->parent) {
		return;     // 'parent' has no children, nothing to do 
	}
	child = base->parent;
	
	while (child) {
		BCOMPILER_DEBUG(("child class: %s\n", child->name));
#ifndef ZEND_ENGINE_2
		bcompiler_do_inheritance(base, child);
#else
		zend_do_inheritance(base, child TSRMLS_CC);
#endif
		child = child->parent;
	}
	
}
 
 




/* ---------------------------------------------------------------------------- 
*
*  START STUFF THAT NEEDS GLOBALS.... (eg. TSRMLS_DC)
*
*
* ---------------------------------------------------------------------------- 
*/


   

void apc_serialize_string(char* string TSRMLS_DC)
{
	int len;

	/* by convention, mark null strings with a length of -1 */
	if (string == NULL) {
		SERIALIZE_SCALAR(-1, int);
		return;
	}

	len = strlen(string);
	if (len <= 0) {
		SERIALIZE_SCALAR(-1, int);
		return;
	}
	BCOMPILER_DEBUG(("STRING: len, string : %s\n", string)); 
	SERIALIZE_SCALAR(len, int);
	STORE_BYTES(string, len);
}

void apc_serialize_zstring(char* string, int len TSRMLS_DC)
{
	/* by convention, mark null strings with a length of -1 */
	if (len <= 0 || string == NULL) {
		SERIALIZE_SCALAR(-1, int);
		return;
	}
	//  len = strlen(string);
	SERIALIZE_SCALAR(len, int);
	STORE_BYTES(string, len);
}

void apc_create_string(char** string TSRMLS_DC)
{
	int len = 0;

	DESERIALIZE_SCALAR(&len, int);
	if (len <= 0) {
		/* by convention, empty marked strings (len is -1)  are returned as an empty string */
		*string = (char*) emalloc(1);
		(*string)[0] = '\0';
		return;
	}
	*string = (char*) emalloc(len + 1);
	LOAD_BYTES(*string, (unsigned int)len);
	(*string)[len] = '\0';
}

void apc_create_string2(char** string, int unicode TSRMLS_DC)
{
	int len = 0;

	if (unicode < 0) unicode = BCOMPILERG(is_unicode);
	DESERIALIZE_SCALAR(&len, int);
	if (len <= 0) {
		/* by convention, empty marked strings (len is -1)  are returned as an empty string */
		*string = (char*) emalloc(unicode ? 2 : 1);
		(*string)[0] = '\0';
		if (unicode) (*string)[1] = '\0';
		return;
	}
	*string = (char*) emalloc(len + (unicode ? 2 : 1));
	LOAD_BYTES(*string, (unsigned int)len);
	(*string)[len] = '\0';
	if (unicode) (*string)[len + 1] = '\0';
}

#ifdef ZEND_ENGINE_2
void apc_serialize_arg_info(zend_arg_info* arg_info TSRMLS_DC)
{
	if (arg_info == NULL) {
		SERIALIZE_SCALAR(0, char);
		return; /* arg_types is null */
	}
	SERIALIZE_SCALAR(1, char);
	SERIALIZE_SCALAR(arg_info->name_len       , int);
//	apc_serialize_string(arg_info->name TSRMLS_CC);
	apc_serialize_zstring(ZS2S(arg_info->name), arg_info->name_len TSRMLS_CC);
	SERIALIZE_SCALAR(arg_info->class_name_len  , int);
	if (arg_info->class_name_len) {
//		apc_serialize_string(arg_info->class_name TSRMLS_CC);
		apc_serialize_zstring(ZS2S(arg_info->class_name), arg_info->class_name_len TSRMLS_CC);
	}
	SERIALIZE_SCALAR(arg_info->allow_null       , char);
	SERIALIZE_SCALAR(arg_info->pass_by_reference, char);
	SERIALIZE_SCALAR(arg_info->return_reference , char);
	SERIALIZE_SCALAR(arg_info->required_num_args, int);
	 
	 
}

void apc_create_arg_info(zend_arg_info* arg_info TSRMLS_DC)
{
	char exists;

	DESERIALIZE_SCALAR(&exists, char);
	if (!exists) {
		arg_info = NULL;
		return; /* arg_types is null */
	}
	DESERIALIZE_SCALAR(&arg_info->name_len, int);
	apc_create_string2(&ZS2S(arg_info->name), -1 TSRMLS_CC);
	DESERIALIZE_SCALAR(&arg_info->class_name_len, int);
	if (arg_info->class_name_len) {
		apc_create_string2(&ZS2S(arg_info->class_name), -1 TSRMLS_CC);
	}
	else ZS2S(arg_info->class_name) = NULL;
	DESERIALIZE_SCALAR(&arg_info->allow_null, char);
	DESERIALIZE_SCALAR(&arg_info->pass_by_reference, char);
	DESERIALIZE_SCALAR(&arg_info->return_reference, char);
	DESERIALIZE_SCALAR(&arg_info->required_num_args, int);
	
}
#else
void apc_serialize_arg_types(zend_uchar* arg_types TSRMLS_DC)
{
	if (arg_types == NULL) {
		SERIALIZE_SCALAR(0, char);
		return; /* arg_types is null */
	}
	SERIALIZE_SCALAR(1, char);
	SERIALIZE_SCALAR(arg_types[0], zend_uchar);
	STORE_BYTES(arg_types + 1, arg_types[0]*sizeof(zend_uchar));
}

void apc_create_arg_types(zend_uchar** arg_types TSRMLS_DC)
{
	char exists;
	zend_uchar count;

	DESERIALIZE_SCALAR(&exists, char);
	if (!exists) {
		*arg_types = NULL;
		return; /* arg_types is null */
	}
	DESERIALIZE_SCALAR(&count, zend_uchar);
	*arg_types = emalloc(count + 1);
	(*arg_types)[0] = count;
	LOAD_BYTES((*arg_types) + 1, count*sizeof(zend_uchar));
}
#endif

/* precompiler routines */
/*
void apc_serialize_magic(TSRMLS_D)
{
	apc_serialize_string(BCOMPILER_MAGIC_HEADER TSRMLS_CC);
}
*/
/*int apc_deserialize_magic(TSRMLS_D)
{
	char *tmp;
	int retval;

	apc_create_string(&tmp TSRMLS_CC);
	BCOMPILER_DEBUG(("got %s\n", tmp));
	retval = strcmp(tmp,BCOMPILER_MAGIC_HEADER);
	apclib_free_string(&tmp); // MPB
	return retval;
}*/

/* A replacement for apc_serialize_magic() */
void serialize_magic(int ver TSRMLS_DC)
{
	char *tmp;

	if (!ver) {
		tmp = BCOMPILER_MAGIC_HEADER;
#if PHP_MAJOR_VERSION >= 6
		if (UG(unicode)) tmp[strlen(tmp)-2] = *(BCOMPILER_UNICODE);
#endif
		apc_serialize_string(tmp TSRMLS_CC);
	} else {
		spprintf(&tmp, 1024, BCOMPILER_MAGIC_START "%u.%u%c", (ver >> 8) & 0xff, ver & 0xff, 
#if PHP_MAJOR_VERSION >= 6
					UG(unicode) ? *(BCOMPILER_UNICODE) : *(BCOMPILER_STREAMS)
#else
					*(BCOMPILER_STREAMS)
#endif
				);
		apc_serialize_string(tmp TSRMLS_CC);
		efree(tmp);
	}
}

/* A replacement for apc_deserialize_magic() */
int deserialize_magic(TSRMLS_D)
{
	char *tmp, c;
	int retval;
	int len = 0;
	unsigned int hi, lo;

	DESERIALIZE_SCALAR_V(&len, int, -1);
	/* just a sanity check */
	if (len <= 0 || len > 0x20) {
		return -1;
	}
	
	tmp = (char *) emalloc(len + 1);
	LOAD_BYTES_V(tmp, (unsigned int)len, -1);
	tmp[len] = '\0';
	BCOMPILER_DEBUGFULL(("got magic %s\n", tmp));
	
	retval = sscanf(tmp, BCOMPILER_MAGIC_START "%u.%u%c", &hi, &lo, &c);
#if PHP_MAJOR_VERSION >= 6
	if (retval == 3 && (c == *(BCOMPILER_STREAMS) || c == *(BCOMPILER_UNICODE)))
#else
	if (retval == 3 && c == *(BCOMPILER_STREAMS))
#endif
	{
		int i, n;
		BCOMPILERG(current_version) = ((hi & 0xff) << 8) + (lo & 0xff);
		n = sizeof(bcompiler_can_read) / sizeof(bcompiler_can_read[0]);
		for (i = 0; i < n; i++) {
			if (BCOMPILERG(current_version) == bcompiler_can_read[i]) {
				break;
			}
		}
		retval = (i < n) ? 0 : -1;
#if PHP_MAJOR_VERSION >= 6
		BCOMPILERG(is_unicode) = (c == *(BCOMPILER_UNICODE));
		if (UG(unicode) != BCOMPILERG(is_unicode)) retval = -2;
#endif
		BCOMPILER_DEBUG(("bytecode version %u.%u%c (can parse: %s)\n", hi, lo, c, retval == 0 ? "yes" : "no"));
		if (BCOMPILERG(current_version) < 0x0005) BCOMPILERG(bcompiler_stdsize) = bcompiler_stdsize_03;
		else BCOMPILERG(bcompiler_stdsize) = bcompiler_stdsize_05;
	} else {
		if (retval == 3) {
			BCOMPILER_DEBUG(("bytecode version %u.%u%c (can parse: no)\n", hi, lo, c));
		}
		retval = -1;
	}
	
	efree(tmp);
	return retval;
}
/* type: zend_llist */

static void store_zend_llist_element(void* arg, void* data  TSRMLS_DC)
{
	int size = *((int*)arg);
	STORE_BYTES((char*)data, size);
}


void apc_serialize_zend_llist(zend_llist* list TSRMLS_DC)
{
	char exists;

	exists = (list != NULL) ? 1 : 0;
	SERIALIZE_SCALAR(exists, char);  // write twice to remove need for peeking.
	
	if (!exists) {
		return;
	}
	SERIALIZE_SCALAR(exists, char);
	SERIALIZE_SCALAR(list->size, size_t);
	/** old code: SERIALIZE_SCALAR(list->dtor, void*); */
	if (BCOMPILERG(current_write) < 0x0005) SERIALIZE_SCALAR(0, ulong); /* dummy 4 bytes */
	/** old code: SERIALIZE_SCALAR(list->persistent, unsigned char); */
	SERIALIZE_SCALAR(list->persistent, zend_uchar);
	SERIALIZE_SCALAR(zend_llist_count(list), int);
	zend_llist_apply_with_argument(list, store_zend_llist_element,
	&list->size  TSRMLS_CC);
}

void apc_deserialize_zend_llist(zend_llist* list TSRMLS_DC)
{
	char exists;
	size_t size;
	void (*dtor)(void*);
	unsigned char persistent;
	int count, i;
	char* data;

	DESERIALIZE_SCALAR(&exists, char);
	assert(exists != 0); 

	/* read the list parameters */
	DESERIALIZE_SCALAR(&size, size_t);
	/** old code: DESERIALIZE_SCALAR(&dtor, void*); */
	if (BCOMPILERG(current_version) < 0x0005) DESERIALIZE_VOID(ulong); /* dummy 4 bytes */
	dtor = NULL;
	/** old code: DESERIALIZE_SCALAR(&persistent, unsigned char); */
	DESERIALIZE_SCALAR(&persistent, zend_uchar);
	/* initialize the list */
	zend_llist_init(list, size, dtor, persistent);

	/* insert the list elements */
	DESERIALIZE_SCALAR(&count, int);
	data = (char*) malloc(list->size);
	for (i = 0; i < count; i++) {
		LOAD_BYTES(data, list->size);
		zend_llist_add_element(list, data);
	}
	free(data);
}

void apc_create_zend_llist(zend_llist** list TSRMLS_DC)
{
	char exists;

	/* Sneak a look one byte ahead to see whether the list exists or not.
	 * If it does, then exists is part of the structure, otherwise it was
	 * a zero-value placeholder byte. */
	/*PEEK_SCALAR(&exists, char);  */
	DESERIALIZE_SCALAR(&exists, char); 
	if (exists) {
		*list = (zend_llist*) emalloc(sizeof(zend_llist));
		apc_deserialize_zend_llist(*list TSRMLS_CC);
	}
	else {
		/* DESERIALIZE_SCALAR(&exists, char);  */
		*list = 0;
	}
}


/* type: HashTable */

 

/* type: HashTable */

static ulong pDestructor_idx(dtor_func_t p TSRMLS_DC) {
	if (BCOMPILERG(current_write) >= 0x0005) {
		if (p == ZVAL_PTR_DTOR) return 1;
		if (p == ZEND_FUNCTION_DTOR) return 2;
		if (p == ZEND_CLASS_DTOR) return 3;
#ifdef BUILD_WITH_ZEND /* val: these are missing in php4ts.lib (4.3.3) */
		if (p == ZEND_MODULE_DTOR) return 4;
		if (p == ZEND_CONSTANT_DTOR) return 5;
#endif
		if (p == (dtor_func_t)free_estring) return 6;
#ifdef BUILD_WITH_ZEND /* val: these are missing in php4ts.lib (4.3.3) */
		if (p == list_entry_destructor) return 7;
		if (p == plist_entry_destructor) return 8;
#endif
	}
	return 0;
}



#ifdef ZEND_ENGINE_2
/* since zend_function is copied in deserialize_hashtable, we need to update 
   special class function pointers */
static void adjust_class_handler(zend_class_entry *zc, zend_function *old, zend_function *act) {
	if (zc) {
		if (zc->constructor == old) zc->constructor = act;
		if (zc->destructor == old) zc->destructor = act;
		if (zc->clone == old) zc->clone = act;
		if (zc->__get == old) zc->__get = act;
		if (zc->__set == old) zc->__set = act;
		if (zc->__call == old) zc->__call = act;
#ifdef ZEND_ENGINE_2_1
		if (zc->__unset == old) zc->__unset = act;
		if (zc->__isset == old) zc->__isset = act;
		if (zc->serialize_func == old) zc->serialize_func = act;
		if (zc->unserialize_func == old) zc->unserialize_func = act;
#endif
	}
}
#endif




void apc_serialize_hashtable(HashTable* ht, void* funcptr TSRMLS_DC)
{
	char exists;    /* for identifying null lists */
	Bucket* p;
	void (*serialize_bucket)(void* TSRMLS_DC);
	

	 
	serialize_bucket = (void(*)(void* TSRMLS_DC)) funcptr;

	exists = (ht != NULL) ? 1 : 0;
	SERIALIZE_SCALAR(exists, char);
	if (!exists) {
		return;
	}
	 
	
	   
	/* Serialize the hash meta-data. */
	SERIALIZE_SCALAR(ht->nTableSize, uint);
	/** old code: SERIALIZE_SCALAR(ht->pDestructor, void*); */
	SERIALIZE_SCALAR(pDestructor_idx(ht->pDestructor TSRMLS_CC), ulong);
	SERIALIZE_SCALAR(ht->nNumOfElements, uint);
	SERIALIZE_SCALAR(ht->persistent, int);
#if PHP_MAJOR_VERSION >= 6
	SERIALIZE_SCALAR(ht->unicode, zend_bool);
#endif

	/* Iterate through the buckets of the hash, serializing as we go. */
	p = ht->pListHead;
	while(p != NULL) {
		SERIALIZE_SCALAR(p->h, ulong);
		SERIALIZE_SCALAR(p->nKeyLength,uint);
		
		
		
		
#if PHP_MAJOR_VERSION >= 6
		SERIALIZE_SCALAR(p->key.type,zend_uchar);
		apc_serialize_zstring(p->key.arKey.s, REAL_KEY_SIZE(p->key.type, p->nKeyLength) TSRMLS_CC);
#else
		apc_serialize_zstring(p->arKey, p->nKeyLength TSRMLS_CC);
#endif
		serialize_bucket(p->pData TSRMLS_CC ); 
		p = p->pListNext;
	}
	
	 
	
	
}

void apc_deserialize_hashtable(HashTable* ht, void* funcptr, void* dptr, int datasize, char exists TSRMLS_DC)
{
	 
	uint nSize;
	dtor_func_t pDestructor;
	uint nNumOfElements;
	int persistent;
	int j;
	ulong h;
	uint nKeyLength;
	char* arKey;
#if PHP_MAJOR_VERSION >= 6
	zend_uchar keyType;
#endif
	void* pData;
	int status;
	void (*deserialize_bucket)(void* TSRMLS_DC);
	void (*free_bucket)(void*);
	BCOMPILER_DEBUG(("-----------------------------\nHASH TABLE:\n"));
	deserialize_bucket = (void(*)(void* TSRMLS_DC)) funcptr;
	free_bucket = (void(*)(void*)) dptr;
	
	 
	assert(exists != 0);

	DESERIALIZE_SCALAR(&nSize, uint);
	/** old code: DESERIALIZE_SCALAR(&pDestructor, void*); */
	DESERIALIZE_SCALAR(&h, ulong);
	pDestructor = NULL;
	if (BCOMPILERG(current_version) >= 0x0005) switch (h) {
		case 1: pDestructor = ZVAL_PTR_DTOR; break;
		case 2: pDestructor = ZEND_FUNCTION_DTOR; break;
		case 3: pDestructor = ZEND_CLASS_DTOR; break;
#ifdef BUILD_WITH_ZEND /* val: these are missing in php4ts.lib (4.3.3) */
		case 4: pDestructor = ZEND_MODULE_DTOR; break;
		case 5: pDestructor = ZEND_CONSTANT_DTOR; break;
#endif
		case 6: pDestructor = (dtor_func_t)free_estring; break;
#ifdef BUILD_WITH_ZEND /* val: these are missing in php4ts.lib (4.3.3) */
		case 7: pDestructor = list_entry_destructor; break;
		case 8: pDestructor = plist_entry_destructor; break;
#endif
	}
	DESERIALIZE_SCALAR(&nNumOfElements,uint);
	DESERIALIZE_SCALAR(&persistent, int);
	
	BCOMPILER_DEBUG(("-----------------------------\nBEGIN TABLE:\n"));
	
	/* Although the hash is already allocated (we're a deserialize, not a 
	 * create), we still need to initialize it. If this fails, something 
	 * very very bad happened. */
	status = zend_hash_init(ht, nSize, NULL, pDestructor, persistent);
	assert(status != FAILURE);

#if PHP_MAJOR_VERSION >= 6
	DESERIALIZE_SCALAR(&ht->unicode, zend_bool);
#endif

	/* Luckily, the number of elements in a hash is part of its struct, so
	 * we can just deserialize that many hashtable elements. */

	for (j = 0; j < (int) nNumOfElements; j++) {
	DESERIALIZE_SCALAR(&h, ulong);
	DESERIALIZE_SCALAR(&nKeyLength, uint);
#if PHP_MAJOR_VERSION >= 6
	DESERIALIZE_SCALAR(&keyType, zend_uchar);
	apc_create_string2(&arKey, -1 TSRMLS_CC);
#else
	apc_create_string(&arKey TSRMLS_CC);
#endif
	deserialize_bucket(&pData TSRMLS_CC);
	/* val: return pData = NULL to skip element */
	if (!pData) { apclib_free_string(&arKey); continue; }

	/* If nKeyLength is non-zero, this element is a hashed key/value
	 * pair. Otherwise, it is an array element with a numeric index */
	BCOMPILER_DEBUG(("-----------------------------\nFUNC %s\n",arKey));
	
	if (nKeyLength != 0) {
		if(datasize == sizeof(void*)) {
#if PHP_MAJOR_VERSION >= 6
			BCOMPILER_DEBUGFULL(("adding element [ptr] type=%d len=%d ptr=%p\n", keyType, nKeyLength, &pData));
			_zend_u_hash_add_or_update(ht, keyType, ZSTR(arKey), nKeyLength, &pData,
				datasize, NULL, HASH_ADD ZEND_FILE_LINE_CC);
#elif defined(ZEND_ENGINE_2)
			BCOMPILER_DEBUGFULL(("adding element [ptr] %s = %p\n", arKey, &pData));
			_zend_hash_add_or_update(ht, arKey, nKeyLength, &pData,
				datasize, NULL, HASH_ADD ZEND_FILE_LINE_CC);
#else
			zend_hash_add_or_update(ht, arKey, nKeyLength, &pData,
				datasize, NULL, HASH_ADD);
#endif
		} else {
#ifdef ZEND_ENGINE_2
			void *pDest;
#endif
			BCOMPILER_DEBUGFULL(("adding element [cpy] %s = %p\n", arKey, pData));
#ifdef ZEND_ENGINE_2
# if PHP_MAJOR_VERSION >= 6
			_zend_u_hash_add_or_update(ht, keyType, ZSTR(arKey), nKeyLength, pData,
				datasize, &pDest, HASH_ADD ZEND_FILE_LINE_CC);
# else
			_zend_hash_add_or_update(ht, arKey, nKeyLength, pData,
				datasize, &pDest, HASH_ADD ZEND_FILE_LINE_CC);
# endif
			BCOMPILER_DEBUGFULL(("actual added element ptr=%p\n", pDest));
			adjust_class_handler(BCOMPILERG(cur_zc), pData, pDest);
#else
			zend_hash_add_or_update(ht, arKey, nKeyLength, pData,
				datasize, NULL, HASH_ADD);
#endif
		}
	} else {  /* numeric index, not key string */
		if(datasize == sizeof(void*)) {
			zend_hash_index_update(ht, h, &pData, datasize, NULL);
		} else {
			zend_hash_index_update(ht, h, pData, datasize, NULL);
		}
	}
	if (dptr != NULL) {
		free_bucket(&pData); 
	}
	// else {
	//   BCOMPILER_DEBUG((stderr, "Do not free: %s\n", arKey));
	// }
	apclib_free_string(&arKey); // ADDED BY MPB
	}
}

void apc_create_hashtable(HashTable** ht, void* funcptr, void* dptr, int datasize TSRMLS_DC)
{
	char exists;    /* for identifying null hashtables */

	/*PEEK_SCALAR(&exists, char); */
	DESERIALIZE_SCALAR(&exists, char);
	if (exists==1) {
		*ht = (HashTable*) emalloc(sizeof(HashTable));
		apc_deserialize_hashtable(*ht, funcptr, dptr, datasize,exists TSRMLS_CC);
	} else {
		/* DESERIALIZE_SCALAR(&exists, char); */
		*ht = NULL;
	}
}

/* type: zvalue_value */


void apc_serialize_zvalue_value(zvalue_value* zv, int type, znode *zn TSRMLS_DC)
{
	/* A zvalue_value is a union, and as such we first need to
	 * determine exactly what it's type is, then serialize the
	 * appropriate structure. */
	
	switch (type) 
	{
	case IS_RESOURCE:
	case IS_BOOL:
	case IS_LONG:
		
		
		SERIALIZE_SCALAR(zv->lval, long);
		break;  
	case IS_DOUBLE:
		SERIALIZE_SCALAR(zv->dval, double);
		break;
	case IS_NULL:
		/* null value - it's used for temp_vars */
#if defined(ZEND_ENGINE_2) || defined(ZEND_ENGINE_2_1)
		if (zn && BCOMPILERG(current_write) >= 0x0008) {
			SERIALIZE_SCALAR(zn->u.EA.var,  zend_uint);
			SERIALIZE_SCALAR(zn->u.EA.type, zend_uint);
		}
#endif
		if (BCOMPILERG(current_write) >= 0x0005) SERIALIZE_SCALAR(zv->lval, long);
		break;
	case IS_CONSTANT:
	case IS_STRING:
#ifndef ZEND_ENGINE_2
	case FLAG_IS_BC:
#endif
		
		
		apc_serialize_zstring(zv->str.val, zv->str.len  TSRMLS_CC);
		SERIALIZE_SCALAR(zv->str.len, int);
		break;
#if PHP_MAJOR_VERSION >= 6
	case IS_UNICODE:
		apc_serialize_zstring((char*)zv->ustr.val, UBYTES(zv->ustr.len)  TSRMLS_CC);
		SERIALIZE_SCALAR(zv->ustr.len, int);
		break;
#endif
	case IS_ARRAY:
		apc_serialize_hashtable(zv->ht, apc_serialize_zval_ptr  TSRMLS_CC);
		break;
	case IS_CONSTANT_ARRAY:
		apc_serialize_hashtable(zv->ht, apc_serialize_zval_ptr TSRMLS_CC);
		break;
	case IS_OBJECT:
#ifdef ZEND_ENGINE_2
		/* not yet!
		apc_serialize_zend_class_entry(zv->obj.handlers, NULL, 0, NULL, 0 TSRMLS_CC);
		apc_serialize_hashtable(zv->obj.properties, apc_serialize_zval_ptr TSRMLS_CC);
		*/
#else
		apc_serialize_zend_class_entry(zv->obj.ce, NULL, 0, NULL, 0 TSRMLS_CC);
#endif
		break;
	default:
		/* The above list enumerates all types.  If we get here,
		 * something very very bad has happened. */
		assert(0);
	}
}

void apc_deserialize_zvalue_value(zvalue_value* zv, int type, znode *zn TSRMLS_DC)
{
	/* We peeked ahead in the calling routine to deserialize the
	 * type. Now we just deserialize. */
	switch(type) 
	{
	case IS_RESOURCE:
	case IS_BOOL:
	case IS_LONG:
		DESERIALIZE_SCALAR(&zv->lval, long);
		break;
	case IS_NULL:
		/* null value - it's used for temp_vars */
#if defined(ZEND_ENGINE_2) || defined(ZEND_ENGINE_2_1)
		if (zn && BCOMPILERG(current_version) >= 0x0008) {
			DESERIALIZE_SCALAR(&zn->u.EA.var,  zend_uint);
			DESERIALIZE_SCALAR(&zn->u.EA.type, zend_uint);
		}
#endif
		if (BCOMPILERG(current_version) >= 0x0005) DESERIALIZE_SCALAR(&zv->lval, long);
		break;
	case IS_DOUBLE:
		DESERIALIZE_SCALAR(&zv->dval, double);
		break;
	case IS_CONSTANT:
	case IS_STRING:
#ifndef ZEND_ENGINE_2
	case FLAG_IS_BC:
#endif
#if PHP_MAJOR_VERSION >= 6
		apc_create_string2(&zv->str.val, -1 TSRMLS_CC);
#else
		apc_create_string(&zv->str.val TSRMLS_CC);
#endif
		DESERIALIZE_SCALAR(&zv->str.len, int);
		break;
#if PHP_MAJOR_VERSION >= 6
	case IS_UNICODE:
		apc_create_string2((char**)&zv->ustr.val, 1 TSRMLS_CC);
		DESERIALIZE_SCALAR(&zv->ustr.len, int);
		break;
#endif
	case IS_ARRAY:
		apc_create_hashtable(&zv->ht, apc_create_zval, NULL, sizeof(void*) TSRMLS_CC);
		break;
	case IS_CONSTANT_ARRAY:
		apc_create_hashtable(&zv->ht, apc_create_zval, NULL, sizeof(void*) TSRMLS_CC);
		break;
	case IS_OBJECT:
#ifndef ZEND_ENGINE_2
		apc_create_zend_class_entry(&zv->obj.ce, NULL, NULL TSRMLS_CC);
		apc_create_hashtable(&zv->obj.properties, apc_create_zval, NULL, sizeof(zval *) TSRMLS_CC);
#endif
		break;
	default:
		/* The above list enumerates all types.  If we get here,
		 * something very very bad has happened. */
		assert(0);
	}   
}


/* type: zval */

void apc_serialize_zval_ptr(zval** zv TSRMLS_DC)
{
	apc_serialize_zval(*zv, NULL TSRMLS_CC);
}


	
void apc_serialize_zval(zval* zv, znode *zn TSRMLS_DC)
{
	/* type is the switch for serializing zvalue_value */
	SERIALIZE_SCALAR(zv->type, zend_uchar);
	apc_serialize_zvalue_value(&zv->value, zv->type, zn TSRMLS_CC);
	SERIALIZE_SCALAR(zv->is_ref, zend_uchar);
	SERIALIZE_SCALAR(zv->refcount, zend_ushort);
}

void apc_deserialize_zval(zval* zv, znode *zn TSRMLS_DC)
{
	/* type is the switch for deserializing zvalue_value */
	DESERIALIZE_SCALAR(&zv->type, zend_uchar);
	apc_deserialize_zvalue_value(&zv->value, zv->type, zn TSRMLS_CC);
	DESERIALIZE_SCALAR(&zv->is_ref, zend_uchar);
	DESERIALIZE_SCALAR(&zv->refcount, zend_ushort);
}

void apc_create_zval(zval** zv TSRMLS_DC)
{
	*zv = (zval*) emalloc(sizeof(zval));
	memset(*zv, 0, sizeof(zval));
	apc_deserialize_zval(*zv, NULL TSRMLS_CC);
}



/* type: zend_function_entry */


void apc_serialize_zend_function_entry(zend_function_entry* zfe TSRMLS_DC)
{
#ifdef ZEND_ENGINE_2
	int i, len;
#endif
#if PHP_MAJOR_VERSION >= 6
	if (zfe->fname == NULL) len = -1;
	else if (UG(unicode)) len = u_strlen((UChar*)zfe->fname) * sizeof(UChar);
	else len = strlen(zfe->fname);
	apc_serialize_zstring(zfe->fname, len TSRMLS_CC);
#else
	apc_serialize_string(zfe->fname TSRMLS_CC);
#endif
	BCOMPILER_DEBUG(("serializing function %s\n",zfe->fname ));
	/** old code: SERIALIZE_SCALAR(zfe->handler, void*); */
	if (BCOMPILERG(current_write) < 0x0005) SERIALIZE_SCALAR(0, ulong); /* dummy 4 bytes */
#ifdef ZEND_ENGINE_2
	SERIALIZE_SCALAR(zfe->num_args, int);
	for (i=0; i< zfe->num_args; i++) {
		apc_serialize_arg_info(&zfe->arg_info[i] TSRMLS_CC);
	}
#else
	apc_serialize_arg_types(zfe->func_arg_types TSRMLS_CC);
#endif
}

void apc_deserialize_zend_function_entry(zend_function_entry* zfe TSRMLS_DC)
{
#ifdef ZEND_ENGINE_2
	int i;
#endif
	apc_create_string2(&zfe->fname, -1 TSRMLS_CC);
	/** old code: DESERIALIZE_SCALAR(&zfe->handler, void*); */
	if (BCOMPILERG(current_version) < 0x0005) DESERIALIZE_VOID(ulong); /* dummy 4 bytes */
	zfe->handler = NULL;
	BCOMPILER_DEBUG(("deserializing function %s\n",zfe->handler));
#ifdef ZEND_ENGINE_2
	DESERIALIZE_SCALAR(&zfe->num_args, int);
	zfe->arg_info = (zend_arg_info *) ecalloc(zfe->num_args, sizeof(zend_arg_info));
	for (i=0; i< zfe->num_args; i++) {
		apc_create_arg_info(&zfe->arg_info[i] TSRMLS_CC);
	}
#else
	apc_create_arg_types(&zfe->func_arg_types TSRMLS_CC);
#endif
}

#ifdef ZEND_ENGINE_2
void apc_serialize_zend_property_info(zend_property_info* zpr TSRMLS_DC)
{
	SERIALIZE_SCALAR(zpr->flags, zend_uint);
#if PHP_MAJOR_VERSION >= 6
	apc_serialize_zstring(ZS2S(zpr->name), UG(unicode) ? UBYTES(zpr->name_length) : zpr->name_length TSRMLS_CC);
#else
	apc_serialize_zstring(zpr->name, zpr->name_length TSRMLS_CC);
#endif
	SERIALIZE_SCALAR(zpr->name_length, uint);
	SERIALIZE_SCALAR(zpr->h, ulong);
}
void apc_deserialize_zend_property_info(zend_property_info* zpr TSRMLS_DC)
{
	DESERIALIZE_SCALAR(&zpr->flags, zend_uint);
	apc_create_string2(&ZS2S(zpr->name), -1 TSRMLS_CC);
	DESERIALIZE_SCALAR(&zpr->name_length, uint); 
	DESERIALIZE_SCALAR(&zpr->h, ulong);
}

void apc_create_zend_property_info(zend_property_info** zf TSRMLS_DC)
{
	*zf = (zend_property_info*) emalloc(sizeof(zend_property_info));
	apc_deserialize_zend_property_info(*zf TSRMLS_CC);
}

void apc_free_zend_property_info(zend_property_info** zf TSRMLS_DC)
{
	if (*zf != NULL) {
		efree(*zf);
	}
	*zf = NULL;
}
/* type: zend_property_reference */

#else
void apc_serialize_zend_property_reference(zend_property_reference* zpr TSRMLS_DC)
{
	SERIALIZE_SCALAR(zpr->type, int);
	apc_serialize_zval(zpr->object, NULL TSRMLS_CC);
	apc_serialize_zend_llist(zpr->elements_list TSRMLS_CC);
}

void apc_deserialize_zend_property_reference(zend_property_reference* zpr TSRMLS_DC)
{
	DESERIALIZE_SCALAR(&zpr->type, int);
	apc_deserialize_zval(zpr->object, NULL TSRMLS_CC);
	apc_create_zend_llist(&zpr->elements_list TSRMLS_CC);
}
#endif

/* type: zend_overloaded_element - i dont think these are used!*/

#ifndef ZEND_ENGINE_2
void apc_serialize_zend_overloaded_element(zend_overloaded_element* zoe TSRMLS_DC)
{
	SERIALIZE_SCALAR(zoe->type, zend_uchar);
	apc_serialize_zval(&zoe->element, NULL TSRMLS_CC);
}

void apc_deserialize_zend_overloaded_element(zend_overloaded_element* zoe TSRMLS_DC)
{
	DESERIALIZE_SCALAR(&zoe->type, zend_uchar);
	apc_deserialize_zval(&zoe->element, NULL TSRMLS_CC);
}
#endif

/* type: zend_class_entry */

	
void apc_serialize_zend_class_entry(zend_class_entry* zce , char* force_parent_name, int force_parent_len, char* force_key, int force_key_len TSRMLS_DC)
{
	/* other than sending to a stream it also does a callback! 
	
	The Array for a Class entry should look like:
	 NOT::Type? - what is this used for?
	 Name
	 Parent
	 NOT::refcount[0] ??
	 NOT::constants_updated ??
	 NOT::call,set etc: - would these point to a 'method?' !!
	ZEND_DECLARE_FUNCTION_OR_CLASS
	*/
	  
	   
	
	zend_function_entry* zfe;
	int count, i;
	 
	
	
	
	 
	BCOMPILER_DEBUG(("adding type : %i\n",zce->type )); 
	SERIALIZE_SCALAR(zce->type, char);
#if PHP_MAJOR_VERSION >= 6
	apc_serialize_zstring(ZS2S(zce->name), UG(unicode) ? UBYTES(zce->name_length) : zce->name_length TSRMLS_CC);
#else
	apc_serialize_zstring(zce->name, zce->name_length TSRMLS_CC);
#endif
	SERIALIZE_SCALAR(zce->name_length, uint);
	
	/* Serialize the name of this class's parent class (if it has one)
	 * so that we can perform inheritance during deserialization (see
	 * apc_deserialize_zend_class_entry). */
	
	
	
	if (zce->parent != NULL) {
		/*Parent*/ 
		SERIALIZE_SCALAR(1, char);
#if PHP_MAJOR_VERSION >= 6
		apc_serialize_zstring(ZS2S(zce->parent->name), UG(unicode) ? UBYTES(zce->parent->name_length) : zce->parent->name_length TSRMLS_CC);
#else
		apc_serialize_zstring(zce->parent->name, zce->parent->name_length TSRMLS_CC);
#endif
	} else if (force_parent_len > 0) {
		SERIALIZE_SCALAR(1, char);
		apc_serialize_zstring(force_parent_name, force_parent_len TSRMLS_CC);
	} else {
		SERIALIZE_SCALAR(0, char);
	}	
	
	
	
	/* now callback to class/funct etc. */
	 
	
	
	
#ifdef ZEND_ENGINE_2
	SERIALIZE_SCALAR(zce->refcount  	     , int);
#else
	SERIALIZE_SCALAR(*(zce->refcount)  	     , int);
#endif
	SERIALIZE_SCALAR(zce->constants_updated, zend_bool);
#ifdef ZEND_ENGINE_2
	SERIALIZE_SCALAR(zce->ce_flags, 	 zend_uint);
#endif
	
	BCOMPILER_DEBUG(("-----------------------------\nFUNC TABLE:\n")); 
	BCOMPILERG(cur_zc) = zce;
	apc_serialize_hashtable(&zce->function_table, apc_serialize_zend_function TSRMLS_CC);
	BCOMPILERG(cur_zc) = NULL;
	BCOMPILER_DEBUG(("-----------------------------\nVARS:\n"));
	apc_serialize_hashtable(&zce->default_properties, apc_serialize_zval_ptr TSRMLS_CC);
#ifdef ZEND_ENGINE_2
	BCOMPILER_DEBUG(("-----------------------------\nPROP INFO:\n"));
	apc_serialize_hashtable(&zce->properties_info, apc_serialize_zend_property_info TSRMLS_CC);
#ifdef ZEND_ENGINE_2_1
	/* new for 0.12 */
	if (BCOMPILERG(current_write) >= 0x000c) {
		BCOMPILER_DEBUG(("-----------------------------\nDEFAULT STATIC MEMBERS:\n"));
		apc_serialize_hashtable(&zce->default_static_members, apc_serialize_zval_ptr TSRMLS_CC);
	}
#endif
	/* not sure if statics should be dumped... (val: surely not for ZE v2.1) */
	BCOMPILER_DEBUG(("-----------------------------\nSTATICS?:\n"));
#ifdef ZEND_ENGINE_2_1
	apc_serialize_hashtable(NULL, apc_serialize_zval_ptr TSRMLS_CC);
#else
	apc_serialize_hashtable(zce->static_members, apc_serialize_zval_ptr TSRMLS_CC);
#endif

	BCOMPILER_DEBUG(("-----------------------------\nCONSTANTS?:\n"));
	apc_serialize_hashtable(&zce->constants_table, apc_serialize_zval_ptr TSRMLS_CC);
#endif
	/* zend_class_entry.builtin_functions: this array appears to be
	 * terminated by an element where zend_function_entry.fname is null 
	 * First we count the number of elements, then we serialize that count
	 * and all the functions. */
	BCOMPILER_DEBUG(("-----------------------------\nBUILTIN:\n"));
	count = 0;
	if (zce->type == ZEND_INTERNAL_CLASS && zce->builtin_functions) { 
		for (zfe = zce->builtin_functions; zfe->fname != NULL; zfe++) {
			count++;
		}
	}
	
	SERIALIZE_SCALAR(count, int);
	for (i = 0; i < count; i++) {
		apc_serialize_zend_function_entry(&zce->builtin_functions[i] TSRMLS_CC);
	}
#ifndef ZEND_ENGINE_2
	/** old code: SERIALIZE_SCALAR(zce->handle_function_call, void*); */
	/** old code: SERIALIZE_SCALAR(zce->handle_property_get, void*); */
	/** old code: SERIALIZE_SCALAR(zce->handle_property_set, void*); */
	if (BCOMPILERG(current_write) < 0x0005) {
		SERIALIZE_SCALAR(0, ulong); /* zce->handle_function_call */
		SERIALIZE_SCALAR(0, ulong); /* zce->handle_property_get */
		SERIALIZE_SCALAR(0, ulong); /* zce->handle_property_set */
	}
#endif
#ifdef ZEND_ENGINE_2
	if (BCOMPILERG(current_write) >= 0x0005) {
		SERIALIZE_SCALAR(zce->num_interfaces, zend_uint);
	}
#endif
	/* to be done for ZEND_ENGINE_2 * /
	if (BCOMPILERG(current_write) >= 0x0005) {

	zend_class_iterator_funcs iterator_funcs;

	zend_object_value (*create_object)(zend_class_entry *class_type TSRMLS_DC);
	zend_object_iterator *(*get_iterator)(zend_class_entry *ce, zval *object TSRMLS_DC);
	int (*interface_gets_implemented)(zend_class_entry *iface, zend_class_entry *class_type TSRMLS_DC);

+	zend_class_entry **interfaces; // simply emalloc() works fine to deserialize
+	zend_uint num_interfaces;

	char *filename;               // val: don't think it's really needed
	zend_uint line_start;         // ...too
	zend_uint line_end;           // ...too
	char *doc_comment;            // ...and this one
	zend_uint doc_comment_len;
	
	struct _zend_module_entry *module;

	}
	/ * to be done for ZEND_ENGINE_2 ends */
	/* val: new!! add hash key for the class if set, 0 otherwise */
	if (BCOMPILERG(current_write) >= 0x0005) {
		if (force_key && force_key_len) {
#if PHP_MAJOR_VERSION >= 6
			if (force_key_len < 0) {
				SERIALIZE_SCALAR(-force_key_len, char);
				apc_serialize_zstring(force_key, UBYTES(-force_key_len) TSRMLS_CC);
			} else {
#endif
			SERIALIZE_SCALAR(force_key_len, char);
			apc_serialize_zstring(force_key, force_key_len TSRMLS_CC);
#if PHP_MAJOR_VERSION >= 6
			}
#endif
		}
       		else SERIALIZE_SCALAR(0, char);
	}
}
#ifdef ZEND_ENGINE_2
static void zend_destroy_property_info(zend_property_info *property_info)
{
    efree(ZS2S(property_info->name));
}
#endif
void apc_deserialize_zend_class_entry(zend_class_entry* zce, char **key, int *key_len TSRMLS_DC)
{
	
	int count, i, exists;
	char* parent_name = NULL;  // name of parent class 
#ifdef ZEND_ENGINE_2
	zend_class_entry **pce;
#endif

	DESERIALIZE_SCALAR(&zce->type, char);
	apc_create_string2(&ZS2S(zce->name), -1 TSRMLS_CC);
	DESERIALIZE_SCALAR(&zce->name_length, uint);

	zce->parent = NULL;
	DESERIALIZE_SCALAR(&exists, char);
	if (exists > 0) {
		
		// This class knows the name of its parent, most likely because
		// its parent is defined in the same source file. Therefore, we
		// can simply restore the parent link, and not worry about
		// manually inheriting methods from the parent (PHP will perform
		// the inheritance). 
			 
		
	
		apc_create_string2(&parent_name, -1 TSRMLS_CC);
		BCOMPILER_DEBUG(("PARENT %s\n",parent_name));
#if PHP_MAJOR_VERSION >= 6
		if (zend_lookup_class(parent_name, BCOMPILERG(is_unicode) ? u_strlen((UChar*)parent_name) : strlen(parent_name), &pce TSRMLS_CC) == FAILURE)
#elif defined(ZEND_ENGINE_2)
		if (zend_lookup_class(parent_name, strlen(parent_name), &pce TSRMLS_CC) == FAILURE)
#else
		if ((zend_hash_find(CG(class_table), parent_name,
			strlen(parent_name) + 1, (void**) &zce->parent) == FAILURE))
#endif
		{
			php_error(E_ERROR, "unable to inherit %s", parent_name);
		}
#ifdef ZEND_ENGINE_2
		else zce->parent = *pce; //*((zend_class_entry**)zce->parent);
#endif
	}

	/* refcount is a pointer to a single int.  Don't ask me why, I
	// just work here;. */
 
	
#ifdef ZEND_ENGINE_2
	DESERIALIZE_SCALAR(&zce->refcount, int);
	if (BCOMPILERG(current_include)) {
		zce->refcount = 1; /* val: to avoid memort leaks */
	}
#else
	zce->refcount = (int*) emalloc(sizeof(int));
	DESERIALIZE_SCALAR(zce->refcount, int);
	if (BCOMPILERG(current_include)) {
		*zce->refcount = 1; /* val: to avoid memort leaks */
	}
#endif
	DESERIALIZE_SCALAR(&zce->constants_updated, zend_bool);
#ifdef ZEND_ENGINE_2
	DESERIALIZE_SCALAR(&zce->ce_flags, zend_uint);
#endif
	BCOMPILERG(cur_zc) = zce;
	BCOMPILER_DEBUG(("-----------------------------\nFUNC TABLE:\n"));
	DESERIALIZE_SCALAR(&exists, char);
	apc_deserialize_hashtable(
		&zce->function_table, 
		(void*) apc_create_zend_function, 
		(void*) apc_free_zend_function,
		(int) sizeof(zend_function) , 
		(char) exists TSRMLS_CC);
	BCOMPILERG(cur_zc) = NULL;
		
	BCOMPILER_DEBUG(("-----------------------------\nVARS:\n")); 
	DESERIALIZE_SCALAR(&exists, char);
	apc_deserialize_hashtable(
		&zce->default_properties,  
		(void*) apc_create_zval,  
		(void*) NULL, 
		(int) sizeof(zval *),  
		(char)exists TSRMLS_CC);
#ifdef ZEND_ENGINE_2
	BCOMPILER_DEBUG(("-----------------------------\nPROP INFO:\n")); 
	DESERIALIZE_SCALAR(&exists, char);
	apc_deserialize_hashtable(
		&zce->properties_info, 
		(void*) apc_create_zend_property_info, 
		(void*) apc_free_zend_property_info,
		(int) sizeof(zend_property_info) , 
		(char) exists TSRMLS_CC);
	zce->properties_info.pDestructor = (dtor_func_t)&zend_destroy_property_info;
#ifdef ZEND_ENGINE_2_1
	if (BCOMPILERG(current_version) >= 0x000c) {
		BCOMPILER_DEBUG(("-----------------------------\nDEFAULT STATIC MEMBERS:\n")); 
		DESERIALIZE_SCALAR(&exists, char);
		apc_deserialize_hashtable(
			&zce->default_static_members,  
			(void*) apc_create_zval,  
			(void*) NULL, 
			(int) sizeof(zval *),  
			(char)exists TSRMLS_CC);
	}
#endif
	BCOMPILER_DEBUG(("-----------------------------\nSTATICS?:\n")); 
	DESERIALIZE_SCALAR(&exists, char);
	if (exists) {
		ALLOC_HASHTABLE(zce->static_members);
		apc_deserialize_hashtable(
			zce->static_members,  
			(void*) apc_create_zval,  
			(void*) NULL, 
			(int) sizeof(zval *),
			(char)exists TSRMLS_CC);
#ifdef ZEND_ENGINE_2_1
		/* seems that this hash is not used any more */
		zend_hash_destroy(zce->static_members);
		FREE_HASHTABLE(zce->static_members);
		zce->static_members = &zce->default_static_members;
#endif
	}
	else 
#ifdef ZEND_ENGINE_2_1
		zce->static_members = &zce->default_static_members;
#else
		zce->static_members = NULL;
#endif

	BCOMPILER_DEBUG(("-----------------------------\nCONSTANTS:\n")); 
	DESERIALIZE_SCALAR(&exists, char);
	apc_deserialize_hashtable(
		&zce->constants_table,  
		(void*) apc_create_zval,  
		(void*) NULL, 
		(int) sizeof(zval *),  
		(char)exists TSRMLS_CC);
#endif
	// see apc_serialize_zend_class_entry() for a description of the
	// zend_class_entry.builtin_functions member 

	DESERIALIZE_SCALAR(&count, int);
	zce->builtin_functions = NULL;
	if (count > 0) {
		zce->builtin_functions = (zend_function_entry*) emalloc((count+1) * sizeof(zend_function_entry));
		zce->builtin_functions[count].fname = NULL;
		for (i = 0; i < count; i++) {
			apc_deserialize_zend_function_entry(&zce->builtin_functions[i] TSRMLS_CC);
		}
	}
#ifndef ZEND_ENGINE_2
	/** old code: DESERIALIZE_SCALAR(&zce->handle_function_call, void*); */
	/** old code: DESERIALIZE_SCALAR(&zce->handle_property_get, void*); */
	/** old code: DESERIALIZE_SCALAR(&zce->handle_property_set, void*); */
	if (BCOMPILERG(current_version) < 0x0005) {
		DESERIALIZE_VOID(ulong); /* &zce->handle_function_call */
		DESERIALIZE_VOID(ulong); /* &zce->handle_property_get */
		DESERIALIZE_VOID(ulong); /* &zce->handle_property_set */
	}
	zce->handle_function_call = NULL;
	zce->handle_property_get = NULL;
	zce->handle_property_set = NULL;
#endif
#ifdef ZEND_ENGINE_2
	if (BCOMPILERG(current_version) >= 0x0005) {
		DESERIALIZE_SCALAR(&zce->num_interfaces, zend_uint);
		if (zce->num_interfaces) {
			zce->interfaces = emalloc(zce->num_interfaces*sizeof(*zce->interfaces));
		}
	}
#endif
  
	/* val: new!! restore key in class hash */
	if (key_len) *key_len = 0;
	if (key) *key = NULL;
	if (BCOMPILERG(current_version) >= 0x0005) {
		DESERIALIZE_SCALAR(&exists, char);
		if (exists > 0 && key_len && key) {
			*key_len = exists;
			apc_create_string2(key, -1 TSRMLS_CC);
		}
	}

	/* Resolve the inheritance relationships that have been delayed and
	 * are waiting for this class to be created, i.e., every child of
	 * this class that has already been compiled needs to be inherited
	 * from this class. Call inherit() with this class as the base class
	 * (first parameter) and as the current parent class (second parameter).
	 * inherit will recursively resolve every inheritance relationships
	 * in which this class is the base. */

	  /*
	  Since we now can do inheritance by striping - this is usefull..
	  
	  */
	  
	if (zce->parent) {
		 bcompiler_inherit(zce TSRMLS_CC); 
	}
	if (parent_name) {
		apclib_free_string(&parent_name);  
	}
}

void apc_create_zend_class_entry(zend_class_entry** zce, char** key, int* key_len TSRMLS_DC)
{

	*zce = (zend_class_entry*) emalloc(sizeof(zend_class_entry));
	memset(*zce, 0, sizeof(**zce));
	apc_deserialize_zend_class_entry(*zce, key, key_len TSRMLS_CC);

}

 
  

/* type: znode */


void apc_serialize_znode(znode* zn TSRMLS_DC)
{
	SERIALIZE_SCALAR(zn->op_type, int);

	/* If the znode's op_type is IS_CONST, we know precisely what it is.
	 * otherwise, it is too case-dependent (or inscrutable), so we do
	 * a bitwise copy. */
	 
		 
	switch(zn->op_type) {
		case IS_CONST: 

			apc_serialize_zval(&zn->u.constant, zn TSRMLS_CC);
			break;

		case IS_VAR:
		case IS_TMP_VAR:
		case IS_UNUSED:
		default:

			if (BCOMPILERG(current_write) >= 0x0005) {
				/* make zn->u's size-safe */
				SERIALIZE_SCALAR(zn->u.EA.var,  zend_uint);
				SERIALIZE_SCALAR(zn->u.EA.type, zend_uint);
			} else {
				STORE_BYTES(&zn->u, sizeof(zn->u));
			}
			break;
	}
}

void apc_deserialize_znode(znode* zn TSRMLS_DC)
{
	DESERIALIZE_SCALAR(&zn->op_type, int);

	/* If the znode's op_type is IS_CONST, we know precisely what it is.
	 * otherwise, it is too case-dependent (or inscrutable), so we do
	 * a bitwise copy. */
	
	switch(zn->op_type) 
	{
	case IS_CONST:
		apc_deserialize_zval(&zn->u.constant, zn TSRMLS_CC);
		break;
	default:
		/* make zn->u's size-safe */
		if (BCOMPILERG(current_version) >= 0x0005) {
			DESERIALIZE_SCALAR(&zn->u.EA.var,  zend_uint);
			DESERIALIZE_SCALAR(&zn->u.EA.type, zend_uint);
		} else {
			LOAD_BYTES(&zn->u, sizeof(zn->u));
		}
		break;
	}
}


/* type: zend_op */


void apc_serialize_zend_op(int id, zend_op* zo, zend_op_array* zoa TSRMLS_DC)
{
	 
	BCOMPILER_DEBUG(("Outputting %s\n", getOpcodeName(zo->opcode)));
	SERIALIZE_SCALAR(zo->opcode, zend_uchar);
	
	apc_serialize_znode(&zo->result TSRMLS_CC);
	
#ifdef ZEND_ENGINE_2
	/* convert raw jump address to opline number */
	switch (zo->opcode)
	{
		case ZEND_JMP:
			zo->op1.u.opline_num = zo->op1.u.jmp_addr - zoa->opcodes;
			break;
		case ZEND_JMPZ:
		case ZEND_JMPNZ:
		case ZEND_JMPZ_EX:
		case ZEND_JMPNZ_EX:
			zo->op2.u.opline_num = zo->op2.u.jmp_addr - zoa->opcodes;
			break;
	}
#endif

	apc_serialize_znode(&zo->op1 TSRMLS_CC);
	
	apc_serialize_znode(&zo->op2 TSRMLS_CC);
	
	SERIALIZE_SCALAR(zo->extended_value, ulong);
	if (zo->extended_value != 0) {
		
	}
	
	SERIALIZE_SCALAR(zo->lineno, uint);
}

void apc_deserialize_zend_op(zend_op* zo, zend_op_array* zoa TSRMLS_DC)
{
	
	DESERIALIZE_SCALAR(&zo->opcode, zend_uchar);
	BCOMPILER_DEBUG(("Outputting %s\n", getOpcodeName(zo->opcode)));
	apc_deserialize_znode(&zo->result TSRMLS_CC);
	apc_deserialize_znode(&zo->op1 TSRMLS_CC);
	apc_deserialize_znode(&zo->op2 TSRMLS_CC);
#if defined(ZEND_ENGINE_2_1)
    ZEND_VM_SET_OPCODE_HANDLER(zo);
#elif defined(ZEND_ENGINE_2)
	zo->handler = zend_opcode_handlers[zo->opcode];
#endif
#ifdef ZEND_ENGINE_2
	/* convert opline number back to raw jump address */
	switch (zo->opcode)
	{
		case ZEND_JMP:
			zo->op1.u.jmp_addr = zoa->opcodes + zo->op1.u.opline_num;
			break;
		case ZEND_JMPZ:
		case ZEND_JMPNZ:
		case ZEND_JMPZ_EX:
		case ZEND_JMPNZ_EX:
			zo->op2.u.jmp_addr = zoa->opcodes + zo->op2.u.opline_num;
			break;
	}
#endif
	DESERIALIZE_SCALAR(&zo->extended_value, ulong);
	DESERIALIZE_SCALAR(&zo->lineno, uint);
}


/* type: zend_op_array */



void apc_serialize_zend_op_array(zend_op_array* zoa TSRMLS_DC)
{
	char exists;
	int i;
#if PHP_MAJOR_VERSION >= 6	
	int len;
#endif
	
	SERIALIZE_SCALAR(zoa->type, zend_uchar);
#ifdef ZEND_ENGINE_2
	SERIALIZE_SCALAR(zoa->num_args, int);
	for (i=0; i< zoa->num_args; i++) {
		apc_serialize_arg_info(&zoa->arg_info[i] TSRMLS_CC);
	}
#else
	apc_serialize_arg_types(zoa->arg_types TSRMLS_CC);
#endif

#if PHP_MAJOR_VERSION >= 6
	if (zoa->function_name.s == NULL) len = -1;
	else if (UG(unicode)) len = u_strlen(zoa->function_name.u) * sizeof(UChar);
	else len = strlen(zoa->function_name.s);
	apc_serialize_zstring(zoa->function_name.s, len TSRMLS_CC);
#else
	apc_serialize_string(zoa->function_name TSRMLS_CC);
#endif
	SERIALIZE_SCALAR(zoa->refcount[0], zend_uint);
	SERIALIZE_SCALAR(zoa->last, zend_uint);
	SERIALIZE_SCALAR(zoa->size, zend_uint);

	/* If a file 'A' is included twice in a single request, the following 
	 * situation can occur: A is deserialized and its functions added to
	 * the global function table. On its next call, A is expired (either
	 * forcibly removed or removed due to an expired ttl). Now when A is
	 * compiled, its functions can't be added to the global function_table
	 * (they are already present) so they are serialized as an opcode
	 * ZEND_DECLARE_FUNCTION_OR_CLASS. This means that the functions will
	 * be declared at execution time. Since they are present in the global
	 * function_table, they will will also be serialized. This will cause
	 * a fatal 'failed to redclare....' error.  We avoid this by simulating
	 * the action of the parser and changing all
	 * ZEND_DECLARE_FUNCTION_OR_CLASS opcodes to ZEND_NOPs. */ 
	  
	
	for (i = 0; i < (int) zoa->last; i++) {
	  
		apc_serialize_zend_op(i, &zoa->opcodes[i], zoa TSRMLS_CC);
	}

	SERIALIZE_SCALAR(zoa->T, zend_uint);
	SERIALIZE_SCALAR(zoa->last_brk_cont, zend_uint);
	SERIALIZE_SCALAR(zoa->current_brk_cont, zend_uint);
#ifndef ZEND_ENGINE_2
	SERIALIZE_SCALAR(zoa->uses_globals, zend_bool);
#endif
	
	exists = (zoa->brk_cont_array != NULL) ? 1 : 0;
	SERIALIZE_SCALAR(exists, char);
	if (exists) {
		STORE_BYTES(zoa->brk_cont_array, zoa->last_brk_cont *
			sizeof(zend_brk_cont_element));
	}
	apc_serialize_hashtable(zoa->static_variables, apc_serialize_zval_ptr TSRMLS_CC);
	assert(zoa->start_op == NULL);
	SERIALIZE_SCALAR(zoa->return_reference, zend_bool);
	SERIALIZE_SCALAR(zoa->done_pass_two, zend_bool);
	apc_serialize_string(zoa->filename TSRMLS_CC);
	
#ifdef ZEND_ENGINE_2
	if (BCOMPILERG(current_write) >= 0x0005) {
#if PHP_MAJOR_VERSION >= 6
		int len;
		if (zoa->scope == NULL) len = -1;
		else if (zoa->scope->name.s == NULL) len = -1;
		else if (UG(unicode)) len = u_strlen(zoa->scope->name.u) * sizeof(UChar);
		else len = strlen(zoa->scope->name.s);
		apc_serialize_zstring(zoa->scope ? zoa->scope->name.s : NULL, len TSRMLS_CC);
#else
		apc_serialize_string(zoa->scope ? zoa->scope->name : NULL TSRMLS_CC);
#endif
		SERIALIZE_SCALAR(zoa->fn_flags, zend_uint);
		SERIALIZE_SCALAR(zoa->required_num_args, zend_uint);
		SERIALIZE_SCALAR(zoa->pass_rest_by_reference, zend_bool);

		SERIALIZE_SCALAR(zoa->backpatch_count, int);
		SERIALIZE_SCALAR(zoa->uses_this, zend_bool);
	}
#endif

#ifdef ZEND_ENGINE_2_1
	if (BCOMPILERG(current_write) >= 0x0007) {
		SERIALIZE_SCALAR(zoa->last_var, int);
		SERIALIZE_SCALAR(zoa->size_var, int);
		for (i = 0; i < zoa->last_var; i++) {
			SERIALIZE_SCALAR(zoa->vars[i].name_len, int);
			apc_serialize_zstring(ZS2S(zoa->vars[i].name), zoa->vars[i].name_len TSRMLS_CC);
			SERIALIZE_SCALAR(zoa->vars[i].hash_value, ulong);
		}
	}
#endif

#ifdef ZEND_ENGINE_2
	if (BCOMPILERG(current_write) >= 0x000d) {
		if (zoa->try_catch_array != NULL && zoa->last_try_catch > 0) {
			SERIALIZE_SCALAR(zoa->last_try_catch, int);
			STORE_BYTES(zoa->try_catch_array, zoa->last_try_catch * sizeof(zend_try_catch_element));
		} else {
			SERIALIZE_SCALAR(0, int);
		}
	}
#endif
	
	/* zend_op_array.reserved is not used */
	/* to be done for ZEND_ENGINE2: * /

	union _zend_function *prototype; // val: it seems to be used only on compilation stage

	char *doc_comment; // val: i don't think comments are to be included in bytecode
	zend_uint doc_comment_len;

	/ * */
}

void apc_deserialize_zend_op_array(zend_op_array* zoa, int master TSRMLS_DC)
{
	char *fname;
	char exists;
	int i;

	DESERIALIZE_SCALAR(&zoa->type, zend_uchar);
#ifdef ZEND_ENGINE_2
	DESERIALIZE_SCALAR(&zoa->num_args, int);
	zoa->arg_info = (zend_arg_info *) ecalloc(zoa->num_args, sizeof(zend_arg_info));
	for (i=0; i< zoa->num_args; i++) {
		apc_create_arg_info(&zoa->arg_info[i] TSRMLS_CC);
	}
#else
	apc_create_arg_types(&zoa->arg_types TSRMLS_CC);
#endif
	
	apc_create_string2(&ZS2S(zoa->function_name), -1 TSRMLS_CC);
	zoa->refcount = (int*) emalloc(sizeof(zend_uint));
	DESERIALIZE_SCALAR(zoa->refcount, zend_uint);
	if (BCOMPILERG(current_include)) {
		*zoa->refcount = 1; /* val: to avoid memort leaks */
	}
	DESERIALIZE_SCALAR(&zoa->last, zend_uint);
	DESERIALIZE_SCALAR(&zoa->size, zend_uint);

	zoa->opcodes = NULL;

	if (zoa->last > 0) {
		zoa->opcodes = (zend_op*) emalloc(zoa->last * sizeof(zend_op));

		for (i = 0; i < (int) zoa->last; i++) {
			apc_deserialize_zend_op(&zoa->opcodes[i], zoa TSRMLS_CC);
#ifdef DISABLED
			/* val: following code is not needed for include(), etc - maybe, it's of no use at all? */
			if (!BCOMPILERG(current_include) &&
			    zoa->opcodes[i].opcode == ZEND_DECLARE_FUNCTION_OR_CLASS) {
				HashTable* table;
				char* op2str;   /* op2str and op2len are for convenience */
				int op2len;
	
				exists = 1;
			
				op2str = zoa->opcodes[i].op2.u.constant.value.str.val;
				op2len = zoa->opcodes[i].op2.u.constant.value.str.len;
	
				switch(zoa->opcodes[i].extended_value) 
				{
					/* a run-time function declaration */
					case ZEND_DECLARE_FUNCTION: 
						{
							zend_function* function;
							
							table = CG(function_table);
							
							if (zend_hash_find(table, op2str, op2len + 1,
								(void**) &function) == SUCCESS) 
							{
								zval_dtor(&zoa->opcodes[i].op1.u.constant);
								zval_dtor(&zoa->opcodes[i].op2.u.constant);
								zoa->opcodes[i].opcode = ZEND_NOP;
								memset(&zoa->opcodes[i].op1, 0, sizeof(znode));
								memset(&zoa->opcodes[i].op2, 0, sizeof(znode));
								zoa->opcodes[i].op1.op_type = IS_UNUSED;
								zoa->opcodes[i].op2.op_type = IS_UNUSED;
							}
						} 
						break;
						  
					/* a run-time class declaration */
					case ZEND_DECLARE_CLASS: 
						{
							zend_class_entry *ce;
							
							table = CG(class_table);
							
							if (zend_hash_find(table, op2str, op2len + 1,
								(void**) &ce) == SUCCESS) {
								zval_dtor(&zoa->opcodes[i].op1.u.constant);
								zval_dtor(&zoa->opcodes[i].op2.u.constant);
								zoa->opcodes[i].opcode = ZEND_NOP;
								memset(&zoa->opcodes[i].op1, 0, sizeof(znode));
								memset(&zoa->opcodes[i].op2, 0, sizeof(znode));
								zoa->opcodes[i].op1.op_type = IS_UNUSED;
								zoa->opcodes[i].op2.op_type = IS_UNUSED;
							}
						} 
						break;
					
					  /* a run-time derived class declaration */
					case ZEND_DECLARE_INHERITED_CLASS: 
						{
							zend_class_entry *ce;
							char* class_name;
							char* parent_name;
							int class_name_length;
							namearray_t* children = 0;
							int minSize;
							
							table = CG(class_table);
							
							/* op2str is a class name of the form "base:derived",
							 * where derived is the class being declared and base
							 * is its parent in the class hierarchy. Extract the
							 * two names into parent_name and class_name. */
							
							parent_name = apclib_estrdup(op2str);
							if ((class_name = strchr(parent_name, ':')) == 0) {
								zend_error(E_CORE_ERROR,"Invalid runtime class entry");
							}
							*class_name++ = '\0';   /* advance past ':' */
				
							if (zend_hash_find(table, class_name, strlen(class_name)+1,
								(void**) &ce) == SUCCESS) 
							{
								zval_dtor(&zoa->opcodes[i].op1.u.constant);
								zval_dtor(&zoa->opcodes[i].op2.u.constant);
								zoa->opcodes[i].opcode = ZEND_NOP;
								memset(&zoa->opcodes[i].op1, 0, sizeof(znode));
								memset(&zoa->opcodes[i].op2, 0, sizeof(znode));
								zoa->opcodes[i].op1.op_type = IS_UNUSED;
								zoa->opcodes[i].op2.op_type = IS_UNUSED;
							}
				
							/* The parent class hasn't been compiled yet, most likely
							 * because it is defined in an included file. We must defer
							 * this inheritance until the parent class is created. Add
							 * a tuple for this class and its parent to the deferred
							 * inheritance table */
					
							class_name_length = strlen(class_name);
							//children = apc_nametable_retrieve(deferred_inheritance,
							//                                  parent_name TSRMLS_CC);
					
							if (children == 0) {
								/* Create and initialize a new namearray_t for this
								 * class's parent and insert into the deferred
								 * inheritance table. */
						
								children = (namearray_t*) malloc(sizeof(namearray_t));
								children->length = 0;
								children->size = class_name_length + 1;
								children->strings = (char*) malloc(children->size);
						
								//apc_nametable_insert(deferred_inheritance,
								//                     parent_name, children TSRMLS_CC);
							}
				
							/* a deferred class can't be a top-level parent */
							//apc_nametable_insert(non_inheritors, class_name, NULL TSRMLS_CC);
				
				
							minSize = children->length + class_name_length + 1;
					
							if (minSize > children->size) {
								/* The strings array (children->strings) is not big
								 * enough to store this class name. Expand the array
								 * using an exponential resize. */
					
								while (minSize > children->size) {
									children->size *= 2;
								}
								children->strings = apclib_erealloc(children->strings,
										 children->size);
							}
							memcpy(children->strings + children->length,
							class_name, class_name_length + 1);
							children->length += class_name_length + 1;
						}
						break;
			
					default:
						break;
				}
				 
			}
			/* /code that isn't needed for include(), etc */
#endif
		}
	}

	DESERIALIZE_SCALAR(&zoa->T, zend_uint);
	DESERIALIZE_SCALAR(&zoa->last_brk_cont, zend_uint);
	DESERIALIZE_SCALAR(&zoa->current_brk_cont, zend_uint);
#ifndef ZEND_ENGINE_2
	DESERIALIZE_SCALAR(&zoa->uses_globals, zend_bool);
#endif
	
	DESERIALIZE_SCALAR(&exists, char);
	zoa->brk_cont_array = NULL;
	if (exists) {
		zoa->brk_cont_array = (zend_brk_cont_element*)
		emalloc(zoa->last_brk_cont * sizeof(zend_brk_cont_element));
		LOAD_BYTES(zoa->brk_cont_array, zoa->last_brk_cont *
		sizeof(zend_brk_cont_element));
	}
	apc_create_hashtable(&zoa->static_variables, apc_create_zval, NULL, sizeof(zval *) TSRMLS_CC);
 
	zoa->start_op = NULL;
 
	DESERIALIZE_SCALAR(&zoa->return_reference, zend_bool);
	DESERIALIZE_SCALAR(&zoa->done_pass_two, zend_bool);
	apc_create_string2(&fname, -1 TSRMLS_CC);
	zoa->filename = zend_set_compiled_filename(fname TSRMLS_CC);
	apclib_free_string(&fname);
#ifdef ZEND_ENGINE_2
	if (BCOMPILERG(current_version) >= 0x0005) {
		apc_create_string2(&fname, -1 TSRMLS_CC);
		zoa->scope = NULL;
		if (*fname) {
			zend_class_entry **ce = NULL;
#if PHP_MAJOR_VERSION >= 6
			int cmp = BCOMPILERG(is_unicode) ?
						u_strcmp((UChar*)fname, BCOMPILERG(cur_zc)->name.u) :
						strcmp(fname, BCOMPILERG(cur_zc)->name.s);
#else
			int cmp = strcmp(fname, BCOMPILERG(cur_zc)->name);
#endif
			if (BCOMPILERG(cur_zc) && !cmp) {
				ce = &(BCOMPILERG(cur_zc));
			}
#if PHP_MAJOR_VERSION >= 6
			else if (SUCCESS != zend_u_hash_find(CG(class_table), BCOMPILERG(is_unicode) ? IS_UNICODE : IS_STRING, ZSTR(fname), BCOMPILERG(is_unicode) ? u_strlen((UChar*)fname)+1 : strlen(fname)+1, (void **)&ce)) {
#else
			else if (SUCCESS != zend_hash_find(CG(class_table), fname, strlen(fname)+1, (void **)&ce)) {
#endif
				BCOMPILER_DEBUG(("Could not find class scope: %s\n", fname));
			}
			if (ce && *ce) {
				BCOMPILER_DEBUG(("Found class scope: %s [%p]\n", (*ce)->name, *ce));
				zoa->scope = *ce;
			}
		}
		apclib_free_string(&fname);
		DESERIALIZE_SCALAR(&zoa->fn_flags, zend_uint);
		DESERIALIZE_SCALAR(&zoa->required_num_args, zend_uint);
		DESERIALIZE_SCALAR(&zoa->pass_rest_by_reference, zend_bool);
		DESERIALIZE_SCALAR(&zoa->backpatch_count, int);
		DESERIALIZE_SCALAR(&zoa->uses_this, zend_bool);
	}
#endif

#ifdef ZEND_ENGINE_2_1
	if (BCOMPILERG(current_version) >= 0x0007) {
		DESERIALIZE_SCALAR(&zoa->last_var, int);
		DESERIALIZE_SCALAR(&zoa->size_var, int);
		if (zoa->size_var > 0) {
			zoa->vars = emalloc(zoa->size_var * sizeof(zoa->vars[0]));
			memset(zoa->vars, 0, zoa->size_var * sizeof(zoa->vars[0]));
			for (i = 0; i < zoa->last_var; i++) {
				DESERIALIZE_SCALAR(&(zoa->vars[i].name_len), int);
				apc_create_string2(&ZS2S(zoa->vars[i].name), -1 TSRMLS_CC);
				DESERIALIZE_SCALAR(&(zoa->vars[i].hash_value), ulong);
			}
		}
	}
#endif

#ifdef ZEND_ENGINE_2
	if (BCOMPILERG(current_version) >= 0x000d) {
		DESERIALIZE_SCALAR(&zoa->last_try_catch, int);
		if (zoa->last_try_catch > 0) {
			zoa->try_catch_array = (zend_try_catch_element*) emalloc(zoa->last_try_catch * sizeof(zend_try_catch_element));
			LOAD_BYTES(zoa->try_catch_array, zoa->last_try_catch * sizeof(zend_try_catch_element));
		}
	}
#endif

	if(master) {
		// apc_nametable_difference(parental_inheritors, non_inheritors TSRMLS_CC);
		// apc_nametable_apply(parental_inheritors, call_inherit TSRMLS_CC);
	}
}

void apc_create_zend_op_array(zend_op_array** zoa TSRMLS_DC)
{
	*zoa = (zend_op_array*) emalloc(sizeof(zend_op_array));
	memset(*zoa, 0, sizeof(zend_op_array)); /* ensure it's empty */
	apc_deserialize_zend_op_array(*zoa, 0 TSRMLS_CC);
}


/* type: zend_internal_function */


	
void apc_serialize_zend_internal_function(zend_internal_function* zif TSRMLS_DC)
{
	/* why on earth would we be serializeing this? 
	
	SERIALIZE_SCALAR(zif->type, zend_uchar);
	apc_serialize_arg_types(zif->arg_types TSRMLS_CC);
	apc_serialize_string(zif->function_name TSRMLS_CC);
	// ** old code SERIALIZE_SCALAR(zif->handler, void*);  
	*/
}

void apc_deserialize_zend_internal_function(zend_internal_function* zif TSRMLS_DC)
{
	/*
	DESERIALIZE_SCALAR(&zif->type, zend_uchar);
	apc_create_arg_types(&zif->arg_types TSRMLS_CC);
	apc_create_string(&zif->function_name TSRMLS_CC);
	// ** old code: DESERIALIZE_SCALAR(&zif->handler, void*);
	*/
}


/* type: zend_overloaded_function */

/*
void apc_serialize_zend_overloaded_function(zend_overloaded_function* zof TSRMLS_DC)
{
	SERIALIZE_SCALAR(zof->type, zend_uchar);
	apc_serialize_arg_types(zof->arg_types TSRMLS_CC);
	apc_serialize_string(zof->function_name TSRMLS_CC);
	SERIALIZE_SCALAR(zof->var, zend_uint);  
}

void apc_deserialize_zend_overloaded_function(zend_overloaded_function* zof TSRMLS_DC)
{
	DESERIALIZE_SCALAR(&zof->type, zend_uchar);
	apc_create_arg_types(&zof->arg_types TSRMLS_CC);
	apc_create_string(&zof->function_name TSRMLS_CC);
	DESERIALIZE_SCALAR(&zof->var, zend_uint);
}

*/
/* type: zend_function */

void apc_serialize_zend_function(zend_function* zf TSRMLS_DC)
{
	/* zend_function come in 4 different types with different internal 
	 * structs. */    
	
#ifdef ZEND_ENGINE_2
	/* val: don't include functions of other classes that are bound to this */
	if (BCOMPILERG(cur_zc) && BCOMPILERG(current_write) >= 0x0005) {
#if PHP_MAJOR_VERSION >= 6
		int cmp = BCOMPILERG(is_unicode) ?
						u_strcmp(BCOMPILERG(cur_zc)->name.u, zf->common.scope->name.u) :
						strcmp(BCOMPILERG(cur_zc)->name.s, zf->common.scope->name.s);
#else
		int cmp = strcmp(BCOMPILERG(cur_zc)->name, zf->common.scope->name);
#endif
		BCOMPILER_DEBUGFULL(("current class: %s; scope: %s\n", ZS2S(BCOMPILERG(cur_zc)->name), ZS2S(zf->common.scope->name)));
		if (cmp != 0) {
			SERIALIZE_SCALAR(0xff, zend_uchar);
			return;
		}
	}
#endif
	BCOMPILER_DEBUG(("start serialize zend function type:%d\n", zf->type));
	SERIALIZE_SCALAR(zf->type, zend_uchar);
#ifdef ZEND_ENGINE_2
	if (BCOMPILERG(current_write) >= 0x0005 && BCOMPILERG(cur_zc)) {
		int ftype = 0;
		zend_class_entry *zc = BCOMPILERG(cur_zc);

		if (zf == zc->constructor) {
			BCOMPILER_DEBUG(("> it's a constructor\n"));
			ftype |= 0x01;
	    }
		if (zf == zc->destructor) {
			BCOMPILER_DEBUG(("> it's a destructor\n"));
			ftype |= 0x02;
		}
		if (zf == zc->clone) {
			BCOMPILER_DEBUG(("> it's a clone handler\n"));
			ftype |= 0x04;
		}
		if (zf == zc->__get) {
			BCOMPILER_DEBUG(("> it's a __get handler\n"));
			ftype |= 0x08;
		}
		if (zf == zc->__set) {
			BCOMPILER_DEBUG(("> it's a __set handler\n"));
			ftype |= 0x10;
		}
		if (zf == zc->__call) {
			BCOMPILER_DEBUG(("> it's a __call handler\n"));
			ftype |= 0x20;
		}
#ifdef ZEND_ENGINE_2_1
	if (BCOMPILERG(current_write) >= 0x000a) {
		if (zf == zc->__unset) {
			BCOMPILER_DEBUG(("> it's an __unset handler\n"));
			ftype |= 0x40;
		}
		if (zf == zc->__isset) {
			BCOMPILER_DEBUG(("> it's an __isset handler\n"));
			ftype |= 0x80;
		}
		if (zf == zc->serialize_func) {
			BCOMPILER_DEBUG(("> it's a serialize_func handler\n"));
			ftype |= 0x100;
		}
		if (zf == zc->unserialize_func) {
			BCOMPILER_DEBUG(("> it's a unserialize_func handler\n"));
			ftype |= 0x200;
		}
	}
#endif
		if (BCOMPILERG(current_write) >= 0x000a) {
			SERIALIZE_SCALAR(ftype, int);
		} else {
			SERIALIZE_SCALAR(ftype, char);
		}
	}
#endif
	BCOMPILER_DEBUG(("start serialize zend function\n"));

	switch(zf->type) 
	{
		case ZEND_INTERNAL_FUNCTION:
			apc_serialize_zend_internal_function(&zf->internal_function TSRMLS_CC);
			break;
		/*
		case ZEND_OVERLOADED_FUNCTION:
			apc_serialize_zend_overloaded_function(&zf->overloaded_function TSRMLS_CC);
			break;
		*/
		case ZEND_USER_FUNCTION:
		case ZEND_EVAL_CODE:
			BCOMPILER_DEBUG(("start serialize op array\n"));
			apc_serialize_zend_op_array(&zf->op_array TSRMLS_CC);
			break;
		default:
			/* the above are all valid zend_function types.  If we hit this
			 * case something has gone very very wrong. */
			assert(0);
	}
}

int apc_deserialize_zend_function(zend_function* zf TSRMLS_DC)
{
	/* PEEK_SCALAR(&zf->type, zend_uchar); */
	DESERIALIZE_SCALAR_V(&zf->type, zend_uchar, -1);
	/* type 0xFF is reserved not to include a function */
	if (zf->type == 0xff) { return -1; }
#ifdef ZEND_ENGINE_2
	if (BCOMPILERG(current_version) >= 0x0005 && BCOMPILERG(cur_zc)) {
		int ftype;
		zend_class_entry *zc = BCOMPILERG(cur_zc);
	    
		if (BCOMPILERG(current_version) >= 0x000a) {
			DESERIALIZE_SCALAR_V(&ftype, int, -1);
		} else {
			DESERIALIZE_SCALAR_V(&ftype, char, -1);
		}
		if (ftype & 0x01) zc->constructor = zf;
		if (ftype & 0x02) zc->destructor = zf;
		if (ftype & 0x04) zc->clone = zf;
		if (ftype & 0x08) zc->__get = zf;
		if (ftype & 0x10) zc->__set = zf;
		if (ftype & 0x20) zc->__call = zf;
#ifdef ZEND_ENGINE_2_1
		if (ftype & 0x40) zc->__unset = zf;
		if (ftype & 0x80) zc->__isset = zf;
		if (ftype & 0x100) zc->serialize_func = zf;
		if (ftype & 0x200) zc->unserialize_func = zf;
#endif
	}
#endif
	switch(zf->type) 
	{
		case ZEND_INTERNAL_FUNCTION:
			apc_deserialize_zend_internal_function(&zf->internal_function TSRMLS_CC);
			break;
		/*
		case ZEND_OVERLOADED_FUNCTION:
			apc_deserialize_zend_overloaded_function(&zf->overloaded_function TSRMLS_CC);
			break;
		*/
		case ZEND_USER_FUNCTION:
		case ZEND_EVAL_CODE:
			apc_deserialize_zend_op_array(&zf->op_array, 0 TSRMLS_CC);
			break;
		default:
			/* the above are all valid zend_function types.  If we hit this
			 * case something has gone very very wrong. */
			if (!BCOMPILERG(parsing_error)) {
				php_error(E_WARNING, "bcompiler: Bad bytecode file format at %08x", (unsigned)php_stream_tell(BCOMPILERG(stream)));
				BCOMPILERG(parsing_error) = 1;
			}
			break;
	}
	return 0;
}

void apc_create_zend_function(zend_function** zf TSRMLS_DC)
{
	*zf = (zend_function*) emalloc(sizeof(zend_function));
	memset(*zf, 0, sizeof(zend_function)); /* ensure it's empty */
	if (apc_deserialize_zend_function(*zf TSRMLS_CC) == -1) {
		efree(*zf);
		*zf = NULL;
	}
}



void apc_free_zend_function(zend_function** zf TSRMLS_DC)
{
	if (*zf != NULL) {
		efree(*zf);
	}
	*zf = NULL;
}


void apc_serialize_zend_constant(zend_constant* zc TSRMLS_DC)
{
	apc_serialize_zval(&zc->value, NULL TSRMLS_CC);
	SERIALIZE_SCALAR(zc->flags, int);
	apc_serialize_string(ZS2S(zc->name) TSRMLS_CC);
	BCOMPILER_DEBUG(("serializing constant %s\n",zc->name));
	SERIALIZE_SCALAR(zc->name_len, uint);
	SERIALIZE_SCALAR(zc->module_number, int);
}

void apc_deserialize_zend_constant(zend_constant* zc TSRMLS_DC)
{
	apc_deserialize_zval(&zc->value, NULL TSRMLS_CC);
	DESERIALIZE_SCALAR(&zc->flags, int);
	apc_create_string(&ZS2S(zc->name) TSRMLS_CC);
	BCOMPILER_DEBUG(("deserializing constant %s\n",zc->name));
	DESERIALIZE_SCALAR(&zc->name_len, uint);
	DESERIALIZE_SCALAR(&zc->module_number, int);
}

void apc_create_zend_constant(zend_constant** zc TSRMLS_DC)
{
	*zc = (zend_constant*) emalloc(sizeof(zend_constant));
	apc_deserialize_zend_constant(*zc TSRMLS_CC);
}



/* The logic for serialize_class_table and deserialize_class_table
 * mirror that of the corresponding function_table functions (see
 * above), with classes in place of functions. */
 


/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
