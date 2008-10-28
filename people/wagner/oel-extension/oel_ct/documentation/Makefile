XSLT_PROC=`/usr/bin/which xsltproc`
DOCU_XML=source/OEL_Reference.xml
DOCU_XSL=source/$*_oel.xsl

all:
	@echo "build oel extension docu"; \
	echo ""; \
	echo "Usage:"; \
	echo "----------------------------------"; \
	echo "builds documentation:"; \
	echo "$(MAKE) docu.html"; \
	echo "";

docu.%:
	@echo " ==> build docu $*"; \
	$(XSLT_PROC) ${DOCU_XSL} ${DOCU_XML} > oel_ref.$*;
