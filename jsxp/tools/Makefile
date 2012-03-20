all:  node.js cscript.js 

node.js:  src/node.js src/common.js src/macros.h
	$(CC) -E -Isrc -x c -P -imacros src/macros.h $< > $@

cscript.js:  src/cscript.js src/common.js src/macros.h
	$(CC) -E -Isrc -x c -P -imacros src/macros.h $< > $@

