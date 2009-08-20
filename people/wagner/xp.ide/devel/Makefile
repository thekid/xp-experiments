JAY=$(shell \
  xp -e "uses('util.cmd.Console'); Console::\$$out->write(dirname(ClassLoader::getDefault()->findPackage('lang')->path));"; \
  echo -n "/ports/technologies/opt/jay/"; \
  if [ 0 -lt `env | grep OS | grep -i WINDOWS | wc -l` ]; then \
    echo -n "phpJay.exe"; \
  else \
    echo -n "phpJay"; \
  fi; \
)

JLEX=$(shell \
  echo "java -cp ../../JLexPhp/JLexPHP.jar JLexPHP.Main"; \
)

all:
	@echo "Usage:"
	@echo "  ${MAKE} parser"
	@echo "  ${MAKE} lexer"
	@echo "  ${MAKE} release"

help: all

.PHONY: parser parser.% lexer lexer.% release release.% help

parser: \
  /src/xp/ide/source/parser/ClassFileParser.class.php\
  /src/xp/ide/source/parser/ClassParser.class.php

/src/xp/ide/source/parser/ClassFileParser.class.php: ./grammar/ClassFile.jay parser.ClassFile
/src/xp/ide/source/parser/ClassParser.class.php: ./grammar/Class.jay parser.Class

lexer: \
  /src/xp/ide/source/parser/ClassLexer.class.php

/src/xp/ide/source/parser/ClassLexer.class.php: ./grammar/Class.lex lexer.Class

lexer.%:
	@echo "  * create /src/xp/ide/source/parser/$*Lexer.class.php";
	@iconv -f ISO-8859-15 -t UTF-8 ./grammar/$*.lex > ./grammar/$*.lex.enc
	@$(JLEX) ./grammar/$*.lex.enc
	@rm ./grammar/$*.lex.enc
	@cat ./grammar/$*.lex.enc.php \
	| iconv -t ISO-8859-15 -f UTF-8 \
	| sed -e 's/{%CLASSNAME%}/'xp·ide·source·parser·$*Lexer'/g' \
	| sed -e 's/{%PARENTNAME%}/'xp·ide·source·parser·Lexer'/g' \
	> ./src/xp/ide/source/parser/$*Lexer.class.php && rm ./grammar/$*.lex.enc.php

parser.%:
	@echo "  * create /src/xp/ide/source/parser/$*Parser.class.php";
	@$(JAY) -cv < "./grammar/php.skl" ./grammar/$*.jay \
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

