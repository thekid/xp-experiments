PHP_ARG_ENABLE(oel, whether to enable opcode engeneering library module support,
[ --enable-oel   Enable opcode engeneering library support])

if test "$PHP_OEL" = "yes"; then
  AC_DEFINE(HAVE_OEL, 1, [Whether you have opcode engeneering library])
  PHP_NEW_EXTENSION(oel, oel.c, $ext_shared)
fi
