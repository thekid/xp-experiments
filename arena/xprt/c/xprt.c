/* This file is part of the XP runners
 *
 * $Id$
 */

#include <stdio.h>
#include <string.h>
#include <limits.h>
#include <stdlib.h>
#include <hash.h>

#ifdef _WIN32
#include <windows.h>
#define EXE_EXT ".exe"
#define PATH_MAX _MAX_PATH
#define DIR_SEPARATOR "\\"
#define ARG_PATH_SEPARATOR ";"
#define ENV_PATH_SEPARATOR ";"
#define DIR_SEPARATOR "\\"
#define HOME_DIR getenv("USERPROFILE")
#define PATH_TRANSLATED(s) strdup(s)

/* C:\Users\name || \\filesrv\homes */
#define IS_ABSOLUTE(p, l) (                   \
    (l > 2 && ':' == p[1] && '\\' == p[2]) || \
    (l > 2 && '\\' == p[1] && '\\' == p[2])   \
)

struct dirent {
	char d_name[_MAX_FNAME+ 1];
};

typedef struct {
	HANDLE handle;
	WIN32_FIND_DATA fileinfo;
	struct dirent entry;
} DIR;

static DIR *opendir(const char *path) {
    char *spec;
    DIR *dir;

    spec= (char*) malloc(strlen(path)+ sizeof(DIR_SEPARATOR)+ 1 + 1);
    strcpy(spec, path);
    strcat(spec, DIR_SEPARATOR"*");

    dir= (DIR*) malloc(sizeof(DIR));
    dir->handle= FindFirstFile(spec, &(dir->fileinfo));
    free(spec);
    if (INVALID_HANDLE_VALUE == dir->handle) {
        free(dir);
        return NULL;
    }
    return dir;
}

static struct dirent *readdir(DIR *dir) {
    if (0 == FindNextFile(dir->handle, &(dir->fileinfo))) {
        return NULL;
    }
   
    strcpy(dir->entry.d_name, dir->fileinfo.cFileName);
    return &(dir->entry);
}

static int closedir(DIR *dir) {
    FindClose(dir->handle);
    free(dir);
    return 0;
}

static char *dirname(const char* path) {
    char* out;
    int len= strlen(path);

    /* Search until we find a backslash */
    while ('\\' != path[len]) { len--; }
    
    out = (char*) malloc(len+ 1);
    memcpy(out, path, len);
    out[len]= '\0';

    return out;
}

static char *realpath(const char* in, char* resolved) {
    int r;
    
    r= GetFullPathName(in, PATH_MAX, resolved, NULL);
    if (r <= 0 || r > PATH_MAX) {
        return NULL;
    }
    return resolved;
}

int asprintf(char **str, const char *fmt, ...) {
    char *result;
    int r, len;
    va_list list;

    va_start(list, fmt);

    /* Start with an intial size of 255 bytes */
    len= 0xFF;
    result= (char*) malloc(len);
    do {

        /* The *snprintf functions return the number of characters written 
         * if the number of characters to write is less than or equal to count; 
         * if the number of characters to write is greater than count, these 
         * functions return -1 indicating that output has been truncated. 
         * The return value does not include the terminating null, if one is written.
         */
        r= vsnprintf(result, len, fmt, list);
        if (r >= 0 && r < len) {
            *str= result;
            r= 0;
        } else {
        
            /* Increase length by 255 bytes, retry */
            len+= 0xFF;
            result= (char*) realloc(result, len);
            r= -1;
        }
    } while (r != 0);

    va_end(list);
    return r+ 1;
}

static int spawn(char *executable, char** args, int argc) {
    STARTUPINFO si;
    PROCESS_INFORMATION pi;
    DWORD exitcode;
    char* arguments, *p= NULL;
    int i, q;

    memset(&si, 0, sizeof(STARTUPINFO));
    si.cb= sizeof(STARTUPINFO);

    /* Quote arguments */
    arguments= (char*) malloc(1);
    arguments[0]= '\0';
    for (i= 0; i < argc; i++) {
        if (NULL == args[i]) continue;
        
        /* Don't count the quote characters first, instead just go for the worst case */
        arguments= (char*) realloc(arguments, strlen(arguments) + (strlen(args[i]) * 2) + sizeof(" \"\""));
        strcat(arguments, "\"");
        
        q= '"' != args[i][strlen(args[i])- 1];
        p= strtok(args[i], "\"");
        while (p != NULL) {
            strcat(arguments, p);
            strcat(arguments, "\\\"");
            p= strtok(NULL, "\"");
        }
        if (q) {
            arguments[strlen(arguments)- 2]= '\0';
        }
        strcat(arguments, "\" ");
    }

    if (!CreateProcess(executable, (LPSTR)arguments, NULL, NULL, TRUE, 0, NULL, NULL, &si, &pi)) {
        return 127;
    }
    
    if (WAIT_OBJECT_0 != WaitForSingleObject(pi.hProcess, INFINITE)) {
        CloseHandle(pi.hProcess);
        return 255;
    }
    
    GetExitCodeProcess(pi.hProcess, &exitcode);
    CloseHandle(pi.hProcess);
    return exitcode;
}
#else
#include <libgen.h>
#include <unistd.h>
#include <dirent.h>
#include <sys/wait.h>

