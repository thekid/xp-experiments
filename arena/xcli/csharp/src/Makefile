CSC?=/cygdrive/c/Windows/Microsoft.NET/Framework/v3.5/csc

all: xxcli.exe

xxcli.exe: xxclilib.dll Runner.cs
	$(CSC) /out:xxcli.exe /target:exe /R:xxclilib.dll Runner.cs

xxclilib.dll: Command.cs Arg.cs AssemblyInfo.cs
	$(CSC) /out:xxclilib.dll /target:library Command.cs Arg.cs AssemblyInfo.cs

clean:
	-rm xxcli.exe xxclilib.dll
