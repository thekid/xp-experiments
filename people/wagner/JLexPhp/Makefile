
all: JLexPHP.jar

.PHONY: clean test

JLexPHP.jar: JLexPHP/Main.java
	javac JLexPHP/Main.java
	jar cvf JLexPHP.jar JLexPHP/*.class

clean:
	rm JLexPHP/*.class *.jar
	rm ExampleLexer.class.php

test: ExampleLexer.class.php
	@unittest ExampleLexerTest

ExampleLexer.class.php: Example.lex JLexPHP.jar
	@echo " ** create ExampleLexer"
	java -cp JLexPHP.jar JLexPHP.Main Example.lex
	@cat Example.lex.php \
	| sed -e 's/{%CLASSNAME%}/'ExampleLexer'/g' \
	| sed -e 's/{%PARENTNAME%}/'JlexBase'/g' \
	> ExampleLexer.class.php && rm Example.lex.php