static int spawn(char *executable, char** args, int argc) {
    pid_t pid;

    pid= fork();
    if (-1 == pid) {
        return -1;
    } else if (0 == pid) {
        execv(executable, args);
        exit(127);
    } else {
        int exitcode;
        waitpid(pid, &exitcode, 0);
        return exitcode;
    }
}
#endif

#include <sys/stat.h>
#include <stdio.h>

#ifdef __CYGWIN__
#include <sys/cygwin.h>
#define EXE_EXT ""
#define PATH_TRANSLATED(s) cygpath(s)
#define ARG_PATH_SEPARATOR ";"
#define ENV_PATH_SEPARATOR ":"
#define DIR_SEPARATOR "\\"
#define HOME_DIR getenv("HOME")

/* /home || C:/cygwin/home or C:\cygwin\home || //filesrv/homes/ || \\filesrv\homes */
#define IS_ABSOLUTE(p, l) (                                                     \
    ('/' == p[0]) ||                                                            \
    (l > 2 && ':' == p[1] && ('/' == p[2] || '\\' == p[2])) ||                  \
    (l > 2 && (('/' == p[1] && '/' == p[2]) || ('\\' == p[1] && '\\' == p[2]))) \
)

static char *cygpath(char *in) {
    char resolved[PATH_MAX];
    cygwin_conv_to_win32_path(in, resolved);
    return strdup(resolved);
}

#else 
#ifndef _WIN32
#define EXE_EXT ""
#define PATH_TRANSLATED(s) strdup(s)
#define ENV_PATH_SEPARATOR ":"
#define ARG_PATH_SEPARATOR ":"
#define DIR_SEPARATOR "/"
#define HOME_DIR getenv("HOME")
#define IS_ABSOLUTE(p, l) ('/' == path[0])
#endif
#endif

static char* rtrim(char *v) {
    register int l;

    l= strlen(v);
    while (l-- && ('\0' == v[l] || '\n' == v[l] || '\r' == v[l] || ' ' == v[l] || '\t' == v[l]));
    v[++l]= '\0';
    return v;
}

static int read_config_file(HASH **config, const char *file) {
    FILE *f= NULL;
    char line[1024], key[1024], value[1024];

    if (NULL == (f= fopen(file, "rb"))) return -1;
    while (NULL != fgets(line, 1024, f)) {
        if (';' == line[0]) continue;
        if (2 != sscanf(line, "%[^=]=%[^\n]", key, value)) continue;

        hash_addstring(*config, rtrim(key), value);
    }
    fclose(f);
    return 0;
}

static int add_path_file(char **include_path, const char *dir, const char *file) {
    char *uri= NULL, *home= NULL, *tmp;
    char path[PATH_MAX];
    FILE *f= NULL;
    int added= 0;

    /* Open URI */    
    asprintf(&uri, "%s"DIR_SEPARATOR"%s", dir, file);
    if (NULL == (f= fopen(uri, "rb"))) return -1;

    home= HOME_DIR;

    /* Read file line by line */
    while (NULL != fgets(path, PATH_MAX, f)) {
        int l= strlen(path);

        /* Trim trailing newline and whitespace characters */
        while (l-- && ('\0' == path[l] || '\n' == path[l] || '\r' == path[l] || ' ' == path[l] || '\t' == path[l]));

        /* Ignore comments and empty lines */
        if (l <= 0 || '#' == path[0]) continue;
       
        /* Get PATH_MAX * 2 bytes of memory, this should suffice for PATH_TRANSLATED(...) + ":" */
        *include_path= (char*) realloc(*include_path, strlen(*include_path)+ PATH_MAX * 2);

        /* Qualify path */
        l++;
        path[l]= '\0';
        if ('~' == path[0]) {
            tmp= (char*) malloc(l+ strlen(home));
            strcpy(tmp, home);
            strcat(tmp, path+ 1);
            strcat(*include_path, PATH_TRANSLATED(tmp));
            free(tmp);
        } else if (IS_ABSOLUTE(path, l)) {
            strcat(*include_path, PATH_TRANSLATED(path));
        } else {
            tmp= (char*) malloc(strlen(dir)+ sizeof(DIR_SEPARATOR) + l);
            strcpy(tmp, dir);
            strcat(tmp, DIR_SEPARATOR);
            strcat(tmp, path);
            strcat(*include_path, PATH_TRANSLATED(tmp));
            free(tmp);
        }

        strcat(*include_path, ARG_PATH_SEPARATOR);
        added++;
    }
    fclose(f);

    return added;
}

static int scan_path_files(char **include_path, const char* dir) {
    DIR *d= NULL;
    struct dirent *e= NULL;
    int added= 0;

    /* Open directory */
    if (NULL == (d= opendir(dir))) return -1;
    
    /* Scan for .pth files */
    while (NULL != (e= readdir(d))) {
        int len= strlen(e->d_name);

        if (len > 4 && (
          '.' == e->d_name[len- 4] &&
          'p' == e->d_name[len- 3] &&
          't' == e->d_name[len- 2] &&
          'h' == e->d_name[len- 1]
        )) {
            added+= add_path_file(include_path, dir, e->d_name);
        }
    }
    closedir(d);

    return added;
}

