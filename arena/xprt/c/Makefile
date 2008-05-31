CC=cc -Wall -I.
ifneq ($(uname | grep -i "cygwin"), "")
EXE_EXT=.exe
endif
BINARIES=xp$(EXE_EXT) xpcli$(EXE_EXT) xar$(EXE_EXT) unittest$(EXE_EXT) xp-bin-$(VERSION)-cygwin.zip

all: xp xpcli xar unittest
    
clean:
	-rm $(BINARIES)

xp:
	$(CC) xp.c xprt.c -o xp$(EXE_EXT)

xpcli:
	$(CC) xpcli.c xprt.c -o xpcli$(EXE_EXT)

xar:
	$(CC) xar.c xprt.c -o xar$(EXE_EXT)

unittest:
	$(CC) unittest.c xprt.c -o unittest$(EXE_EXT)

release.cygwin: all
	cp /bin/cygwin1.dll cygwin1.dll
	zip xp-bin-$(VERSION)-cygwin.zip cygwin1.dll $(BINARIES) *.php
	rm cygwin1.dll 
