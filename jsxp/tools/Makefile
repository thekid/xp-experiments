all:  node.js cscript.js

node.js:  src/node.js src/common.js
	$(CC) -E -Isrc -x c -P $< > $@

cscript.js:  src/cscript.js src/common.js
	$(CC) -E -Isrc -x c -P $< > $@

