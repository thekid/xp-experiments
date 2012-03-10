// {{{ Platform 
var global = this;
var fso = new ActiveXObject('Scripting.FileSystemObject');

var argv = new Array();
for (var i = 0; i < WScript.Arguments.Count(); i++) {
  argv.push(WScript.Arguments.Item(i));
}

var include = function(filename) {
  return fso.OpenTextFile(filename, 1).ReadAll();
}

global.out= {
  write : function(data) {
    WScript.StdOut.Write(data);
  },
  writeLine : function(data) {
    WScript.StdOut.Write(data);
    WScript.StdOut.WriteBlankLines(1);
  },
  writeLines : function(n) {
    WScript.StdOut.WriteBlankLines(n);
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
    
    eval(include(arguments[i].replace(/\./g, '/') + '.js'));
    global[arguments[i]]= it[names[n]]= eval(arguments[i]);
  }
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
