/**
 * NodeJS runtime
 *
 * @see http://nodejs.org/api/
 */

var fs = require('fs');
var path= require('path');
var os= require('os');

// Command line arguments
var argv= process.argv; 
argv.shift(); // node.exe
argv.shift(); // node.js

// Filesystem
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

// STDIO
global.out= {
  write : function(data) {
    process.stdout.write(data + "");
  },
  writeLine : function(data) {
    process.stdout.write(data === undefined ? "\n" : data + "\n");
  },
};

// Process
process.runtime = function() {
  return 'Node ' + process.versions.node + ' & V8 ' + process.versions.v8;
}
process.os = function() {
  return os.type() + ' ' + os.release() + ' (' + os.arch() + ')';
}

// Loading
include = require;

#include "common.js"
