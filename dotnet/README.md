C# experiment
=============
Question: Can we compile certain parts of PHP to C# and the use that?

Prerequisites
-------------
We cannot dynamically load assemblies with PHP, and we cannot use the
`System.Reflection.Assembly` class' `LoadFrom` method as it is static.
Therefore, we need to create a wrapper library. 

This wrapper is what we call the **XP Binder** in this experiment. It's
currently a standalone registered assembly but may be provided by the
XP runners in the future.

Steps
-----
To test this experiment:

1. Compile XP Binder: `make XP.Bind.dll`
2. As user with elevated privileges, add this to the GAC:
   `"X:\Microsoft SDKs\Windows\v6.0\Bin\gacutil.exe" /i XP.Bind.dll`
3. Compile fixture: `make ImageProcessor.dll`
4. Run Test class: `xp Test`

Hacking XP Binder
-----------------
If you change the XP Binder, don't forget to reinstall it:

```
"X:\Microsoft SDKs\Windows\v6.0\Bin\gacutil.exe" /u XP.Bind
"X:\Microsoft SDKs\Windows\v6.0\Bin\gacutil.exe" /i XP.Bind.dll
```

Useful material
---------------
How to: Create a Public/Private Key Pair
http://msdn.microsoft.com/en-us/library/6f05ezxy.aspx

Using the .NET Assembly in PHP
http://www.devarticles.com/c/a/PHP/Using-the-.NET-Assembly-in-PHP/
