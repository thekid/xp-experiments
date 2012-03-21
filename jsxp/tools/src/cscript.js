/**
 * Windows scripting Host runtime
 *
 * @see http://msdn.microsoft.com/en-us/library/9bbdkx3k.aspx
 */

var global = this;
var fso = WScript.CreateObject('Scripting.FileSystemObject');
var wsh = WScript.CreateObject('WScript.Shell');

var _mgmts = null;
function winmgmts() {
  if (null === _mgmts) {
    global.out.writeLine("ACQUIRE MGMTS");
    _mgmts= GetObject('winmgmts://./root/cimv2');
  }
  return _mgmts;
}

// Command line arguments
var argv = new Array();
for (var i = 0; i < WScript.Arguments.Count(); i++) {
  argv.push(WScript.Arguments.Item(i));
}

// Filesystem
global.fs = {
  DIRECTORY_SEPARATOR : '\\',

  file : function(uri) {
    return fso.OpenTextFile(uri, 1).ReadAll().split("\n");
  },

  exists : function(uri) {
    return fso.FileExists(uri);
  },

  glob : function(uri, pattern) {
    var filtered= [];
    if (fso.FolderExists(uri)) {
      var files = new Enumerator(fso.GetFolder(uri).Files);
      while (!files.atEnd()) {
        var file = files.item();
        if (pattern.test(file.Name)) {
          filtered.push(file.Name);
        }
        files.moveNext();
      }
    }
    return filtered;
  }
};

var path = { };
path.join = function() {
  var path = '';
  for (var i = 0; i < arguments.length; i++) {
    if (typeof(arguments[i]) === 'string') path+= '\\' + arguments[i].replace(/(\/)/g, '\\');
  }
  return path.substring(1);
}

// Process
var process = { };
process.cwd = function() {
  return wsh.CurrentDirectory;
}
process.runtime = function() {
  return 'WScript ' + WScript.Version + '.' + WScript.BuildVersion;
}
process.os = function() {
  var os = new Enumerator(winmgmts().InstancesOf('Win32_OperatingSystem')).item();
  return os.Caption + os.Version + ' (' + os.OSArchitecture + ')';
}
process.memoryUsage = function() {
  return { rss: undefined };
}

process.env = wsh.Environment;
 
// STDIO
global.out= {
  write : function(data) {
    WScript.StdOut.Write(data);
  },
  writeLine : function(data) {
    WScript.StdOut.Write(data);
    WScript.StdOut.WriteBlankLines(1);
  }
};

// Loading
var include = function(filename) {
  try {
    eval(fso.OpenTextFile(filename, 1).ReadAll());
  } catch (e) {
    throw new Error(filename + ': ' + e.message);
  }
}

// Mimick (in an unsafe way) Object.defineProperty()
if (typeof(Object.defineProperty) === 'undefined') {
  Object.defineProperty= function(object, propertyname, descriptor) {
    object[propertyname]= descriptor.value;
  }
}

if (typeof(Array.prototype.indexOf) === 'undefined') {
  Array.prototype.indexOf= function(val) {
    for (var i in this) {
      if (this[i] === val) return i;
    }
    return -1;
  }
}
#include "common.js"
