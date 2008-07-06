/* This file is part of the XP runners
 *
 * $Id$
 */

#include <stdio.h>
#include <string.h>
#include "xprt.h"
#include <stdlib.h>

int main(int argc, char ** argv) {
    int i, eargc= 0;
    char **eargv;
    char *runner= "xp", *include= NULL;
    
    /* Parse arguments */
    for (i= 1; i < argc; i++) {
        if (0 == strncmp("-cp", argv[i], sizeof("-cp"))) {
            if (++i >= argc) {
                fprintf(stderr, "*** Argument '-cp' requires a value\n");
                return 1;
            }
            include= argv[i];
        } else if (0 == strncmp("-e", argv[i], sizeof("-e"))) {
            runner= "xpe";
        } else if (0 == strncmp("-v", argv[i], sizeof("-v"))) {
            runner= "xpv";
        } else if (0 == strncmp("-xar", argv[i], sizeof("-xar"))) {
            runner= "xar";
        } else if (strlen(argv[i]) && '-' == argv[i][0]) {
            fprintf(stderr, "*** Invalid argument %s\n", argv[i]);
            return 1;
        } else {
            eargc= argc- i;
            break;
        }
    }
    
    /* Pass rest of arguments */
    eargv= (char **)malloc(eargc * sizeof(char *));
    memcpy(eargv, argv+ i, eargc * sizeof(char *));
    
    /* Run executor */
    return execute(argv[0], runner, include, eargc, eargv);
}
