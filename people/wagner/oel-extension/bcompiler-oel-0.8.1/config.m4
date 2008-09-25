dnl
dnl $Id: config.m4,v 1.2 2003/04/05 02:00:37 alan_k Exp $
dnl

PHP_ARG_ENABLE(bcompiler, whether to enable bcompiler support,
[  --enable-bcompiler[=DIR]      Enable bcompiler support (dir is the bzip2 directory)])


if test "$PHP_BCOMPILER" != "no"; then
  if test -r $PHP_BCOMPILER/include/bzlib.h; then
    BCOMPILER_DIR=$PHP_BCOMPILER
  else
    AC_MSG_CHECKING(for BZip2 in default path)
    for i in /usr/local /usr; do
      if test -r $i/include/bzlib.h; then
        BCOMPILER_DIR=$i
        AC_MSG_RESULT(found in $i)
      fi
    done
  fi
 
  if test -z "$BCOMPILER_DIR"; then
    AC_MSG_RESULT(not found)
    AC_MSG_ERROR(Please reinstall the BZip2 distribution)
  fi
 
  PHP_ADD_INCLUDE($BCOMPILER_DIR/include)
 
  PHP_SUBST(BCOMPILER_SHARED_LIBADD)
  PHP_ADD_LIBRARY_WITH_PATH(bz2, $BCOMPILER_DIR/lib, BCOMPILER_SHARED_LIBADD)
  AC_CHECK_LIB(bz2, BZ2_bzerror, [AC_DEFINE(HAVE_BZ2,1,[ ])], [AC_MSG_ERROR(bz2 module requires libbz2 >= 1.0.0)],)
  AC_DEFINE(HAVE_BCOMPILER,1,[Whether you want bcompiler support])

  PHP_NEW_EXTENSION(bcompiler, bcompiler.c, $ext_shared)
fi
