/* This file is part of the XP runners
 *
 * $Id$
 */

#include <string.h>
#include "hash.h"

/**
 * Initialize a hash
 * 
 * @access  public
 * @param   HASH **hash
 * @param   int initial
 * @param   int grow
 * @return  int
 */
HASH_API int hash_init(HASH **hash, int initial, int grow) {   
    *hash= (HASH *) malloc(sizeof(HASH));
    if (!*hash) {
        return SA_FAILURE | SA_EALLOC;
    }
    (*hash)->count= 0;
    (*hash)->grow= grow;
    
    /* Allocate initial amount */
    (*hash)->elements= (HASH_ELEMENT *) malloc(sizeof(HASH_ELEMENT) * initial);
    (*hash)->allocated= initial;
    
    return SA_SUCCESS;
}

/**
 * Check hashmap allocation and grow by the defined number of blocks
 * if necessary
 * 
 * @access  private
 * @param   HASH **hash
 * @return  int
 */
static int _check_allocation(HASH **hash) {
    if ((*hash)->count >= (*hash)->allocated) {
        (*hash)->elements= (HASH_ELEMENT *) realloc(
            (*hash)->elements, 
            sizeof(HASH_ELEMENT) * ((*hash)->allocated + (*hash)->grow)
        );
        if (!(*hash)->elements) {
            return SA_FAILURE | SA_EALLOC;
        }
        (*hash)->allocated+= (*hash)->grow;
    }
    return SA_SUCCESS;
}

/**
 * Add a string to the hash
 * 
 * @access  public
 * @param   HASH **hash
 * @param   int key
 * @param   char *value
 * @return  int
 */
HASH_API int hash_addstring(HASH *hash, char* key, char *value) {   
    int retcode;

    if ((retcode= _check_allocation(&hash)) == SA_SUCCESS) {
        hash->elements[hash->count].key= strdup(key);
        hash->elements[hash->count].type= HASH_STRING;
        hash->elements[hash->count].value.str.val= (char *) strdup(value);
        hash->elements[hash->count].value.str.len= strlen(value);
        hash->count++;
    }
    return retcode;
}

/**
 * Get a string from the hash
 * 
 * @access  public
 * @param   HASH **hash
 * @param   char *key
 * @param   char *def default
 * @return  char *
 */
HASH_API char* hash_getstring(HASH *hash, char* key, char* def) {   
    int i;

    for (i= 0; i < hash->count; i++) {
        if (
          (HASH_STRING != hash->elements[i].type) || 
          (0 != strcmp(key, hash->elements[i].key))
        ) continue;
        
        return hash->elements[i].value.str.val;
    }
    return def;
}

/**
 * Add an integer to the hash
 * 
 * @access  public
 * @param   HASH **hash
 * @param   int key
 * @param   int value
 * @return  int
 */
HASH_API int hash_addint(HASH *hash, char* key, int value) {
    int retcode;

    if ((retcode= _check_allocation(&hash)) == SA_SUCCESS) {
        hash->elements[hash->count].key= strdup(key);
        hash->elements[hash->count].type= HASH_INT;
        hash->elements[hash->count].value.lval= value;
        hash->count++;
    }
    return retcode;
}

/**
 * Get an int from the hash
 * 
 * @access  public
 * @param   HASH **hash
 * @param   char *key
 * @param   int def default
 * @return  int
 */
HASH_API int hash_getint(HASH *hash, char* key, int def) {   
    int i;

    for (i= 0; i < hash->count; i++) {
        if (
          (HASH_INT != hash->elements[i].type) || 
          (0 != strcmp(key, hash->elements[i].key))
        ) continue;
        
        return hash->elements[i].value.lval;
    }
    return def;
}

/**
 * Free a hashmap element
 * 
 * @access  private
 * @param   HASH_ELEMENT **e
 */
static void hash_free_element(HASH_ELEMENT *e, int freevalue) {
    if (freevalue) {
        switch (e->type) {
            case HASH_STRING:
                free(e->value.str.val);
                break;
        }
    }
    free(e->key);
}

/**
 * Remove a key from the hash
 * 
 * @access  public
 * @param   HASH **hash
 * @param   char *key
 */
HASH_API int hash_remove(HASH *hash, char* key, int dofree) {   
    int i;

    for (i= 0; i < hash->count; i++) {
        if (0 != strcmp(key, hash->elements[i].key)) continue;

        hash_free_element(&hash->elements[i], dofree);
        
        /* Renumber */
        while (i < hash->count) {
            hash->elements[i]= hash->elements[i+ 1];
            i++;
        }
        hash->count--;
        return 1;
    }
    
    return 0;
}

/**
 * Free a hash
 * 
 * @access  public
 * @param   HASH *hash
 * @return  int
 */
HASH_API int hash_free(HASH *hash) {
    int i;

    if (!hash) {
        return SA_FAILURE | SA_EALREADYFREE;
    }
    
    for (i= 0; i < hash->count; i++) {
        hash_free_element(&hash->elements[i], 1);
    }
    free(hash->elements);
    free(hash);
    return SA_SUCCESS;
}

/**
 * Iterative functions: retrieve first element
 * 
 * Usage example:
 * <code>
 *   int c;
 *   HASH_ELEMENT *e;
 *   for (e= hash_first(hash, &c); 
 *           hash_has_more(hash, c); e= hash_next(hash, &c)) {
 *       ...
 *   }
 * </code>
 *
 * @access  public
 * @param   HASH *hash
 * @param   int *c
 * @return  hash_element *
 */
HASH_API HASH_ELEMENT *hash_first(HASH *hash, int *c) {
    (*c)= 0;
    if (hash->count == 0) {
        return NULL;
    }
    return &hash->elements[0];
}

/**
 * Iterative functions: check whether there are more elements
 * 
 * @access  public
 * @param   HASH *hash
 * @param   int c
 * @return  int
 */
HASH_API int hash_has_more(HASH *hash, int c) {
    return c < hash->count;
}

/**
 * Iterative functions: retrieve next element
 * 
 * @access  public
 * @param   HASH *hash
 * @param   int *c
 * @return  hash_element *
 */
HASH_API HASH_ELEMENT *hash_next(HASH *hash, int *c) {
    (*c)++;
    if (*c > hash->count) {
        return NULL;
    }
    return &hash->elements[*c];
}

/**
 * Iterative functions: how many elements
 * 
 * @access  public
 * @param   HASH *hash
 * @return  int
 */
HASH_API int hash_num_elements(HASH *hash) {
    return hash->count;
}

/**
 * Apply a function to the hash
 * 
 * @access  public
 * @param   HASH *hash
 * @param   hash_apply_func_t func
 * @return  int
 */
HASH_API int hash_apply(HASH *hash, hash_apply_func_t func) {
    int i;
    
    for (i= 0; i < hash->count; i++) {
        func(&hash->elements[i]);
    }
    return SA_SUCCESS;
}

/**
 * Hash print apply function
 * 
 * @access  public
 * @param   HASH_ELEMENT *e
 */
HASH_API void hash_dump(HASH_ELEMENT *e) {
    switch (e->type) {
        case HASH_STRING:
            printf("%s= (%d)'%s'\n", e->key, e->value.str.len, e->value.str.val);
            break;
        case HASH_INT:
            printf("%s= %d\n", e->key, e->value.lval);
            break;
        default:
            printf("%s= (unknown)%p\n", e->key, e->value);
    }
}
