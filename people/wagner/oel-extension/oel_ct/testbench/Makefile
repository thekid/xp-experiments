OEL=./bin/test_oel
PHP=./bin/test_php
OEL_RESULT=/tmp/oel_test
PHP_RESULT=/tmp/oel_php_test
DIFF_RESULT=/tmp/oel_test.diff
DIFF_PARAM=-b
ALL_RESULT=/tmp/oel_all_test

RED=\\033[31m
GREEN=\\033[32m

TEST= echo -n "        testing "`basename $$t | sed s/.oel.php//`" ..."; \
	if [ -f $$t ]; then \
		sh ${OEL} $$t 1>${OEL_RESULT} 2>&1;\
		echo -n "... "; \
		sh ${PHP} `echo $$t | sed s/.oel.php/.php/` 1>${PHP_RESULT} 2>&1 ; \
		diff ${DIFF_PARAM} ${OEL_RESULT} ${PHP_RESULT} > ${DIFF_RESULT}; \
		if [ "`stat -nf %z ${DIFF_RESULT}`" -gt "0" ]; then \
			echo -e ${RED}"FAILED"; tput reset; \
			echo " ========>>> "$$t":" >> ${ALL_RESULT}; \
			cat ${DIFF_RESULT} >> ${ALL_RESULT}; \
			echo "" >> ${ALL_RESULT}; \
			echo "" >> ${ALL_RESULT}; \
		else \
			echo -e ${GREEN}"OK"; tput reset; \
		fi; \
	else \
		echo -e ... ${RED}"no test found"; tput reset; \
	fi;
TEST_PREPARE= echo " ==> start test"; \
	echo -n "" > ${OEL_RESULT}; \
	echo -n "" > ${PHP_RESULT}; \
	echo -n "" > ${DIFF_RESULT}; \
	echo -n "" > ${ALL_RESULT}; 
TEST_END= echo ""; \
	echo ""; \
	if [ "`stat -nf %z ${ALL_RESULT}`" -gt "0" ]; then \
		echo "==> errors:"; \
		cat ${ALL_RESULT}; \
	fi; \
	rm ${ALL_RESULT} ${OEL_RESULT} ${PHP_RESULT} ${DIFF_RESULT};


all:
	@echo "Usage:"; \
	echo "----------------------------------"; \
	echo "$(MAKE) test:"; \
	echo "   test all"; \
	echo ""; \
	echo "$(MAKE) test.X:"; \
	echo "  test only section X"; \
	for s in ./tests/*; do \
		echo "  - test."`basename $$s`; \
	done; \
	echo "";

test:
	@$(TEST_PREPARE) \
	for s in ./tests/*; do \
		echo " ===> testing "`basename $$s`; \
		for t in $$s/*.oel.php; do \
			$(TEST) \
		done; \
	done; \
	$(TEST_END)

test.%:
	@$(TEST_PREPARE) \
	echo " ===> testing "`basename $*`; \
	for t in ./tests/$*/*.oel.php; do \
		$(TEST) \
	done; \
	$(TEST_END)
