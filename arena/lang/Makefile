##
# Makefile
#
# $Id$

.PHONY: grammar

XP?=$(shell dirname "`which xp`")
USE_XP=$(shell grep ^use= "$(XP)/xp.ini" | cut -d'=' -f 2 | cut -d';' -f 1 | cut -d':' -f 1)
GEN?=$(XP)/$(USE_XP)/ports/technologies/opt/jay/generate.sh

all:
	@echo "Generate parser from grammar"
	@echo "============================"
	@echo "Usage:"
	@echo "- $(MAKE) grammar.*"
	@echo "- $(MAKE) grammar.[NAME]"
	@echo "- $(MAKE) test [FLAGS=-v]"
	@echo
	@echo "Generator:"
	@echo "<$(GEN)>"

grammar.%:
	@echo "===> Generating grammar"
	@for i in `ls grammar/$*.jay` ; do \
	  TYPE=`basename $$i .jay` ; \
	  echo "---> $$TYPE:" ; \
	  echo -n "     >> " ; sh "$(GEN)" $$i php5 "" "xp.compiler.syntax.$$TYPE" > src/xp/compiler/syntax/$$TYPE/Parser.class.php ; \
	  echo "     >> Exit code $$?" ; \
    done
	@echo "===> Done"

test:
	@echo "---> Running tests"
	unittest net.xp_lang.tests.** $(FLAGS)
	@echo "===> Done, exit code $$?"

namemap:
	xp cmd.convert.NameMap | sort | uniq > cmd/convert/name.map
