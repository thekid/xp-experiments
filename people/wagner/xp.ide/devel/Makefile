XP_PUBLIC_PATH=$(shell xp -e "uses('util.cmd.Console'); Console::\$$out->write(dirname(ClassLoader::getDefault()->findPackage('lang')->path));")
JAY_BIN=$(shell if [ 0 -lt `env | grep OS | grep -i WINDOWS | wc -l` ]; then echo -n "phpJay.exe"; else echo -n "phpJay"; fi)

all:
	@echo "Usage:"
	@echo "  ${MAKE} parser"
	@echo "  ${MAKE} release"

help: all

.PHONY: parser parser.% release release.%

parser: parser.ClassFile parser.Class

parser.%:
	@echo "  * create /src/xp/ide/source/parser/$*Parser.class.php";
	@$(XP_PUBLIC_PATH)/ports/technologies/opt/jay/$(JAY_BIN) -cv < "./grammar/php.skl" ./grammar/$*.jay \
	| sed -e 's/{%NAME%}/'$*Parser'/g' \
	> ./src/xp/ide/source/parser/$*Parser.class.php
	@rm ./y.output

release:
	@echo "Usage:"
	@echo "  ${MAKE} release.<version>"

release.%:
	@if [ ! -e ../$* ] ; then \
		mkdir -vp ../$*/gedit ../$*/gedit/xpide ../$*/gedit/xpide/dialog ../$*/nedit ../$*/bin ../$*/lib; \
		cp -v gedit/xpide.gedit-plugin ../$*/gedit/; \
		cp -v gedit/xpide/*.* ../$*/gedit/xpide; \
		cp -v gedit/xpide/dialog/* ../$*/gedit/xpide/dialog/; \
		cp -v nedit/* ../$*/nedit/; \
		cp -v bin/* ../$*/bin/; \
		cd ./src; echo "create ../$*/lib/xp-ide.xar" ; xar cf ../../$*/lib/xp-ide.xar *; cd ..; \
		cd ..; rm stable; ln -vs $* stable; cd ./devel; \
	else \
		echo "$* does already exist"; \
	fi

