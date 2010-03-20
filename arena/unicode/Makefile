test:
	IFS=$$'\n' ; for i in `xp -cp tools AllTests` ; do echo $$i ; unittest $$i ; done
	rm sess_* # Damn PHP session
