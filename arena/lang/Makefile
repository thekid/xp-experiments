##
# Makefile
#
# $Id$

.PHONY: grammar

XP?=$(shell dirname "`which xp`")
USE_XP=$(shell grep ^use= "$(XP)/xp.ini" | cut -d= -f 2)
GEN=ports/technologies/opt/jay/generate.sh

all:
	@echo "Generate parser from grammar"
	@echo "============================"
	@echo "Usage: $(MAKE) grammar"
	@echo
	@echo "Will use <$(XP)/xp.ini> to determine jay executable location"

grammar:
	IFS=':' 
	@for i in "$(USE_XP)" ; do \
	  case "$$i" in \
	    ~*): path="$(HOME)/$${i#"~"}/$(GEN)" ;; \
        *) : path="$(XP)/$$i/$(GEN)" ;; \
	  esac ; \
	  if [ -f "$(XP)/$(USE_XP)/$(GEN)" ] ; then \
	    sh "$(XP)/$(USE_XP)/$(GEN)" grammar/xp.jay php5 "" > xp/compiler/Parser.class.php ; \
        exit 0 ; \
	  fi ; \
	done
