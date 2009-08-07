XP_PUBLIC_PATH=$(shell xp -e "uses('util.cmd.Console'); Console::\$$out->write(dirname(ClassLoader::getDefault()->findPackage('lang')->path));")

all:
	@echo "Usage:"
	@echo "  ${MAKE} parser"
	@echo "  ${MAKE} release"

help: all

.PHONY: parser release release.% clean

parser: ./src/xp/ide/source/parser/Php52Parser.class.php

clean:
	@rm ./src/xp/ide/source/parser/Php52Parser.class.php

./src/xp/ide/source/parser/Php52Parser.class.php:
	@sh $(XP_PUBLIC_PATH)/ports/technologies/opt/jay/generate.sh ./grammar/php52.jay php5 'xp·ide·source·parser·Php52' > ./src/xp/ide/source/parser/Php52Parser.class.php
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

