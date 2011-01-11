// {{{ Platform 
var $xp= this;

var argv= arguments; 

var include = function(filename) {
  return readFile(filename);		// XXX: Use load(filename)!  
}

$xp.out= {
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

$xp.stringOf= function(object) {
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
  var name;
  for (var i= 0; i < arguments.length; i++) {
    name = arguments[i].substring(arguments[i].lastIndexOf('.')+ 1, arguments[i].length);
    if (typeof($xp[name]) === 'function') continue;

    eval(include(arguments[i].replace(/\./g, '/') + '.js'));
    $xp[name]= eval(name);
  }
}

Object.prototype.getClass = function() {
  return new XPClass(this.__class);
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
  XPClass.forName(clazz).getMethod('main').invoke(null, [argv]);
} catch (e) {
  Console.writeLine('*** Uncaught exception ', e.toString());
}
