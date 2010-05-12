OVERLAY_VERSION=0.0.1

test:
	IFS=$$'\n' ; for i in `xp -cp tools AllTests` ; do echo $$i ; unittest $$i ; done
	rm sess_* # Damn PHP session

diff:
	@if [ ! -e "$(XP_BASE)"/boot.pth ] ; then \
	  echo "*** Incorrect xp base path $(XP_BASE)" ; \
	  exit 1 ; \
	fi
	@diff -ur -x .svn "$(XP_BASE)" overlay | grep -v "^Only in"

ovl:
	cd overlay/skeleton && xar cvf ../../dist/xp-unicode-ovl-$(OVERLAY_VERSION).xar .
	cp overlay/tools/*.php dist/
