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
