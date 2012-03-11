var fs = require('fs');

// {{{ File
io.File = function(uri) {
  {
    this.__class = 'io.File';
    this.uri = uri;
    this.fd = null;
  }
}

io.File.prototype= new lang.Object();

io.File.prototype.open = function(mode) {
  this.fd = fs.openSync(this.uri, mode);
}

io.File.prototype.isOpen = function() {
  return null !== this.fd;
}

io.File.prototype.read = function(max) {
  var b = new Buffer(max);
  var r = fs.readSync(this.fd, b, 0, max, null);
  return 0 === r ? null : b.slice(0, r);
}

io.File.prototype.close = function() {
  fs.closeSync(this.fd);
  this.fd = null;
}
// }}}
