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
    int eargc= argc+ 1;
    
    /* Pass arguments */
    eargv= (char **)malloc(eargc * sizeof(char *));
    eargv[0]= "util.cmd.Runner";
    eargv[1]= "net.xp_framework.xar.Xar";
    memcpy(eargv+ 2, argv+ 1, argc * sizeof(char *));
    
    /* Run executor */
    return execute(argv[0], "xp", NULL, eargc, eargv);
}
