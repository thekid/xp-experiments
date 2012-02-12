XP to JS compiler / JS mini-XP-runtime
======================================

Demo class
----------

```javascript
Hello = function() {
  {
    this.__class = 'Hello';
  }
}

Hello.prototype = new Object();

Hello.main = function(args) {
  if (args.length < 1) {
    throw new lang.IllegalArgumentException('Argument required');
  }
  util.cmd.Console.writeLine('Hello ', args[0]);
}
```


NodeJS
------
Node.JS is the V8-based JavaScript engine which is becoming increasingly
popular. Even with its pre-1.0 status, sites such as GitHub use it in 
production.
See http://nodejs.org/

**Getting started**

```sh
$ node node.js Hello "World"
Hello World
```

```sh
$ node node.js Hello
*** Uncaught exception lang.IllegalArgumentException(Argument required)
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
$ cscript /nologo cscript.js Hello World
Hello World
```

```sh
$ cscript /nologo cscript.js Hello 
*** Uncaught exception IllegalArgumentException(Argument required)
  at function IllegalArgumentException(message)
  at function(args)
  at function(obj, args)
  at <main>
```

Rhino
-----
Rhino is an open-source implementation of JavaScript written entirely in 
Java. Rhino is available for any platform Java is available for.
See http://www.mozilla.org/rhino/

**Getting started**

```sh
$ rhino rhino.js Hello World
Hello World
```

```sh
$ rhino rhino.js Hello 
*** Uncaught exception IllegalArgumentException(Argument required)
  at <main>
```

