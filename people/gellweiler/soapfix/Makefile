
PREFIX=webservices.soap
POSTFIX=g1

PATCHFILE="patches/$(PREFIX)-$(REL)-$(POSTFIX).patch"
XARFILE="dists/$(PREFIX)-$(REL)-$(POSTFIX).xar"

all:
	@echo "* make patch REL=<dir>"
	@echo "  Generate patch for given XP release into patch directory (you need to have"
	@echo "  the XP release in the given directory)"
	@echo ""
	@echo "* make xar REL=<dir>"
	@echo "  Generate a XAR file with patch into dists directory"
	@echo ""

patch: rel-arg release-dir-exists
	@echo "==> Generating patch for $(REL) ..."
	@mkdir -p patches
	@(diff -ur --exclude="\*.svn" $(REL) src > $(PATCHFILE) || true )
	@ls -l $(PATCHFILE)
	@echo "==> Done."

xar: rel-arg release-dir-exists
	@echo "==> Generating XAR for $(REL) ..."
	@mkdir -p dists
	@( cd src && xar cf ../$(XARFILE) . )
	@ls -l $(XARFILE)
	@echo "==> Done."

rel-arg:
	@@if [ "$(REL)" = "" ] ; then \
	  echo "*** Please specify a release version using REL=<release>!" ; \
	  exit 1 ; \
	fi

release-dir-exists:
	@if [ ! -d $(REL) ] ; then \
	  echo "*** Put XP release into release directory $(REL)!" ; \
	  exit 1 ; \
	fi
