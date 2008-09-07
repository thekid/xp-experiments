XP_PUBLIC_PATH=$(shell php -r "include_once('lang.base.php'); echo dirname(ClassLoader::getDefault()->findPackage('lang')->path);")

all:
	@echo "Usage:"; \
	echo "  ${MAKE} parser"; \
	echo "    - build oel/Parser.class.php from grammar/oelcalc.jay"; \

help: all

parser:
	@sh $(XP_PUBLIC_PATH)/ports/technologies/opt/jay/generate.sh ./grammar/oelcalc.jay php5 'oel·' > ./oel/Parser.class.php; \
	rm ./y.output
