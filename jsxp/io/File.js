uses('io.FileNotFoundException');

var fs = require('fs');

// {{{ File
io.File = function(uri) {
  {
    if (typeof(this.__class) === 'undefined') this.__class = 'io.File';
    this.uri = uri;
    this.fd = null;
  }
}

extend(io.File, lang.Object);

io.File.prototype.open = function(mode) {
  try {
    this.fd = fs.openSync(this.uri, mode);
  } catch (e) {
    if ('ENOENT' === e.code) {
      throw new io.FileNotFoundException(e.path);
    } else {
      throw new io.IOException('Cannot open, mode "' + mode + '"', e);
    }
  }
}

io.File.prototype.isOpen = function() {
  return null !== this.fd;
}

io.File.prototype.read = function(max) {
  var b = new Buffer(max);
  var r = fs.readSync(this.fd, b, 0, max, null);
  return 0 === r ? false : b.slice(0, r);
}

io.File.prototype.close = function() {
  if (null === this.fd) return;

  fs.closeSync(this.fd);
  this.fd = null;
}
// }}}