int execute(char *base, char *runner, char *include, int argc, char **argv) {
    char resolved[PATH_MAX];
    char *absolute= NULL, *include_path= NULL, *executor= NULL;
    char **args= NULL;
    int exitcode;
    HASH *config;

    hash_init(&config, 1, 4);
    hash_addint(config, "magic_quotes_gpc", 0);

    /* Calculate full path */
#ifdef _WIN32
    if (!GetModuleFileName(0, resolved, PATH_MAX)) {
        fprintf(stderr, "*** Cannot resolve %s\n", base);
        return 127;
    }
#else
    if (!realpath(base, resolved)) {
        fprintf(stderr, "*** Cannot resolve %s\n", base);
        return 127;
    }
#endif

    absolute= PATH_TRANSLATED(dirname(resolved));

    /* Boot classpath */
    include_path= (char*) malloc(1);
    include_path[0]= '\0';
    {
        int scanned= scan_path_files(&include_path, absolute);
        
        if (-1 == scanned) {
            fprintf(stderr, "*** Error loading boot class path in %s", absolute);
            return 127;
        } else if (0 == scanned) {
            fprintf(stderr, "*** Cannot find boot class path in %s", absolute);
            return 127;
        }            
    }

    /* Concatenate user classpath */
    if (include) {
        include_path= (char*) realloc(include_path, strlen(include_path)+ strlen(include)+ sizeof(ARG_PATH_SEPARATOR));
        strcat(include_path, include);
        strcat(include_path, ARG_PATH_SEPARATOR);
    }
    
    /* Look for .pth files in current directory, if we cannot find any, use it */
    if (!realpath(".", resolved) || scan_path_files(&include_path, resolved) <= 0) {
        include_path= (char*) realloc(include_path, strlen(include_path)+ sizeof("."));
        strcat(include_path, ".");
    }
    
    /* Check for executor config */
    {
        struct stat st;
        char *ini;
        
        ini= (char*) malloc(strlen(absolute) + sizeof(DIR_SEPARATOR) + sizeof("php.ini"));
        strcpy(ini, absolute);
        strcat(ini, DIR_SEPARATOR);
        strcat(ini, "php.ini");

        memset(&st, 0, sizeof(struct stat));
        if (0 == stat(ini, &st)) {
            if (-1 == read_config_file(&config, ini)) {
                fprintf(stderr, "*** Error loading config file %s", ini);
                return 127;
            }
        }

        free(ini);
    }
    
    executor= hash_getstring(config, "executor", NULL);

    /* Calculate executor's filename if not configured */
    if (NULL == executor) {
        int found= 0;
        char *path_env= strdup(getenv("PATH")), *p= NULL;
        struct stat st;

        p= strtok(path_env, ENV_PATH_SEPARATOR);
        while (p != NULL) {
            asprintf(&executor, "%s"DIR_SEPARATOR"php"EXE_EXT, p);
            memset(&st, 0, sizeof(struct stat));
            if (0 == stat(executor, &st)) {
                found= 1;
                break;
            }
            p= strtok(NULL, ENV_PATH_SEPARATOR);
            free(executor);
            executor= NULL;
        }
        free(path_env);
        
        if (!found) {
            fprintf(stderr, "*** Cannot find php executable in PATH\n");
            return 127;
        }
    } else {
        struct stat st;

        memset(&st, 0, sizeof(struct stat));
        if (0 != stat(executor, &st)) {
            fprintf(stderr, "*** Cannot find configured php executable %s\n", executor);
            return 127;
        }
        hash_remove(config, "executor", 0);
    }

    /* Build argument list */
    {
        int c, pos;
        HASH_ELEMENT *e;

        args= (char **) malloc((argc + 3 + hash_num_elements(config)) * sizeof(char *));
        args[0]= executor;
        asprintf(&args[1], "-dinclude_path=\"%s\"", include_path);

        pos= 2;
        for (e= hash_first(config, &c); hash_has_more(config, c); e= hash_next(config, &c)) {
            switch (e->type) {
                case HASH_STRING: 
                    asprintf(&args[pos], "-d%s=\"%s\"", e->key, e->value.str.val);
                    pos++;
                    break;
                case HASH_INT: 
                    asprintf(&args[pos], "-d%s=%d", e->key, e->value.lval);
                    pos++;
                    break;
            }
        }

        asprintf(&args[pos], "%s"DIR_SEPARATOR"%s.php", absolute, runner);
        memcpy(args+ pos + 1, argv, argc * sizeof(char *));
        argc= argc + pos + 2;
        args[argc- 1]= NULL;
    }
   
    /* Run */
    exitcode= spawn(executor, args, argc);
    if (-1 == exitcode) {
        fprintf(stderr, "*** Could not execute %s %s %s [...]\n", args[0], args[1], args[2]);
        exitcode= 255;
    }
    
    free(executor);
    hash_free(config);
    return exitcode;
}
