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

parser: \
  src/xp/ide/source/parser/ClassFileParser.class.php\
  src/xp/ide/source/parser/ClassParser.class.php

lexer: \
  src/xp/ide/source/parser/ClassLexer.class.php

test: parser lexer
	unittest xp.ide.**

src/xp/ide/source/parser/%Lexer.class.php: ./grammar/%.lex
	@iconv -f ISO-8859-15 -t UTF-8 $< > $<.enc
	@$(JLEX) $<.enc
	@rm $<.enc
	@cat $<.enc.php \
	| iconv -t ISO-8859-15 -f UTF-8 \
	| sed -e 's/{%CLASSNAME%}/'xp·ide·source·parser·$*Lexer'/g' \
	| sed -e 's/{%PARENTNAME%}/'xp·ide·source·parser·Lexer'/g' \
	> $@
	@rm ./grammar/$*.lex.enc.php

src/xp/ide/source/parser/%Parser.class.php: ./grammar/php.skl ./grammar/%.jay
	@$(JAY) -cv < $+ | sed -e 's/{%NAME%}/'$*Parser'/g' > $@
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

