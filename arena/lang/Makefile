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
	@echo "Usage: $(MAKE) grammar"
	@echo
	@echo "Generator: <$(GEN)>"

grammar:
	@echo "---> Generating grammar"
	@sh "$(GEN)" grammar/xp.jay php5 "" > xp/compiler/Parser.class.php
	@echo "===> Done, exit code $$?"
