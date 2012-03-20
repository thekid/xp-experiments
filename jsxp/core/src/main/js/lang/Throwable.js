// {{{ Throwable
lang.Throwable = define('lang.Throwable', null, function Throwable(message) { 
  this.message = message;
  this.fillInStacktrace();
});

lang.Throwable.prototype= Error.prototype;

// root-trait
lang.Throwable.prototype.getClass = function Throwable$getClass() {
  return new lang.XPClass(this.__class);
}
lang.Throwable.prototype.getClassName = function Throwable$getClassName() {
  return this.__class;
}
lang.Throwable.prototype.equals = function Throwable$equals(cmp) {
  return this == cmp;
}
// root-trait

lang.Throwable.prototype.message = '';
lang.Throwable.prototype.stacktrace = new Array();

lang.Throwable.prototype.getMessage = function Throwable$getMessage() {
  return this.message;
}

lang.Throwable.prototype.stringOf = function Throwable$stringOf(arg) {
  switch (typeof(arg)) {
    case 'number': return arg;
    case 'boolean': return arg ? 'true' : 'false';
    case 'string': {
      var cut = arg.indexOf("\n");
      cut = cut < 0 ? 0x40 : Math.min(cut, 0x40);
      return '"' + (arg.length > cut ? arg.substring(0, cut) + '...' : arg) + '"';
    }
    case 'object': {
      if (null === arg) {
        return 'null';
      } else if (arg instanceof Array) {
        return 'array[' + arg.length + ']';
      } else if (arg.__class === undefined) {
        return Object.prototype.toString.call(arg);
      } else {
        return arg.__class + '{}';
      }
    }
  }
  return typeof(arg);
}

lang.Throwable.prototype.fillInStacktrace = function Throwable$fillInStacktrace() {
  var current= arguments.callee.caller;
  var seen= [];
  while (current && current !== global.__main) {
    var f= current.toString();
    var a= '';
    for (var i= 0; i < current.arguments.length; i++) {
      a += ', ' + this.stringOf(current.arguments[i]);
    }
    this.stacktrace.push((f.substring(0, f.indexOf('{')) || '<anonymous>') + '(' + a.substring(2) + ')');
    seen.push(current);
    current = current.caller;
    if (seen.indexOf(current)) break;   // Prevent endless loop
  }
}

lang.Throwable.prototype.toString = function Throwable$toString() {
  var r = this.__class + '(' + this.message + ")\n";
  for (var i= 0; i < this.stacktrace.length; i++) {
    r += '  at ' + this.stacktrace[i] + "\n";
  }
  r += '  at <main>';
  return r;
}
// }}}
