
all: JLexPHP.jar

.PHONY: clean test

JLexPHP.jar: JLexPHP/Main.java
	javac JLexPHP/Main.java
	jar cvf JLexPHP.jar JLexPHP/*.class

clean:
	rm JLexPHP/*.class *.jar
	rm src/ExampleLexer.class.php

test: src/ExampleLexer.class.php
	@unittest -cp src unittest.ExampleLexerTest

src/ExampleLexer.class.php: Example.lex JLexPHP.jar
	@echo " ** create ExampleLexer"
	java -cp JLexPHP.jar JLexPHP.Main Example.lex
	@cat Example.lex.php \
	| sed -e 's/{%CLASSNAME%}/'ExampleLexer'/g' \
	| sed -e 's/{%PARENTNAME%}/'net·jaylex·JlexBase'/g' \
	> src/ExampleLexer.class.php && rm Example.lex.php
