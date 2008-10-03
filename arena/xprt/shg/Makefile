##
# Makefile
#
# $Id$

all: xp xar xpcli unittest doclet cgen

clean: 
	-rm xp xar xpcli unittest doclet cgen

%: %.in common.in macros.h
	(echo "#!/bin/sh" ; $(CC) -E -I. -x c -C -P -imacros macros.h $< ) > $@
