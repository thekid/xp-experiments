#include <stdio.h>
#include <string.h>
#include <limits.h>
#include <stdlib.h>
#include <libgen.h>
#include <unistd.h>
#include <sys/stat.h>

#ifdef __CYGWIN__
#include <sys/cygwin.h>
static char *cygpath(char *in) {
    char resolved[PATH_MAX];
    cygwin_conv_to_win32_path(in, resolved);
    return strdup(resolved);
}
#define PATH_TRANSLATED(s) cygpath(s)
#define ARG_PATH_SEPARATOR ";"
#define ENV_PATH_SEPARATOR ":"
#define DIR_SEPARATOR "\\"
#else
#define PATH_TRANSLATED(s) (s)
#define ENV_PATH_SEPARATOR ":"
#define ARG_PATH_SEPARATOR ":"
#define DIR_SEPARATOR "/"
#endif

void execute(char *base, char *runner, char *include, int argc, char **argv) {
    char resolved[PATH_MAX];
    char *absolute= NULL, *include_path= "", *executor= NULL;
    char **args= NULL;

    /* Calculate full path */
    if (!realpath(base, resolved)) {
        fprintf(stderr, "*** Cannot resolve %s\n", base);
        return;
    }
    absolute= dirname(dirname(resolved));

    /* Build include_path line */
    if (include) {
        asprintf(&include_path, "%s"ARG_PATH_SEPARATOR, include);
    }
    asprintf(
        &include_path, 
        "%s%s%s%s"DIR_SEPARATOR"lib"DIR_SEPARATOR"xp-rt-"XPVERSION".xar%s%s"DIR_SEPARATOR"lib"DIR_SEPARATOR"xp-net.xp_framework-"XPVERSION".xar%s.", 
        include_path, 
        PATH_TRANSLATED(absolute), 
        ARG_PATH_SEPARATOR, 
        PATH_TRANSLATED(absolute), 
        ARG_PATH_SEPARATOR, 
        PATH_TRANSLATED(absolute), 
        ARG_PATH_SEPARATOR
    );

    /* Calculate executor's filename */
    {
        int found= 0;
        char *path_env= strdup(getenv("PATH")), *p= NULL;
        struct stat st;

        p= strtok(path_env, ENV_PATH_SEPARATOR);
        while (p != NULL) {
            asprintf(&executor, "%s"DIR_SEPARATOR"php", p);
            if (0 == stat(executor, &st)) {
                found= 1;
                break;
            }
            p= strtok(NULL, ENV_PATH_SEPARATOR);
        }
        free(path_env);
        
        if (!found) {
            fprintf(stderr, "*** Cannot find php executable in PATH\n");
            return;
        }
    }

    /* Build argument list */
    args= (char **)malloc((argc + 3) * sizeof(char *));
    args[0]= executor;
    asprintf(&args[1], "-dinclude_path=\"%s\"", include_path);
    asprintf(&args[2], "%s"DIR_SEPARATOR"bin"DIR_SEPARATOR"%s.php", PATH_TRANSLATED(absolute), runner);
    memcpy(args+ 3, argv, argc * sizeof(char *));
    args[argc+ 3]= NULL;
    
    /* Pass to env */
    putenv("XPVERSION="XPVERSION);
    
    /* Run (never returns in success case) */
    if (-1 == execv(executor, args)) {
        fprintf(stderr, "*** Could not execute %s\n", executor);
    }
}
