.PHONY: generate test

generate: calc/ExpressionParser.class.php
test: calc/ExpressionParser.class.php
	@echo "===> Running testsuite"
	@unittest unittest/*.php

calc/ExpressionParser.class.php: grammar/mathematics.jay
	@echo "===> Generating parser"
	@~/dev/xp.public/trunk/ports/technologies/opt/jay/generate.sh grammar/mathematics.jay php5 Expression > calc/ExpressionParser.class.php

