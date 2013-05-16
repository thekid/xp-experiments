
.phony: lib.rt lib.tools lib.net.xp_framework libs all

XP_BASE?=../../../../../xp.public/trunk
CONVERT_CMD=xpcli convert/ToXp6.class.php
ARGS?=

lib.rt:
	${CONVERT_CMD} -o ${XP_BASE}/skeleton -b ${XP_BASE}/skeleton -t lib/xp-rt-6.0.0alpha.xar ${ARGS}
    
lib.tools:
	${CONVERT_CMD} -o ${XP_BASE}/tools -b ${XP_BASE}/tools -t lib/xp-tools-6.0.0alpha.xar ${ARGS}

lib.net.xp_framework:
	${CONVERT_CMD} -o ${XP_BASE}/ports/classes/net/xp_framework -b ${XP_BASE}/ports/classes -t lib/xp-net.xp_framework-6.0.0alpha.xar ${ARGS}

test.core:
	USE_XP=six unittest core.ini

test.separate:
	-for i in `ls -1 ${XP_BASE}/ports/unittest/*.ini | grep -v core` ; do echo -n "$$i: " ; USE_XP=six unittest $$i ; done

test.all:
	ls -1 ${XP_BASE}/ports/unittest/*.ini | grep -v core | USE_XP=six xargs unittest

test: test.core test.separate    
libs: lib.rt lib.tools lib.net.xp_framework
all: libs test
