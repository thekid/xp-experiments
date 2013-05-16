CSC?=/cygdrive/c/Windows/Microsoft.NET/Framework/v3.5/csc

all: xccli.exe

xccli.exe: xcclilib.dll Runner.cs
	$(CSC) /out:xccli.exe /target:exe /R:xcclilib.dll Runner.cs

xcclilib.dll: Command.cs Arg.cs AssemblyInfo.cs
	$(CSC) /out:xcclilib.dll /target:library Command.cs Arg.cs AssemblyInfo.cs

clean:
	-rm xccli.exe xcclilib.dll
