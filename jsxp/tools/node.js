var fs = require('fs');
var path= require('path');
var os= require('os');
var argv= process.argv;
argv.shift();
argv.shift();
global.fs = {
  DIRECTORY_SEPARATOR : path.normalize('/'),
  file : function(uri) {
    return fs.readFileSync(uri).toString().split("\n");
  },
  exists : function(uri) {
    return path.existsSync(uri);
  },
  glob : function(uri, pattern) {
    var filtered = [];
    if (path.existsSync(uri)) {
      var files = fs.readdirSync(uri);
      for (var i = 0; i < files.length; i++) {
        if (pattern.test(files[i])) {
          filtered.push(files[i].substring(files[i].lastIndexOf(global.fs.DIRECTORY_SEPARATOR)));
        }
      }
    }
    return filtered;
  }
};
global.out= {
  write : function(data) {
    process.stdout.write(data + "");
  },
  writeLine : function(data) {
    process.stdout.write(data === undefined ? "\n" : data + "\n");
  },
};
process.runtime = function() {
  return 'Node ' + process.versions.node + ' & V8 ' + process.versions.v8;
}
process.os = function() {
  return os.type() + ' ' + os.release() + ' (' + os.arch() + ')';
}
include = require;
global.version= "0.5.12";
function scanpath(paths, home) {
  var inc= [];
  for (p= 0; p < paths.length; p++) {
    var lines= global.fs.file(path.join(paths[p], 'class.pth'));
    for (i= 0; i < lines.length; i++) {
      line= lines[i];
      if ('' === line || '#' === line[0]) {
        continue;
      } else if ('!' === line[0]) {
        pre= true;
        line= line.substring(1);
      } else {
        pre= false;
      }
      if ('~' === line[0]) {
        line= line.substring(1);
        base= home;
      } else if ('/' === line[0] || ':' === line[1] && '\\' === line[2]) {
        base= null;
      } else {
        base= paths[p];
      }
      qn= path.join(base, line);
      pre ? inc.unshift(qn) : inc.push(qn);
    }
  }
  return inc;
}
global.classpath= scanpath([process.cwd()], process.env['HOME']);
global.classpath.push(process.cwd());
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
      if (null === object) {
        return 'null';
      } else if (object.__class === undefined) {
        r= "object {\n";
        for (var member in object) {
          r+= indent + member + ' : ' + stringOf(object[member], indent + '  ') + "\n";
        }
        return r + '}';
      } else {
        r= object.__class + " {\n";
        for (var member in object) {
          if (typeof(object[member]) !== 'function') {
            r+= indent + member + ' : ' + stringOf(object[member], indent + '  ') + "\n";
          }
        }
        return r + '}';
      }
    }
    default: throw new lang.IllegalArgumentException('Unknown type ' + typeof(object));
  }
}
global.uses= function uses() {
  for (var i= 0; i < arguments.length; i++) {
    if (typeof(global[arguments[i]]) === 'function') continue;
    var names = arguments[i].split('.');
    var it = global;
    for (var n= 0; n < names.length - 1; n++) {
      if (typeof(it[names[n]]) === 'undefined') it[names[n]]= {};
      it = it[names[n]];
    }
    for (var c= 0; c < global.classpath.length; c++) {
      var fn = path.join(global.classpath[c], arguments[i].replace(/\./g, '/') + '.js');
      if (!global.fs.exists(fn)) continue;
      include(fn);
      global[arguments[i]]= it[names[n]]= eval(arguments[i]);
      if (typeof(it[names[n]]['__static']) === 'function') {
        it[names[n]].__static();
      }
    }
  }
}
global.define= function define(name, parent, construct) {
  global[name] = construct || new Function;
  global[name].__class = name;
  if (null !== parent) {
    extend(global[name], global[parent]);
  }
  global[name].prototype.__class = name;
  return global[name];
}
global.extend= function extend(self, parent) {
  var helper = new Function;
  helper.prototype = parent.prototype;
  var proto = new helper;
  self.prototype = proto;
  self.prototype.__super = parent;
}
global.cast= function cast(value, type) {
  if ('int' === type) {
    return parseInt(value);
  } else if ('double' === type) {
    return parseFloat(value);
  } else if ('string' === type) {
    return String(value);
  } else if ('bool' === type) {
    return !!value;
  } else if (type.endsWith('[]')) {
    return typeof(value) === 'Array' ? value : [value];
  } else if (type.startsWith('[')) {
    if (typeof(value) === 'Function') return value;
    throw new Error('Cannot cast ' + value + ' to ' + type);
  } else {
    if (value instanceof type) return value;
    throw new Error('Cannot cast ' + value + ' to ' + type);
  }
}
Error.prototype.toString = function() {
  return 'Error<' + this.name + ': ' + this.message + '>';
}
uses('lang.Object', 'lang.XPClass', 'util.cmd.Console', 'lang.IllegalArgumentException');
global.__main= function __main() {
  try {
    clazz = argv.shift() || 'xp.runtime.Version';
    lang.XPClass.forName(clazz).getMethod('main').invoke(null, [argv]);
  } catch (e) {
    util.cmd.Console.writeLine('*** Uncaught exception ', e.toString());
  }
}
global.__main();
