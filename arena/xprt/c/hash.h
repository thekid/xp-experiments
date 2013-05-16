/* This file is part of the XP runners
 *
 * $Id$
 */

#ifndef _HASH_H
#define _HASH_H

#define SA_SUCCESS      0
#define SA_FAILURE      1
#define SA_EALLOC       2
#define SA_EALREADYFREE 4
#define SA_ENULLPOINTER 8

#define HASH_STRING 1
#define HASH_INT    2

#define HASH_API

typedef struct {
    char* key;
    int type;
    union {
        struct {
            char* val;
            int len;
        } str;
        int lval;
    } value;
} HASH_ELEMENT;

typedef struct {
    int count;
    int grow;
    int allocated;
    HASH_ELEMENT *elements;
} HASH;

typedef void (*hash_apply_func_t)(HASH_ELEMENT *e);

HASH_API int hash_init(HASH **hash, int initial, int grow);

HASH_API int hash_addstring(HASH *hash, char* key, char *value);
HASH_API int hash_addint(HASH *hash, char* key, int value);

HASH_API char* hash_getstring(HASH *hash, char* key, char* def);
HASH_API int hash_getint(HASH *hash, char* key, int def);

HASH_API int hash_remove(HASH *hash, char* key, int dofree);  

HASH_API int hash_free(HASH *hash);

HASH_API HASH_ELEMENT *hash_first(HASH *h, int *c);
HASH_API int hash_has_more(HASH *h, int c);
HASH_API HASH_ELEMENT *hash_next(HASH *h, int *c);

HASH_API int hash_num_elements(HASH *h);

HASH_API int hash_apply(HASH *hash, hash_apply_func_t func);
HASH_API void hash_dump(HASH_ELEMENT *e);
#endif
