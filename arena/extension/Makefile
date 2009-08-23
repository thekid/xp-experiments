all:
	@echo "===> Running tests"
	@$(MAKE) test
	@echo ""
	@echo "===> Profiling"
	@$(MAKE) profile
    
test:
	unittest tests.ArrayListExtensionTest
    
profile:
	xpcli -cp lib/profiler.xar Profile tests.ExtensionMethodPerformance
