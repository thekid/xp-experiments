XP to JS compiler / JS mini-XP-runtime
======================================
This experiment tries to see whether the XP Framework could be based on
JavaScript runtimes in the future. Paired with the XP compiler, its PHP
language parser and a yet-to-be-created generator to emit JavaScript, and
maybe together with porting some of PHP's string and array functions, we
would be able to exchange the PHP platform we currently depend on for
something else.

Demo class
----------

```javascript
// {{{ Hello
Hello = define('Hello', 'lang.Object', function Hello () { });

Hello.main = function Hello$main(args) {
  if (args.length < 1) {
    throw new lang.IllegalArgumentException('Argument required');
  }
  util.cmd.Console.writeLine('Hello ', args[0]);
}
// }}}

```


NodeJS
------
Node.JS is the V8-based JavaScript engine which is becoming increasingly
popular. Even with its pre-1.0 status, sites such as GitHub use it in 
production.
See http://nodejs.org/

**Getting started**

```sh
$ node tools/node.js Hello "World"
Hello World
```

```sh
$ node tools/node.js Hello
*** Uncaught exception lang.IllegalArgumentException(Argument required)
  at Throwable(message) ("Argument required")
  at IllegalArgumentException(message) ("Argument required")
  at Hello.main(args) (array[0])
  at Method.invoke(obj, args) (null, array[1])
  at <main>

```



Windows Script Host
-------------------
Windows Script Host (WSH) is a language-independent scripting host for 
Windows Script compatible scripting engines. It is available on all stock
Windows installations.
See http://msdn.microsoft.com/en-us/library/ec0wcxh3(v=vs.85).aspx

**Getting started**

```sh
$ cscript /nologo tools/cscript.js Hello "World"
Hello World
```

```sh
$ cscript /nologo tools/cscript.js Hello 
*** Uncaught exception lang.IllegalArgumentException(Argument required)
  at Throwable(message) ("Argument required")
  at IllegalArgumentException(message) ("Argument required")
  at Hello.main(args) (array[0])
  at Method.invoke(obj, args) (null, array[1])
  at <main>
```


Setting up the compiler
-----------------------
You need the branch "node" of my xp-language for checked out:

```sh
$ git clone -b node git://github.com/thekid/xp-language.git xp.node
Cloning into xp.node...
[...]
```

Then, you need to add this to the `use` line in your **xp.ini** file. *This
file will usually be in ~/.xp/xp.ini or ~/bin/xp.ini.* Add the path to the
"compiler" subdirectory of the "xp.node" directory from above to the end
of this line, prefixed by the platform's path separator character. For 
example, this will work on Un*x platforms (in Windows, use semicolons):

```diff
-use=~/devel/xp/core:~/devel/xp/tools
+use=~/devel/xp/core:~/devel/xp/tools:~/devel/xp.node/compiler
```

You're all set to go.


Compiling
---------
To compile classes from XP language to XP JS, simply invoke the **xcc** 
command as follows:

```sh
$ xcc -e node Hello.xp
[.]
Done: 1/1 compiled, 0 failed
```

Then, run it as seen above.

