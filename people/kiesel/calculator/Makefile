.PHONY: generate test

generate: grammar/mathematics.jay
	@echo "===> Generating parser..."
	@~/dev/xp.public/trunk/ports/technologies/opt/jay/generate.sh grammar/mathematics.jay php5 Expression > calc/ExpressionParser.class.php

test:
	@unittest unittest/*.php
