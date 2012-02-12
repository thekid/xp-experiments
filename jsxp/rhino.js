// {{{ Platform 
var global= this;

var argv= arguments; 

global.out= {
  write : function(data) {
    java.lang.System.out.print(data);    
  },
  writeLine : function(data) {
    java.lang.System.out.println(data);
  },
  writeLines : function(n) {
    for (var i = 0; i < n; i++) {
      java.lang.System.out.println(); 
    }
  }
};

// }}}

global.stringOf= function(object) {
  var indent = arguments.length == 1 ? '  ' : arguments[1];
  switch (typeof(object)) {
    case 'string': return '"' + object + '"';
    case 'number': return object;
    case 'function': {
      r= "function {\n";
      for (var member in object) {
        r+= indent + member + ' : ' + object[member] + "\n";
      }
      return r + '}';
    }
    case 'object': {
      r= "object {\n";
      for (var member in object) {
        r+= indent + member + ' : ' + object[member] + "\n";
      }
      return r + '}';
    }
    default: throw new IllegalArgumentException('Unknown type ' + typeof(object));
  }
}

function uses() {
  for (var i= 0; i < arguments.length; i++) {
    if (typeof(global[arguments[i]]) === 'function') continue;

    var names = arguments[i].split('.');
    var it = global;
    for (var n= 0; n < names.length - 1; n++) {
      if (typeof(it[names[n]]) === 'undefined') it[names[n]]= {};
      it = it[names[n]];
    }
    
    load(arguments[i].replace(/\./g, '/') + '.js');
    global[arguments[i]]= it[names[n]]= eval(arguments[i]);
  }
}

Object.prototype.getClass = function() {
  return new lang.XPClass(this.__class);
}
Object.prototype.getClassName = function() {
  return this.__class;
}
Error.prototype.toString = function() {
  return 'Error<' + this.name + ': ' + this.message + '>';
}

Modifiers = function() { }
Modifiers.STATIC = 1;

uses('lang.XPClass', 'util.cmd.Console', 'lang.IllegalArgumentException');

try {
  clazz = argv.shift();
  lang.XPClass.forName(clazz).getMethod('main').invoke(null, [argv]);
} catch (e) {
  util.cmd.Console.writeLine('*** Uncaught exception ', e.toString());
}
