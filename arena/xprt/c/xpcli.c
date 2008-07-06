/* This file is part of the XP runners
 *
 * $Id$
 */

#include <stdio.h>
#include <string.h>
#include "xprt.h"
#include <stdlib.h>

int main(int argc, char ** argv) {
    char **eargv;
    
    /* Pass arguments */
    eargv= (char **)malloc(argc * sizeof(char *));
    eargv[0]= "util.cmd.Runner";
    memcpy(eargv+ 1, argv+ 1, argc * sizeof(char *));
    
    /* Run executor */
    return execute(argv[0], "xp", NULL, argc, eargv);
}
