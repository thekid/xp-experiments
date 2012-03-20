/**
 * NodeJS runtime
 *
 * @see http://nodejs.org/api/
 */

var fs = require('fs');
var path= require('path');

// Command line arguments
var argv= process.argv; 
argv.shift(); // node.exe
argv.shift(); // node.js

// Filesystem
fs.file = function(uri) {
  return fs.readFileSync(uri).toString().split("\n");
}
fs.exists = function(uri) {
  return path.existsSync(uri);
}

// STDIO
global.out= {
  write : function(data) {
    process.stdout.write(data + "");
  },
  writeLine : function(data) {
    process.stdout.write(data === undefined ? "\n" : data + "\n");
  },
};

// Loading
include = require;

#include "common.js"
