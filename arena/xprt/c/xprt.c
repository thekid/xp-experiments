#include <stdio.h>
#include <string.h>
#include <limits.h>
#include <stdlib.h>
#include <libgen.h>
#include <unistd.h>
#include <sys/stat.h>
#include <stdio.h>

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
#define HOME_DIR getenv("HOME")
#else
#define PATH_TRANSLATED(s) (s)
#define ENV_PATH_SEPARATOR ":"
#define ARG_PATH_SEPARATOR ":"
#define DIR_SEPARATOR "/"
#define HOME_DIR getenv("HOME")
#endif

#define ADD_INCLUDE_XAR(inc, path, s) asprintf(                     \
  &inc,                                                             \
  "%s%s"DIR_SEPARATOR"lib"DIR_SEPARATOR"%s.xar"ARG_PATH_SEPARATOR,  \
  inc,                                                              \
  path,                                                             \
  s                                                                 \
);

static int add_path(char **include_path, char *dir, char *file) {
    char *uri= NULL;
    char path[PATH_MAX];
    FILE *f= NULL;

    /* Open URI */    
    asprintf(&uri, "%s"DIR_SEPARATOR"%s", dir, file);
    if (NULL == (f= fopen(uri, "rb"))) return -1;

    /* Read file line by line */
    while (NULL != fgets(path, PATH_MAX, f)) {
        int l= strlen(path);

        /* Trim trailing newline and whitespace characters */
        while (l-- && ('\n' == path[l] || '\r' == path[l] || ' ' == path[l] || '\t' == path[l]));
        path[l+ 1]= '\0';

        /* Ignore comments and empty lines */
        if (l < 0 || '#' == path[0]) continue;

        /* Qualify path */
        if ('~' == path[0]) {
            char *home= HOME_DIR;
            char *tmp= (char*) malloc(l+ strlen(home));
            
            strcpy(tmp, home);
            strncat(tmp, path+ 1, l);
            strcat(*include_path, PATH_TRANSLATED(tmp));
        } else {
            char *tmp= (char*) malloc(l+ strlen(dir)+ 1);
            
            strcpy(tmp, dir);
            strncat(tmp, DIR_SEPARATOR, sizeof(DIR_SEPARATOR));
            strncat(tmp, path, l+ 1);
            strcat(*include_path, PATH_TRANSLATED(tmp));
        }
        strncat(*include_path, ARG_PATH_SEPARATOR, sizeof(ARG_PATH_SEPARATOR));
    }
    fclose(f);

    return 0;
}

void execute(char *base, char *runner, char *include, int argc, char **argv) {
    char resolved[PATH_MAX];
    char *absolute= NULL, *include_path= "", *executor= NULL;
    char **args= NULL;

    /* Calculate full path */
    if (!realpath(base, resolved)) {
        fprintf(stderr, "*** Cannot resolve %s\n", base);
        return;
    }
    absolute= PATH_TRANSLATED(dirname(resolved));

    /* Boot classpath */
    include_path= strdup("");
    if (0 != add_path(&include_path, absolute, "boot.pth")) {
        fprintf(stderr, "*** Cannot find boot class path in %s", absolute);
        return;
    }

    /* User classpath */
    if (include) {
        asprintf(&include_path, "%s"ARG_PATH_SEPARATOR, include);
    }
    
    /* Always include the current directory */
    strncat(include_path, ".", sizeof("."));

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
    asprintf(&args[2], "%s"DIR_SEPARATOR"%s.php", strdup(absolute), runner);
    memcpy(args+ 3, argv, argc * sizeof(char *));
    args[argc+ 3]= NULL;
    
    /* Pass to env */
    putenv("XPVERSION="XPVERSION);
    
    /* Run (never returns in success case) */
    if (-1 == execv(executor, args)) {
        fprintf(stderr, "*** Could not execute %s %s %s [...]\n", args[0], args[1], args[2]);
    }
}
