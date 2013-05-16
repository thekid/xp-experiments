BASE=$(shell cygpath "$(WINDIR)")
CSC?=$(BASE)/Microsoft.NET/Framework/v3.5/csc
CSC_OPT=/nologo

XP.Bind.dll:	Bind.cs
	$(CSC) $(CSC_OPT) /keyfile:keypair.snk /target:library /out:XP.Bind.dll Bind.cs

Test.dll:	Test.cs
	$(CSC) $(CSC_OPT) /keyfile:keypair.snk /target:library /out:Test.dll Test.cs

ImageProcessor.dll:	ImageProcessor.cs
	$(CSC) $(CSC_OPT) /keyfile:keypair.snk /target:library /out:ImageProcessor.dll ImageProcessor.cs

clean:
	rm *.dll
